<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    //define relationship to User model
    function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //define relationship to Pledge model
    function pledges()
    {
        return $this->belongsToMany(Pledge::class)->withPivot('amount', 'status', 'proof_image_path')->withTimestamps();
    }
    
    function checkToUpdateStatus()
    {
        foreach ($this->pledges as $duePledge){
            if ($duePledge->pivot->status != 'Confirmed') {
                return;
            }
        }
//        if ($this->pledges()->where('status', '<>', 'Awaiting maturity')->get()){
//            return;
//        }
        $this->status = 'Confirmed';
        $this->save();        
    }
}
