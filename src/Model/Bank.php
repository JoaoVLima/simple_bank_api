<?php
namespace Api\Model;

use SlimSession\Helper;

class Bank
{
    private array $accounts;
    protected Helper $session;

    public function __construct()
    {
        $this->session = new Helper();
        $this->accounts = $this->session->get('accounts', []);
    }

    public function getAccounts(): array{
        return $this->accounts;
    }

    public function getAccount(string $id): Account{
        return $this->accounts[$id];
    }

    public function addAccount(Account $account): void{
        $this->accounts[$account->getId()] = $account;
        $this->session->set('accounts', $this->accounts);
    }

    public function setAccounts(array $accounts): void{
        $this->accounts = $accounts;
        $this->session->set('accounts', $this->accounts);
    }
}
