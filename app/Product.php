<?php

namespace App;

use App\Account;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
     public function accounts(){
        return $this->hasMany(Account::class);
    }
}
