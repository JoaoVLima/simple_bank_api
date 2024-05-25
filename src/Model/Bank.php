<?php
namespace Api\Model;

use Api\Util\Singleton;

class Bank extends Singleton
{
    private array $accounts = [];

    public function getAccounts(): array{
        return $this->accounts;
    }

    public function getAccount(string $id): Account{
        return $this->accounts[$id];
    }

    public function addAccount(Account $account): void{
        $this->accounts[$account->getId()] = $account;
    }

    public function setAccounts(array $accounts): void{
        $this->accounts = $accounts;
    }
}