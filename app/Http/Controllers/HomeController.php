<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Pledge;
use App\Receive;
use App\UserDetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->verified){
            $id = Auth::user()->id;
            Auth::logout();
            return view('verification')->with([
            'id' => $id,
        ]);            
        }
        if (!Auth::user()->userDetail){return view('auth\register2');}
        $pledges = Auth::user()->pledges;  //->where('status', '<', '3');
        $receives = Auth::user()->receives;
        return view('home', compact('pledges', 'receives'));
    }
    
    /**
     * Show the profile update page.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('auth\register2');
//        $pledges = Auth::user()->pledges;  //->where('status', '<', '3');
//        $receives = Auth::user()->receives;
//        return view('home', compact('pledges', 'receives'));
    }
    
    /**
     * Add User Detail.
     *
     * @return Redirect
     */
    public function addOrEditUserDetail()
    {
        $tempUserDetail = Auth::user()->userDetail ? Auth::user()->userDetail : new UserDetail;
        $tempUserDetail->user_id = Auth::user()->id;
        $tempUserDetail->full_name = request('full_name');
        $tempUserDetail->account_number = request('account_number');
        $tempUserDetail->bank = request('bank');
        $tempUserDetail->location = request('location');
        $tempUserDetail->save();
        return redirect()->route('home');
    }
    
     
}
