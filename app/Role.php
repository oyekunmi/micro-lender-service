<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug', 'permissions',
    ];
    protected $casts = [
        'permissions' => 'array',
    ];
    
    //
    public function users()
    {
      return $this->belongsToMany(User::class, 'role_users');
    }
}
