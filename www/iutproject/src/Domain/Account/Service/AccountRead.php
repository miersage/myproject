<?php

namespace App\Domain\Account\Service;

use App\Domain\Account\Data\AccountReadResult;
use App\Domain\Account\Repository\AccountRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class AccountRead
{
    /**
     * @var AccountRepo
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AccountRepo $repository The repository
     */
    public function __construct(AccountRepo $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read account according to parameters.
     * @param array<mixed> $accountPrm
     * @throws ValidationException
     * @return AccountReadResult The account data
     */
    public function getAccountDetails(array $accountPrm): AccountReadResult
    {
        // Input validation
        $accountId = $accountPrm['accountId'];
        $login = $accountPrm['login'];
        if (isset($accountId) && !empty($accountId)) {
            $accountRow = $this->repository->getAccountById($accountId);
        } elseif (isset($login) && !empty($login)) {
            $accountRow = $this->repository->getAccountByLogin($login);
        } else {
            throw new ValidationException('Account key required');
        }

        // Map array to data object
        $account = new AccountReadResult();
        $account->accountId = (int)$accountRow['accountId'];
        $account->login = (string)$accountRow['login'];
        $account->password = (string)$accountRow['password'];
        $account->email = (string)$accountRow['email'];
        $account->status = (int)$accountRow['status'];
        $account->activeCode = (string)$accountRow['activeCode'];
        $account->activeExpireDate = (string)$accountRow['activeExpireDate'];

        return $account;
    }
}