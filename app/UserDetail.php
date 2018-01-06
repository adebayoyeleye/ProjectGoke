<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //define relationship to User model
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
