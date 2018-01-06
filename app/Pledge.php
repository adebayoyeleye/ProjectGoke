<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Receive;
use App\UserDetail;

class Pledge extends Model
{
    //define relationship to User model
    function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //define relationship to Receive model
    function receives()
    {
        return $this->belongsToMany(Receive::class)->withPivot('amount', 'status', 'proof_image_path')->withTimestamps();
    }
    
    
    
    
    function getAmountToMatch()
    {
        $numberOfDays = $this->created_at->diffInDays();
        if(($numberOfDays > 1) && ($this->amount == $this->amount_balance)){
            return $this->amount * 0.05;            
        }else if($numberOfDays > 18){
            return $this->amount_balance;            
        }  else {
            return 0;
        }
    }
    
    
    function findReceive()
    {
        $foundReceive = Receive::where([
                                        ['status', '=', 'Awaiting match'],
                                        ['user_id', '<>', $this->user_id]
                                        ])->orderBy('amount_balance', 'desc')->first();
        if(is_null($foundReceive))
        {
            $foundReceive=new Receive;
            $foundReceive->amount = $this->amount_balance;
            $foundReceive->amount_balance = $this->amount_balance;
            $foundReceive->user_id = 1;
            $foundReceive->save();
        }
        
        return $foundReceive;
                
    }


    //logic for matching Receive model
    function match(Receive $unmatchedReceive, float $matchAmount)
    {
        if ($matchAmount > $this->amount_balance) {
            throwException($exception);
        }
        if ( $matchAmount > $unmatchedReceive->amount_balance) {
            $balance = $unmatchedReceive->amount_balance;
            $unmatchedReceive->status = 'Awaiting payment';
        } else {
            if ($matchAmount == $unmatchedReceive->amount_balance) {
                $unmatchedReceive->status = 'Awaiting payment';                
            }elseif ($matchAmount == $this->amount_balance) {
                $this->status = 'Awaiting payout';                
            }
            $balance = $matchAmount;            
        }
                
        $this->receives()->attach($unmatchedReceive->id, ['amount' => $balance]);
        $unmatchedReceive->amount_balance -= $balance;
        $this->amount_balance -= $balance;
        $unmatchedReceive->save();
        $this->save();
        
        return $balance;
    }
    
    function checkToUpdateStatus()
    {
        foreach ($this->receives as $dueReceive){
            if ($dueReceive->pivot->status != 'Confirmed') {
                return;
            }
        }
//        if ($this->receives()->where('status', '<>', 'Confirmed')->get()){
//            return;
//        }
        $this->status = 'Awaiting maturity';
        $this->save();        
    }
    
    function checkAndMature()
    {
        $numberOfDays = $this->created_at->diffInDays();
        if($numberOfDays > 30){
            $this->status = 'Matured';
            $this->save();
            //update the balance with pledge amount + 30%
//            $user = $this->user->userDetail
        }
    }
}
