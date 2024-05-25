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

    public function withdraw(string $origin, float $amount): ?array{
        if ($amount <= 0){
            return null;
        }

        $origin_account = $this->getAccount($origin);
        if (!$origin_account){
            return null;
        }
        $balance = $origin_account->getBalance();

        if ($amount > $balance){
            return null;
        }

        $origin_account->setBalance($balance - $amount);
        $balance = $origin_account->getBalance();

        return ['origin' => ['id' => $origin, 'balance' => $balance]];
    }

    public function transfer(string $origin, float $amount, string $destination): ?array{
        $withdraw_result = $this->withdraw($origin, $amount);
        if (!$withdraw_result){
            return null;
        }
        $deposit_result = $this->deposit($destination, $amount);
        if (!$deposit_result){
            return null;
        }
        return array_merge($withdraw_result,$deposit_result);
    }

    public function reset(): void
    {
        $this->bank->setAccounts([]);
    }

}
