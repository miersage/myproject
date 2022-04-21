<?php

namespace App\Domain\Task\Data;

use JsonSerializable;

final class TaskReadResult implements JsonSerializable
{
    /**
     * @var int
     */
    public $taskId;

    /** @var int */
    public $accountId;

    /** @var int */
    public $taskListId;

    /** @var string */
    public $taskName;

    /** @var int */
    public $status;

    /** @var string */
    public $dueDate;

    /** @var string */
    public $note;

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'taskId' => $this->taskId,
            'accountId' => $this->accountId,
            'taskListId' => $this->taskListId,
            'taskName' => $this->taskName,
            'status' => $this->status,
            'dueDate' => $this->dueDate,
            'note' => $this->note,
        ];
    }

}