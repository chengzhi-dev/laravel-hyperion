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

class CedantClaimCases extends Eloquent implements JWTSubject, AuthenticatableContract
{
    use Notifiable;
    use Authenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'case_life_claims';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'claim_number', 'police_number', 'date_effective', 'deadline',
        'fullname_insured', 'claim_date', 'declaration_date', 'claim_nature',
        'capital_loss_death', 'capital_loss_death_acc', 'capital_loss_ta',
        'capital_loss_ipp', 'capital_loss_jobs', 'claim_a_100', 'part_assignor', 'claim_assignor', 'payment_date',
        'claim_cede', 'slipes_claims_id', 'case_validation_status', 'branches_id', 'active_status'
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
