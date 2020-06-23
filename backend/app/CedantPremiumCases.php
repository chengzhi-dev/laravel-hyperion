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

class CedantPremiumCases extends Eloquent implements JWTSubject, AuthenticatableContract
{
    use Notifiable;
    use Authenticatable;
    
    protected $connection = 'mongodb';
    protected $collection = 'case_life_premium';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'policy_number','insured_number', 'branches_id', 'sub_branches_id', 'date_effective', 'date_operation', 'deadline', 'fullname_souscriber', 
        'fullname_insured', 'dateofbirth_insured', 'capital_insured_death_or_constitution', 'nature', 'type',
        'capital_insured_accidental_death', 'capital_insured_triply_accidentally', 
        'capital_insured_partial_permanent_disability', 'capital_insured_loss_jobs', 'premium_periodicity', 
        'taux_supprime', 'prime_deces', 'suprime_deces', 'prime_guarantee_supplement', 'prime_nette_total', 'comission', 'part_cedante', 
        'prime_nette_totale_cedante', 'comission_cedante', 'prime_cedee', 'comission_cession', 'prime_nette_cedee', 
        'slipes_prime_id', 'case_validation_status', 'active_status'
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
