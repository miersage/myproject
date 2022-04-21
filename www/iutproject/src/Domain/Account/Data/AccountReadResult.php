<?php

namespace App\Domain\Account\Data;

use JsonSerializable;

final class AccountReadResult implements JsonSerializable
{
    /**
     * @var int
     */
    public $accountId;

    /** @var string */
    public $login;

    /** @var string */
    public $password;

    /** @var string */
    public $email;

    /** @var int */
    public $status;

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'accountId' => $this->accountId,
            'login' => $this->login,
            'password' => $this->password,
            'email' => $this->email,
            'status' => $this->status,
        ];
    }

}