<?php

namespace App;

use App\User;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_no', 'account_name'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
     public function product(){
        return $this->belongsTo(Product::class);
    }
}
