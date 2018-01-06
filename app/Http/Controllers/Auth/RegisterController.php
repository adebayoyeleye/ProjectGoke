<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Referral;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Socialite;
use App\SocialProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
//use Request;
use App\Jobs\SendVerificationEmail;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
  protected $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        $this->middleware('guest');
        $this->request = $request;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->email_token = str_random(30);
        
        $user->save();
        
//        below default doesnt work bcause of fillable is required but risky as it can be set in browser inspect source mode
//        User::create([
//                    'name' => $data['name'],
//                    'email' => $data['email'],
//                    'password' => bcrypt($data['password']),
//                    'email_token' => str_random(30),
//            OR      'email_token' => base64_encode($data['email']),
//        ]);

        $refCode = $this->request->session()->get('ref');
        if(!empty($refCode)){
            $referral = new Referral;
            $referral->user_id = User::where('referral_code', $refCode)->first()->id;
            $referral->referred_id = $user->id;
            $referral->save();
        }
        return $user;
    }

    /////////////////////////
    
    
        /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function referral (Request $request, $referral_code) {
    // add referral code to session variable
    $request->session()->put('ref', $referral_code);
//    session(['ref' => $referral_code]);
//    $temp = $request->session()->get('ref');
//    dd($temp);
//    dd(session['ref']); //didnt work
    return view('welcome');
}

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        dispatch(new SendVerificationEmail($user));
        return view('verification')->with([
            'id' => $user->id,
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token) {
        $user = User::where('email_token', $token)->first();
        $user->verified = 1;
        $temp = (string)$user->id;
        $user->referral_code = substr ( $user->name , 0, (7 - strlen($temp))). $temp;
        $user->email_token = null;
        if ($user->save()) {
            return view('emailconfirmed', ['user' => $user]);
        }
    }
    
    
        /**
     * Handle a registration request for the application.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function resendVerifyEmail($id) {
        $user = User::where('id', $id)->first();
        dispatch(new SendVerificationEmail($user));
        return view('verification')->with([
            'id' => $user->id,
        ]);
    }

    /////////////////////////

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider) {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/');
        }
        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first();
        if (!$socialProvider) {
            //create a new user and provider
            //old implementation
//            $user = User::firstOrNew(
//                            ['email' => $socialUser->getEmail()], ['name' => $socialUser->getName()]
//            );
            
        $user = User::where('email', $socialUser->getEmail())->first();
        if (!$user) {
                $user = User::create([
                            'name' => $socialUser->getName(),
                            'email' => $socialUser->getEmail(),
                ]);
                $temp = (string) $user->id;
                $user->referral_code = substr($user->name, 0, (7 - strlen($temp))) . $temp;
            }

//                    if(!empty(session['ref']) && !isNull(session['ref'])){
//            $referral = new Referral;
//            $referral->user_id = User::where('referral_code', session['ref'])->first()->id;
//            $referral->referred_id = $user->id;
//            $referral->save();
//        }
            $user->verified = 1;
            $user->save();

            $user->socialProviders()->create(
                    ['provider_id' => $socialUser->getId(), 'provider' => $provider]
            );
        } else {
            $user = $socialProvider->user;
        }

        auth()->login($user);

        return redirect('/home');

        // $user->token;
    }

}
