<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Name;
use App\Models\User;
use App\Models\Api;

/*
|--------------------------------------------------------------------------
| Welcome / Login page
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $request) {
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
    if ($request->session()->has('user_id')) {
        return redirect('/home');
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);

    $user = Name::where('name', $request->name)->first();

    if (!$user) {
        return redirect('/')
            ->with('error', 'Name not found. Please enter a valid name.');
    }

    $user->touch();
    $request->session()->put('user_id', $user->id);
    $request->session()->regenerate();

    return redirect('/home');
});


/*
|--------------------------------------------------------------------------
| Views
|--------------------------------------------------------------------------
*/

Route::get('/home', function (Request $request) {
    $user = Name::find($request->session()->get('user_id'));
    $users = User::all();
    $apis = Api::all();

    return view('auth.home', [
        'user'  => $user,
        'users' => $users,
        'apis'  => $apis,
    ]);
});

Route::get('/sport', function () {
    return view('auth.sport', [
        'users' => User::all(),
        'apis'  => Api::all(),
    ]);
});

Route::get('/movie', function () {
    return view('auth.movie', [
        'users' => User::all(),
        'apis'  => Api::all(),
    ]);
});

Route::get('/ceo', function () {
    return view('auth.ceo', [
        'users' => User::all(),
        'apis'  => Api::all(),
    ]);
});


/*
|--------------------------------------------------------------------------
| User Management Endpoints
|--------------------------------------------------------------------------
*/

Route::put('/users/{id}', function (Request $request, $id) {
    try {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'is_admin' => 'required|integer|in:0,1',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'data' => $user], 200);
        }
        return back()->with('success', 'User updated successfully!');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
});

Route::delete('/users/{id}', function (Request $request, $id) {
    try {
        $user = User::findOrFail($id);
        $user->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'message' => 'User deleted successfully'], 200);
        }
        return back()->with('success', 'User deleted successfully!');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
});


/*
|--------------------------------------------------------------------------
| API / Links Endpoints (With Category Support)
|--------------------------------------------------------------------------
*/

Route::get('/apis', function (Request $request) {
    try {
        $data = Api::all();
        if ($request->wantsJson()) {
            return response()->json([
                'status'  => true,
                'code'    => 200,
                'message' => 'Records retrieved successfully.',
                'count'   => $data->count(),
                'data'    => $data
            ], 200);
        }
        return redirect('/home');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
});

Route::post('/apis', function (Request $request) {
    try {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'api'      => 'required|string',
            'category' => 'nullable|string|max:255',
        ]);

        $created = Api::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'data' => $created], 201);
        }
        return back()->with('success', 'API created successfully!');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
});

Route::put('/apis/{id}', function (Request $request, $id) {
    try {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'api'      => 'required|string',
            'category' => 'nullable|string|max:255',
        ]);

        $api = Api::findOrFail($id);
        $api->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'data' => $api], 200);
        }
        return back()->with('success', 'API updated successfully!');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
});

Route::delete('/apis/{id}', function (Request $request, $id) {
    try {
        $api = Api::findOrFail($id);
        $api->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'message' => 'Deleted successfully'], 200);
        }
        return back()->with('success', 'API deleted successfully!');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
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



Route::get('/movie', function () {
    // Fetches items where category = 'movie' using your existing Api model
    $movies = Api::where('categoryes', 'movie')->get();

    return view('auth.movie', [
        'users'  => User::all(),
        'movies' => $movies,
    ]);
});

Route::get('/sport', function () {
    // Fetches items where category = 'sport' using your Api model
    $sports = Api::where('categoryes', 'sport')->get();

    return view('auth.sport', [
        'users'  => User::all(),
        'sports' => $sports,
    ]);
});