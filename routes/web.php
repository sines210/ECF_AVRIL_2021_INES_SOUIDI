<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Registered;



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


Route::get('/', [AnimeController::class, 'showAllAnimes']);
Route::get('/anime/{id}', [AnimeController::class, 'showPageAnimes']);
Route::get('/anime/{id}/new_review', function ($id) {
if (!Auth::check()) {
    return view('login');}
    else{ return view('new_review');}
 });
Route::post('/anime/{id}/create_review', [AnimeController::class, 'newReview' ]);
Route::get('/top', [AnimeController::class, 'showTopRank']);
Route::post('/anime/{id}/add_to_watch_list', [AnimeController::class, 'createWatchlist']);
Route::get('/watchlist', [AnimeController::class, 'showWatchList']);


Route::get('/login', function () {
  return view('login');
});


// Route::post('/login', AuthController::class, 'validateLogin') ;
Route::post('/login', function (Request $request) 
{
  $validated = $request->validate([
    "username" => "required",
    "password" => "required",
  ]);
  if (Auth::attempt($validated)) {
    return redirect()->intended('/');
  }
  return back()->withErrors([
    'username' => 'The provided credentials do not match our records.',

  ]);
});

Route::get('/signup', function () {
  return view('signup'); 
});
// Route::post('/signup', AuthController::class, 'validateSignup') ;
// Route::post('/signout', AuthController::class, 'signOut') ;

Route::post('signup', function (Request $request) {
  $validated = $request->validate([
    "email" => "email",
    "username" => "required", 
    "password" => "required",
    "password_confirmation" => "required|same:password"
  ]);
  $user = new User();
  $user->email = $validated["email"];
  $user->username = $validated["username"];
  $user->password = Hash::make($validated["password"]);
  $user->save();
  Auth::login($user);
  return redirect('/email/verify');
});


Route::get('/email/verify', function () {
  return view('auth.verify-email');  
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();
  return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
  $request->user()->sendEmailVerificationNotification();

  return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::post('signout', function (Request $request) {
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();
  return redirect('/');
}); 

