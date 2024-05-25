<?php
namespace Api\Controller;

use Api\Model\Bank;
use Api\Model\Account;

class BankController
{
    private Bank $bank;

    public function __construct()
    {
        $this->bank = Bank::getInstance();
    }

    public function createAccount(int $initialBalance = 0): Account
    {
        var_dump($this->bank->getAccounts());
        $accountId = uniqid();
        $account = new Account($accountId, $initialBalance);
        $this->bank->addAccount($account);
        var_dump($this->bank->getAccounts());
        return $account;
    }

    public function getAccount(string $accountId): ?Account
    {
        $accounts = $this->bank->getAccounts();
        if (!array_key_exists($accountId, $accounts)) {
            return null;
        }
        return $accounts[$accountId];
    }

    public function deposit(string $destination, float $amount): void{
        if ($amount <= 0){
            throw new Exception("Cant deposit $amount");
        }
        $destination = $this->getAccount($destination);
        $balance = $destination->getBalance();
        $destination->setBalance($balance + $amount);
    }

    public function withdraw(string $origin, float $amount): void{
        if ($amount <= 0){
            throw new Exception("Cant withdraw $amount");
        }

        $origin = $this->getAccount($origin);
        $balance = $origin->getBalance();

        if ($amount > $balance){
            throw new Exception("Cant withdraw $amount");
        }

        $origin->setBalance($balance - $amount);
    }

    public function transfer(string $origin, float $amount, string $destination): void{
        $this->withdraw($origin, $amount);
        $this->deposit($destination, $amount);
    }

    public function reset(): void
    {
        $this->bank->setAccounts([]);
    }

}
