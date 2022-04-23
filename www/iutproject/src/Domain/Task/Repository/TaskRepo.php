<?php

namespace App\Domain\Task\Repository;

use DomainException;
use PDO;

/**
 * Repository.
 */
class TaskRepo
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
     * Insert task row.
     * @param array<mixed> $task The task
     * @throws DomainException
     * @return int The new task Id
     */
    public function insertTask(array $task): int
    {
        $into = "";
        $values = "";
        $params = [];

        if (isset($task['accountId'])) {
            $params['accountId'] = $task['accountId'];
            $into .= ", accountId";
            $values .= ", :accountId";
        }
        if (isset($task['taskListId'])) {
            $params['taskListId'] = $task['taskListId'];
            $into .= ", taskListId";
            $values .= ", :taskListId";
        }
        if (isset($task['taskName'])) {
            $params['taskName'] = $task['taskName'];
            $into .= ", taskName";
            $values .= ", :taskName";
        }
        if (isset($task['status'])) {
            $params['status'] =  $task['status'];
            $into .= ", status";
            $values .= ", :status";
        }
        if (isset($task['dueDate'])) {
            $params['dueDate'] = $task['dueDate'];
            $into .= ", dueDate";
            $values .= ", :dueDate";
        }
        if (isset($task['note'])) {
            $params['note'] = $task['note'];
            $into .= ", note";
            $values .= ", :note";
        }

        if (!strlen($into)) {
            throw new DomainException(sprintf('Task not created'));
        }

        $into = substr($into, 1);
        $values = substr($values, 1);
        $sql = "INSERT INTO task( " . $into . " )
                VALUES ( " . $values . " );";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute($params);

        if (!$ok) {
            throw new DomainException(sprintf('Task not created'));
        }
    
        return (int)$this->connection->lastInsertId();
    }

    /**
     * Get task by the given task id.
     * @param int $taskId The task id
     * @throws DomainException
     * @return array The task row
     */
    public function getTaskById(int $taskId): array
    {
        $sql = "SELECT taskId, accountId, taskListId, taskName, status, dueDate, note FROM task WHERE taskId = :id;";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $taskId]);
        $row = $stmt->fetch();
        //$stmt->closeCursor();

        if (!$row) {
            throw new DomainException(sprintf('Task Id not found: %s', $taskId));
        }

        return $row;
    }

    /**
     * Get tasks by account id.
     * @param int $accountId The account id
     * @throws DomainException
     * @return array The task rows
     */
    public function getTaskByAccount(int $accountId): array
    {
        $sql = "SELECT taskId, accountId, taskListId, taskName, status, dueDate, note FROM task WHERE accountId = :accountId ORDER BY taskListId, taskId;";
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
     * Get tasks by account id / taskList id.
     * @param int $accountId The accountId id
     * @param int $taskListId The taskList id
     * @throws DomainException
     * @return array The task rows
     */
    public function getTaskByTaskList(int $accountId, int $taskListId): array
    {
        $sql = "SELECT taskId, accountId, taskListId, taskName, status, dueDate, note FROM task WHERE accountId = :accountId AND taskListId = :taskListId ORDER BY taskId;";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['accountId' => $accountId, 'taskListId' => $taskListId]);

        $rows = Array();
        $int  = 100;
        while (($row = $stmt->fetch()) && $int > 0) {
            $rows[] = $row;
            $int--;
        }

        return $rows;
    }

    /**
     * Get tasks list.
     * @throws DomainException
     * @return array tasks list
     */
    public function getTaskList(): array
    {
        $sql = "SELECT taskId, accountId, taskListId, taskName, status, dueDate, note FROM task ORDER BY taskId;";
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
     * Update task by the given task id.
     * @param int $taskId The task id
     * @param array<mixed> $task The task
     * @throws DomainException
     * @return int Task Id
     */
    public function updateTaskById(int $taskId, array $task): int
    {
        $set = "";
        $params = [];
        $params['taskId'] = $taskId;

        if (isset($task['accountId'])) {
            $params['accountId'] = $task['accountId'];
            $set .= ", accountId=:accountId";
        }
        if (isset($task['taskListId'])) {
            $params['taskListId'] = $task['taskListId'];
            $set .= ", taskListId=:taskListId";
        }
        if (isset($task['taskName'])) {
            $params['taskName'] = $task['taskName'];
            $set .= ", taskName=:taskName";
        }
        if (isset($task['status'])) {
            $params['status'] = $task['status'];
            $set .= ", status=:status";
        }
        if (isset($task['dueDate'])) {
            $params['dueDate'] = $task['dueDate'];
            $set .= ", dueDate=:dueDate";
        }
        if (isset($task['activeExpireDate'])) {
            $params['activeExpireDate'] = $task['activeExpireDate'];
            $set .= ", note=:note";
        }

        if (!strlen($set)) {
            throw new DomainException(sprintf('Task Id not updated: %s', $taskId));
        }

        $set = substr($set, 1);
        $sql = "UPDATE task SET " . $set . " WHERE taskId=:taskId;";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute($params);

        if (!$ok) {
            throw new DomainException(sprintf('Task Id not updated: %s', $taskId));
        }

        return $taskId;
    }

    /**
     * Delete task by the given task id.
     * @param int $taskId The task id
     * @throws DomainException
     * @return int Task Id
     */
    public function deleteTaskById(int $taskId): int
    {
        $sql = "DELETE FROM task WHERE taskId = :id;";
        $stmt = $this->connection->prepare($sql);
        $ok = $stmt->execute(['id' => $taskId]);

        if (!$ok) {
            throw new DomainException(sprintf('Task Id not deleted: %s', $taskId));
        }

        return $taskId;
    }
}
