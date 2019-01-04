<?php

namespace App;

use App\Role;
use App\Account;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username','password', 'profile'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    
    protected $appends = ['roles'];

    
    public function attachToken($token){
        $this->token = $token;
        return $this;
    }


    public function roles()
    {
      return $this->belongsToMany(Role::class, 'role_users');
    }
    
    public function getRolesAttribute(){
        return $this->roles()->getResults()->map( function($item) {
            return $item->slug;
        });
    }


    public function accounts(){
        return $this->hasMany(Account::class);
    }
    
//    public function hasAccountClass($product_slug){
//        return $this->accounts()->
//    }
}
