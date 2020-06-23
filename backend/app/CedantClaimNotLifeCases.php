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

class CedantClaimNotLifeCases extends Eloquent implements JWTSubject, AuthenticatableContract
{
    use Notifiable;
    use Authenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'case_not_life_claims';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'claim_date', 'claim_number', 'payment_date', 'fullname_insured',
        'disaster_warranty', 'branches_id', 'sub_branches_id', 'police_number', 'date_effective',
        'deadline', 'opening_estimate', 'revised_estimate',
        'payment_period', 'cumulative_period', 'left_to_pay', 'use_cash', 'recoveries_received', 'use_remaining_cash',
        'adverse_ccie', 'slipes_claims_id', 'case_validation_status', 'active_status'
    ];

    public function claim_slips()
    {
        return $this->belongsTo('App\CedantClaims', 'slipes_claims_id','_id');
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
