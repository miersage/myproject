<?php

namespace App\Domain\TaskList\Repository;

use DomainException;
use PDO;

/**
 * Repository.
 */
class TaskListRepo
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
     * Insert taskList row.
     * @param array<mixed> $taskList The taskList
     * @throws DomainException
     * @return int The new taskList Id
     */
    public function insertTaskList(array $taskList): int
    {
        $into = "";
        $values = "";
        $params = [];

        if (isset($taskList['accountId'])) {
            $params['accountId'] = $taskList['accountId'];
            $into .= ", accountId";
            $values .= ", :accountId";
        }
        if (isset($taskList['taskListName'])) {
            $params['taskListName'] = $taskList['taskListName'];
            $into .= ", taskListName";
            $values .= ", :taskListName";
        }
        if (isset($taskList['status'])) {
            $params['status'] = $taskList['status'];
            $into .= ", status";
            $values .= ", :status";
        }

        if (!strlen($into)) {
            throw new DomainException(sprintf('TaskList not created'));
        }

        $into = substr($into, 1);
        $values = substr($values, 1);
        $sql = "INSERT INTO taskList( " . $into . " )
                VALUES ( " . $values . " );";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute($params);

        if (!$ok) {
            throw new DomainException(sprintf('TaskList not created'));
        }
    
        return (int)$this->connection->lastInsertId();
    }

    /**
     * Get taskList by the given taskList id.
     * @param int $taskListId The taskList id
     * @throws DomainException
     * @return array The taskList row
     */
    public function getTaskListById(int $taskListId): array
    {
        $sql = "SELECT taskListId, accountId, taskListName, status FROM taskList WHERE taskListId = :id;";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $taskListId]);
        $row = $stmt->fetch();
        //$stmt->closeCursor();

        if (!$row) {
            throw new DomainException(sprintf('TaskList Id not found: %s', $taskListId));
        }

        return $row;
    }

    /**
     * Get taskLists by account id.
     * @param int $accountId The account id
     * @throws DomainException
     * @return array The taskList rows
     */
    public function getTaskListByAccount(int $accountId): array
    {
        $sql = "SELECT taskListId, accountId, taskListName, status FROM taskList WHERE accountId = :accountId ORDER BY taskListId;";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['accountId' => $accountId]);

        $rows = Array();
        $int  = 100;
        while (($row = $stmt->fetch()) && $int > 0) {
            $rows[] = $row;
            $int--;
        }

        return $rows;
    }

    /**
     * Get taskLists list.
     * @throws DomainException
     * @return array taskLists list
     */
    public function getTaskListList(): array
    {
        $sql = "SELECT taskListId, accountId, taskListName, status FROM taskList ORDER BY taskListId;";
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
     * Update taskList by the given taskList id.
     * @param int $taskListId The taskList id
     * @param array<mixed> $taskList The taskList
     * @throws DomainException
     * @return int TaskList Id
     */
    public function updateTaskListById(int $taskListId, array $taskList): int
    {
        $set = "";
        $params = [];
        $params['taskListId'] = $taskListId;

        if (isset($taskList['accountId'])) {
            $params['accountId'] = $taskList['accountId'];
            $set .= ", accountId=:accountId";
        }
        if (isset($taskList['taskListName'])) {
            $params['taskListName'] = $taskList['taskListName'];
            $set .= ", taskListName=:taskListName";
        }
        if (isset($taskList['status'])) {
            $params['status'] = $taskList['status'];
            $set .= ", status=:status";
        }

        if (!strlen($set)) {
            throw new DomainException(sprintf('Account Id not updated: %s', $accountId));
        }

        $set = substr($set, 1);
        $sql = "UPDATE taskList SET " . $set . " WHERE taskListId=:taskListId;";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute($params);

        if (!$ok) {
            throw new DomainException(sprintf('TaskList Id not updated: %s', $taskListId));
        }

        return $taskListId;
    }

    /**
     * Delete taskList by the given taskList id.
     * @param int $taskListId The taskList id
     * @throws DomainException
     * @return int TaskList Id
     */
    public function deleteTaskListById(int $taskListId): int
    {
        $sql = "DELETE FROM taskList WHERE taskListId = :id;";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute(['id' => $taskListId]);

        if (!$ok) {
            throw new DomainException(sprintf('TaskList Id not deleted: %s', $taskListId));
        }

        return $taskListId;
    }
}
