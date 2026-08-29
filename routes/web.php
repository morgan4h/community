<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return View('auth.home');
});

Route::post('/name', function (Request $request) {
    echo  "welcome " . $request->name;
    sleep(2);
    return redirect('/home');
});