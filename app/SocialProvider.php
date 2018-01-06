<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    //manunally added
    protected $fillable = ['provider_id', 'provider'];
    //define relationship to User model
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
