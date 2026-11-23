<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    //
    use TwoFactorAuthenticatable;
    protected $fillable = ['name','email','password','status','super_admin'];
}
