<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/referral/{referral_code}', 'Auth\RegisterController@referral');

Auth::routes();

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
Route::get('/resendverifyemail/{id}', 'Auth\RegisterController@resendVerifyEmail');

//Social login routes
Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

//Route to show profile update page
Route::get('/profile', 'HomeController@profile');

//Route to add/edit user detail
Route::post('/profile', 'HomeController@addOrEditUserDetail');

//Named route for dashboard
Route::get('/home', 'HomeController@index')->name('home');


//Route to make a pledge
Route::post('/pledge', 'TransactionsController@createPledge');
//Route to make a request
Route::post('/receive', 'TransactionsController@createReceive');

Route::post('confirm','TransactionsController@confirmPost');

Route::post('proof','TransactionsController@proofPost');

Route::get('proofs/{path}', function ($path) 
{
   $path = storage_path("app/proofs/" . $path);

   if (!File::exists($path)) {
      abort(404);
   }

   $file = File::get($path);
   $type = File::mimeType($path);

   $response = Response::make($file, 200);
   $response->header("Content-Type", $type);

   return $response;
});


