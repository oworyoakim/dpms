<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    protected $loginNames = ['username','email'];

    protected $fillable = [
        'email',
        'username',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
