<?php

namespace App\Domain\Account\Service;

use App\Domain\Account\Repository\AccountRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class AccountCreate
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
     * Create a new account.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new account Id
     */
    public function createAccount(array $data): int
    {
        // Input validation
        $this->validateNewAccount($data);

        // Insert account
        $accountId = $this->repository->insertAccount($data);

        // Logging here: Account created successfully
        //$this->logger->info(sprintf('Account created successfully: %s', $accountId));

        return $accountId;
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
            $errors['login'] = 'login required';
            $errMessage = 'login required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'email required';
            $errMessage = 'email required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
            $errMessage = 'Invalid email address';
        }

        if ($errors) {
            throw new ValidationException($errMessage, $errors);
        }
    }
}