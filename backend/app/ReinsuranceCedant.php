<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable  as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ReinsuranceCedant extends Eloquent implements JWTSubject, AuthenticatableContract,CanResetPasswordContract
{
    use Notifiable;
    use Authenticatable, CanResetPassword;
    
    protected $connection = 'mongodb';
    protected $collection = 'cedants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'groups_cedants_id', 'reinsurances_id', 'contact', 'logo', 'color1', 'color2', 'countries_id', 
        'region_id', 'types_cedants_id', 'currencies_id', 'benefit_percentage', 'status', 'code'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
