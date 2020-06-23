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

class CedantPremiumNotLifeCases extends Eloquent implements JWTSubject, AuthenticatableContract
{
    use Notifiable;
    use Authenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'case_not_life_premium';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'policy_number', 'branch', 'category', 'nature_risque_id', 'date_effective', 'date_transaction', 'deadline',
        'fullname_souscriber', 'fullname_insured', 'geographic_location', 'insured_capital', 'premium_ht',
        'paid_commission', 'part_cedant_coass', 'premium_ceded', 'commission_cession', 'prime_net_ceded',
        'slipes_prime_id', 'case_validation_status', 'active_status', 'branches_id', 'sub_branches_id'
    ];

    public function premium_slips()
    {
        return $this->belongsTo('App\CedantPremiums', 'slipes_prime_id','_id');
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
