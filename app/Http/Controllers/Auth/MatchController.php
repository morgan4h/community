<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class MatchController extends Controller
{
    public function showLastMatch()
    {
        $notification = Notification::orderBy('id', 'desc')->first();

        // This will pause execution and print what is inside $notification on your screen
        dd($notification);

        return view('auth.home', compact('notification'));
    }
}