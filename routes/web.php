<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Name;
use App\Http\Controllers\Api;
/*
|--------------------------------------------------------------------------
| Welcome / Login page
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $request) {

    // Already logged in?
    if ($request->session()->has('user_id')) {
        return redirect('/home');
    }

    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::post('/name', function (Request $request) {

    // Don't allow someone already logged in to login again
    if ($request->session()->has('user_id')) {
        return redirect('/home');
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);

    // Find existing name
    $user = Name::where('name', $request->name)->first();

    // Name doesn't exist
    if (!$user) {
        return redirect('/')
            ->with('error', 'Name not found. Please enter a valid name.');
    }

    // Update updated_at
    $user->touch();

    // Store user in session
    $request->session()->put('user_id', $user->id);

    // Regenerate session ID for security
    $request->session()->regenerate();

    return redirect('/home');
});


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/home', function (Request $request) {

    // Not logged in
    if (!$request->session()->has('user_id')) {
        return redirect('/')
            ->with('error', 'Please enter your name first.');
    }

    $user = Name::find($request->session()->get('user_id'));

    // User was deleted from database
    if (!$user) {
        $request->session()->forget('user_id');

        return redirect('/')
            ->with('error', 'User no longer exists.');
    }

    return view('auth.home', [
        'user' => $user,
    ]);
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {

    $request->session()->forget('user_id');

    $request->session()->regenerateToken();

    return redirect('/');
});


Route::get('/sport', function () {
    return view('auth.sport');
});



Route::get('/movie', function () {
    return view('auth.movie');
});


Route::get('/ceo', function () {
    return view('auth.ceo');
});


