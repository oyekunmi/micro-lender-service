<?php

namespace App\Repositories;

use App\Role;

class RoleRepository{
    
    function getRoleById($id){
        return \App\Role::find($id);
    }
    
    function getBySlug($slug){
        return \App\Role::where('slug', $slug)->first();
    }
    
    
}
