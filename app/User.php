<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //defining relationship to UserDetail model
    function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }
    
    //defining relationship to SocialProvider model
    function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }
    
    //defining relationship to Pledge model
    function pledges()
    {
        return $this->hasMany(Pledge::class);
    }
    
    //defining relationship to Request model
    function receives()
    {
        return $this->hasMany(Receive::class);
    }
    
    //defining relationship to Referral model
    function referrals()
    {
        return $this->hasMany(Referral::class);
    }    
    
}
