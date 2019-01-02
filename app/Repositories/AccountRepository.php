<?php

namespace App\Repositories;

use App\Account;

class AccountRepository{
    
    function saveAccount(Account $account){
        return $account->save();
    }
    
    function getByAccountNumber(string $accountNumber){
        return Account::where('accountNo', $accountNumber)->first();
    }
    
    function createAccount($user, $product, $accountNo){
        $account = new Account;
        $account->account_no = $accountNo;
        $account->account_name = $user->name;
        $account->user()->associate($user);
        $account->product()->associate($product);
        $this->saveAccount($account);
        return $account;
    }
    
    
}