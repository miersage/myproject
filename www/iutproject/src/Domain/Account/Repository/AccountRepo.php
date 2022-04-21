<?php

namespace App\Domain\Account\Repository;

use DomainException;
use PDO;

/**
 * Repository.
 */
class AccountRepo
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert account row.
     * @param array<mixed> $account The account
     * @throws DomainException
     * @return int The new account Id
     */
    public function insertAccount(array $account): int
    {
        $params = [
            'login' => $account['login'],
            'password' => $account['password'],
            'email' => $account['email'],
        ];
        $sql = "INSERT INTO account(login, password, email)
                VALUES (:login,:password,:email);";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute($params);

        if (!$ok) {
            throw new DomainException(sprintf('Account not created'));
        }
    
        return (int)$this->connection->lastInsertId();
    }

    /**
     * Get account by the given account id.
     * @param int $accountId The account id
     * @throws DomainException
     * @return array The account row
     */
    public function getAccountById(int $accountId): array
    {
        $sql = "SELECT accountId, login, password, email, status FROM account WHERE accountId = :id;";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $accountId]);
        $row = $stmt->fetch();
        //$stmt->closeCursor();

        if (!$row) {
            throw new DomainException(sprintf('Account Id not found: %s', $accountId));
        }

        return $row;
    }

    /**
     * Get account by the login.
     * @param int $accountId The account id
     * @throws DomainException
     * @return array The account row
     */
    public function getAccountByLogin(String $login): array
    {
        $sql = "SELECT accountId, login, password, email, status FROM account WHERE login = :login;";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['login' => $login]);
        $row = $stmt->fetch();
        //$stmt->closeCursor();

        if (!$row) {
            throw new DomainException(sprintf('Account login not found: %s', $login));
        }

        return $row;
    }

    /**
     * Get account list.
     * @throws DomainException
     * @return array account list
     */
    public function getAccountList(): array
    {
        $sql = "SELECT accountId, login, password, email, status FROM account ORDER BY accountId;";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = Array();
        $int  = 100;
        while (($row = $stmt->fetch()) && $int > 0) {
            $rows[] = $row;
            $int--;
        }

        return $rows;
    }

    /**
     * Update account by the given account id.
     * @param int $accountId The account id
     * @param array<mixed> $account The account
     * @throws DomainException
     * @return int Account Id
     */
    public function updateAccountById(int $accountId, array $account): int
    {
        $params = [
            'accountId' => $accountId,
            'login' => $account['login'],
            'password' => $account['password'],
            'email' => $account['email'],
        ];

        $sql = "UPDATE account SET login=:login, password=:password, email=:email WHERE accountId=:accountId;";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute($params);

        if (!$ok) {
            throw new DomainException(sprintf('Account Id not updated: %s', $accountId));
        }

        return $accountId;
    }

    /**
     * Delete account by the given account id.
     * @param int $accountId The account id
     * @throws DomainException
     * @return int Account Id
     */
    public function deleteAccountById(int $accountId): int
    {
        $sql = "DELETE FROM account WHERE accountId = :id;";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute(['id' => $accountId]);

        if (!$ok) {
            throw new DomainException(sprintf('Account Id not deleted: %s', $accountId));
        }

        return $accountId;
    }
}
