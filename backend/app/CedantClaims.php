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

class CedantClaims extends Eloquent implements JWTSubject, AuthenticatableContract
{
    use Notifiable;
    use Authenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'slips_claims';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id','reference', 'cedants_id', 'cedants_type_id', 'reinsurances_id', 'edited_period', 'published_date', 'file_url',
        'slip_type', 'validation_status', 'approval_status'
    ];

    public function claim_life_cases()
    {
        return $this->hasMany('App\CedantClaimCases', 'slipes_claims_id','_id');
    }

    public function claim_notlife_cases()
    {
        return $this->hasMany('App\CedantClaimNotLifeCases', 'slipes_claims_id','_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
