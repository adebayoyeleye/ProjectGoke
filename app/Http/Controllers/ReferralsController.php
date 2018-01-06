<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Pledge;
use App\Receive;

class ReferralsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    
    /**
     * Create a Pledge.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPledge()
    {
        $pledge = new Pledge;
        $pledge->user_id = Auth::user()->id;
        $pledge->amount = request('amount');
        $pledge->amount_balance = request('amount');
        $pledge->save();
        return redirect()->route('home');
    }
    
    /**
     * Create a Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function createReceive()
    {
        $receive = new Receive;
        $receive->user_id = Auth::user()->id;
        $receive->amount = request('amount');
        $receive->amount_balance = request('amount');
        $receive->save();
        return redirect()->route('home');
    }
    
    
    
    public function proofPost(Request $request)
    {
//        dd($request->all());
        if ($request->hasFile('proof') && $request->file('proof')->isValid())
            {
            $arrayIds = explode(" ", $request->arrayString);
            $pledge = Pledge::find($arrayIds[0]);
//            $receive = $pledge->receives()->where('id', $request->pledge);
            
            $path = $request->file('proof')->storeAs('proofs', $arrayIds[0]. ' - ' . $arrayIds[1] . '.' . $request->file('proof')->getClientOriginalExtension());
//            $receive->pivot->proof_image_path = $path;
            $pledge->receives()->updateExistingPivot($arrayIds[1], ['proof_image_path' => $path, 'status' => 'Awaiting confirmation']);
//            return $path;
            return redirect()->route('home');
            
                    
//                }
//                if(!empty($path)){
//                    $edit = Model::FindOrFail($id);
////                    Delete old image
//                    $exists = Storage::disk('local')->exists($edit->image);
//                    if($exists){
//                        Storage::delete($edit->image);
//                    }
//                    $edit->image = $path;
//                    $edit->save();
//                }
            }
            return "not done";
    }

    public function confirmPost(Request $request)
    {
//        dd($request->all());
        $arrayIds = explode(" ", $request->arrayString);
        $receive = Receive::find($arrayIds[1]);  

        if ($request->confirm === 'Confirm Payment'){
            $receive->pledges()->updateExistingPivot($arrayIds[0], ['status' => 'Confirmed']);
        
            $pledge = Pledge::find($arrayIds[0]);
            $receive->checkToUpdateStatus();
            $pledge->checkToUpdateStatus();
        } else {
            $receive->pledges()->updateExistingPivot($arrayIds[0], ['status' => 'Declined']);            
        }

        return redirect()->route('home');        
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
