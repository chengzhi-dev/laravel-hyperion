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

class Notes extends Eloquent implements JWTSubject, AuthenticatableContract,CanResetPasswordContract
{
    use Notifiable;
    use Authenticatable, CanResetPassword;

    protected $connection = 'mongodb';
    protected $collection = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'location', 'date', 'periodicity', 'year', 'type', 'slip_ids', 'slip_total', 'invoice_url', 
        'ins_type', 'note_url', 'cedants_id', 'reinsurances_id', 'payment_status', 'validation_status', 'approval_status'
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
