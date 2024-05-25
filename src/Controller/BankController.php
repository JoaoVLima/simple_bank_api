<?php
namespace Api\Controller;

use Api\Model\Bank;
use Api\Model\Account;

class BankController
{
    private Bank $bank;

    public function __construct()
    {
        $this->bank = new Bank();
    }

    public function createAccount(string $accountId, int $initialBalance = 0): Account
    {
        $account = new Account($accountId, $initialBalance);
        $this->bank->addAccount($account);
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

    public function deposit(string $destination, float $amount): ?array
    {
        if ($amount <= 0){
            return null;
        }
        $destination_account = $this->getAccount($destination);
        if (!$destination_account){
            $destination_account = $this->createAccount($destination);
        }
        $balance = $destination_account->getBalance();
        $destination_account->setBalance($balance + $amount);
        $balance = $destination_account->getBalance();

        return ['destination' => ['id' => $destination, 'balance' => $balance]];
    }

    public function withdraw(string $origin, float $amount): float{
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
