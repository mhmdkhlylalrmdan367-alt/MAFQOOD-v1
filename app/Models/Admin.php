<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Model;
use Melbedran\RolePermession\Concerns\HasRoles;

class Admin extends Authenticatable
{
    //
    use TwoFactorAuthenticatable, HasRoles;
    protected $fillable = ['name','email','password','status','super_admin'];
}
