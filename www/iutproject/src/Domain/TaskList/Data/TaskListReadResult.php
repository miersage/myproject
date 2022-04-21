<?php

namespace App\Domain\TaskList\Data;

use JsonSerializable;

final class TaskListReadResult implements JsonSerializable
{
    /**
     * @var int
     */
    public $taskListId;

    /** @var int */
    public $accountId;

    /** @var string */
    public $taskListName;

    /** @var int */
    public $status;

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'taskListId' => $this->taskListId,
            'accountId' => $this->accountId,
            'taskListName' => $this->taskListName,
            'status' => $this->status,
        ];
    }

}