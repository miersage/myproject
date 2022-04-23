<?php

namespace App\Domain\Account\Service;

use App\Domain\Account\Data\AccountReadResult;
use App\Domain\Account\Repository\AccountRepo;
use App\Exception\ValidationException;
use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;

function read_cb($ch, $fp, $length) {
    return fread($fp, $length);
}

/**
 * Service.
 */
final class AccountMethod
{
    /**
     * @var AccountRepo
     */
    private $repository;
    private $settings;

    /**
     * The constructor.
     *
     * @param AccountRepo $repository The repository
     * @param SettingsInterface $settings
     */
    public function __construct(AccountRepo $repository, SettingsInterface $settings)
    {
        $this->repository = $repository;
        $this->settings = $settings->get('smtp');
    }

    /**
     * do method
     * @param array $params The route arguments
     * @throws ValidationException
     * @return int
     */
    public function doAccountMethod(array $params): int
    {
        $result = 0;
        // Input validation
        $accountMethod = $params[0];

        if ($accountMethod == 'confirm') {
            $accountId = (int)$params[1];
            $result = $this->confirm($accountId);
        } elseif ($accountMethod == 'activate') {
            $accountId = (int)$params[1];
            $activeCode = (string)$params[2];
            $result = $this->activate($accountId, $activeCode);
        } else {
            throw new ValidationException('Account method unknown');
        }

        return $result;
    }

    /**
     * do method
     * @param int $accountId
     * @throws ValidationException
     * @return int
     */
    private function confirm(int $accountId): int
    {
        // Send a mail to (re)validate the registration
        //  support a forgotten password.

        // require php-curlib

        // try {
        // } catch (Exception $e) {
        // };

        // Read the account
        $account = $this->repository->getAccountById($accountId);

        // Build the email
        $settings = $this->settings;
        $code = random_bytes(16);
        $code[6] = chr(ord($code[6]) & 0x0f | 0x40); // set version to 0100
        $code[8] = chr(ord($code[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        $code = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($code), 4));
        $link = 'http://' . $_SERVER['SERVER_NAME'] . '/api/accountM/activate/' . $accountId . '/' . $code;

        $fp = fopen('php://memory', 'r+');
        $string = "From: <".$settings['from'].">\r\n";
        $string .= "To: <".(string)$account['email'].">\r\n";
        $string .= "Date: " . date('r') . "\r\n";
        $string .= "Subject: [iutproject] please, activate your account\r\n";
        $string .= "\r\n";
        $string .= "Hello,\r\n";
        $string .= "Please, click to the following link to activate you account\r\n";
        $string .= $link . "\r\n";
        $string .= "\r\n";
        fwrite($fp, $string);
        rewind($fp);
        
        // get a curl handler
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $settings['url'],
            CURLOPT_MAIL_FROM => '<'.$settings['from'].'>',
            CURLOPT_MAIL_RCPT => ['<'.(string)$account['email'].'>'],
            CURLOPT_USERNAME => $settings['username'],
            CURLOPT_PASSWORD => $settings['password'],
            CURLOPT_USE_SSL => CURLUSESSL_ALL,
            CURLOPT_READFUNCTION => 'read_cb',
            CURLOPT_INFILE => $fp,
            CURLOPT_UPLOAD => true,
            CURLOPT_VERBOSE => true,
        ]);
        
        $res = curl_exec($ch);
        if ($res === false) {
            echo curl_errno($ch) . ' = ' . curl_strerror(curl_errno($ch)) . PHP_EOL;
        }
        
        curl_close($ch);
        fclose($fp);

        // Update account. status = waiting activation until the expiration date.
        $data = [];
        $data['status'] = 2; // waiting activation
        $data['activeCode'] = $code;
        $data['activeExpireDate'] = date('Y-m-d H:i:s', strtotime(' + 3 days'));
        $result = $this->repository->updateAccountById($accountId, $data);
 
        return $accountId;
    }

    /**
     * do method
     * @param int $accountId
     * @param string $activeCode
     * @throws ValidationException
     * @return int
     */
    private function activate(int $accountId, string $activeCode): int
    {
        // (re)activate an account

        // try {
        // } catch (Exception $e) {
        // };

        // Read the account
        $account = $this->repository->getAccountById($accountId);

        if ( ($account['status'] != 2)
            || (!password_verify($activeCode, $account['activeCode'])) ){
            throw new ValidationException(sprintf('Unable to activate the account: %s', $accountId));
        } elseif ( strtotime($account['activeExpireDate'])  < strtotime(date('Y-m-d H:i:s')) ) {
            throw new ValidationException(sprintf('activation date expired for the account: %s', $accountId));
        }

        // Update account. status = activated.
        $data = [];
        $data['status'] = 4; // Activated
        $data['activeCode'] = "";
        $data['activeExpireDate'] = date('Y-m-d H:i:s');
        $result = $this->repository->updateAccountById($accountId, $data);
 
        return $accountId;
    }
}