<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends EloquentUser
{

}
