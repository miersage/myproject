<?php

namespace App\Domain\Account\Service;

use App\Domain\Account\Data\AccountReadResult;
use App\Domain\Account\Repository\AccountRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class AccountDelete
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
     * Delete account by the given account id.
     *
     * @param int $accountId The account id
     *
     * @throws ValidationException
     *
     * @return int Account Id
     */
    public function deleteAccount(int $accountId): int
    {
        // Input validation
        if (empty($accountId)) {
            throw new ValidationException('Account Id required');
        }

        $result = $this->repository->deleteAccountById($accountId);

        return $result;
    }
}