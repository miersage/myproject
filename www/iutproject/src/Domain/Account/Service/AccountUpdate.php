<?php

namespace App\Domain\Account\Service;

use App\Domain\Account\Data\AccountReadResult;
use App\Domain\Account\Repository\AccountRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class AccountUpdate
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
     * Update account by the given account id.
     *
     * @param int $accountId The account id
     * @param array<mixed> $data The form data
     *
     * @throws ValidationException
     *
     * @return int Account Id
     */
    public function updateAccountById(int $accountId, array $data): int
    {
        // Input validation
        if (empty($accountId)) {
            throw new ValidationException('Account Id required');
        }
        $this->validateNewAccount($data);

        $result = $this->repository->updateAccountById($accountId, $data);

        return $result;
    }

    /**
     * Input validation.
     *
     * @param array<mixed> $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewAccount(array $data): void
    {
        $errors = [];

        if (empty($data['login'])) {
            $errors['login'] = 'Input required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}