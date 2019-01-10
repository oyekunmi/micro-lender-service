<?php

namespace App\Repositories;

use App\User;

class UserRepository{
    
    function getAllInRole($role){
        return User::whereHas('roles', function($query) use ($role){
            $query->where('slug', $role);
        })->get();
    }
    
    function getById($id){
        return User::find($id);
    }
    
    function getByUsername($username){
        return User::where('username',$username)->first();
    }
    
    function getByUsernameAndRole($username, $role){
        return User::where('username', $username)->whereHas('roles', function($query) use ($role){
            $query->where('slug', $role);
        })->first();
    }
    
    function save($user){
        return User::create($user);
    }
}