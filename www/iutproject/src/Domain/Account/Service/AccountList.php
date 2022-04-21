<?php

namespace App\Domain\Account\Service;

use App\Domain\Account\Data\AccountReadResult;
use App\Domain\Account\Repository\AccountRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class AccountList
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
     * List accounts.
     *
     * @throws ValidationException
     *
     * @return array AccountReadResult account list
     */
    public function getAccountList(): array
    {
        // Input validation
        // To see : Limit the rows

        $accountRows = $this->repository->getAccountList();

        // Map array to data object
        $accounts = Array();
        foreach ($accountRows as $accountRow) {
            $account = new AccountReadResult();
            $account->accountId = (int)$accountRow['accountId'];
            $account->login = (string)$accountRow['login'];
            $account->password = (string)$accountRow['password'];
            $account->email = (string)$accountRow['email'];
            $account->status = (int)$accountRow['status'];
    
            $accounts[] = $account;
        };
        return $accounts;
    }
}