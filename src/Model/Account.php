<?php
namespace Api\Model;

class Account
{
    private string $id;
    private float $balance;

    public function __construct(string $id, float $balance)
    {
        $this->id = $id;
        $this->balance = $balance;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

}
