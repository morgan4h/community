<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Models\Name;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return View('auth.home');
});

Route::post('/name', function (Request $request) {
   Name::create([
        'name' => $request->name,
    ]);
    return redirect('/home');
});