<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Name;
use App\Models\Api;

/*
|--------------------------------------------------------------------------
| Authentication & Welcome Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $request) {
    if ($request->session()->has('user_id')) {
        return redirect('/home');
    }
    return view('welcome');
});

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

Route::post('/logout', function (Request $request) {
    $request->session()->forget('user_id');
    $request->session()->regenerateToken();
    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| Views / Pages
|--------------------------------------------------------------------------
*/

Route::get('/home', function (Request $request) {
    $user = Name::find($request->session()->get('user_id'));
    return view('auth.home', [
        'user'  => $user,
        'users' => Name::all(),
        'apis'  => Api::all(),
    ]);
});

Route::get('/sport', function () {
    return view('auth.sport', [
        'users'  => Name::all(),
        'sports' => Api::where('category', 'sport')->get(),
    ]);
});

Route::get('/movie', function () {
    return view('auth.movie', [
        'users'  => Name::all(),
        'movies' => Api::where('category', 'movie')->get(),
    ]);
});

Route::get('/ceo', function () {
    return view('auth.ceo', [
        'users' => Name::all(),
        'apis'  => Api::all(),
    ]);
});

/*
|--------------------------------------------------------------------------
| Name Management Endpoints (With Editable Timestamps)
|--------------------------------------------------------------------------
*/

Route::put('/users/{id}', function (Request $request, $id) {
    try {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
        ]);

        $user = Name::findOrFail($id);
        $user->name = $validated['name'];

        if (!empty($validated['created_at'])) {
            $user->created_at = $validated['created_at'];
        }
        if (!empty($validated['updated_at'])) {
            $user->updated_at = $validated['updated_at'];
        }

        $user->save();

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'data' => $user], 200);
        }
        return back()->with('success', 'Name and timestamps updated successfully!');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
});

Route::delete('/users/{id}', function (Request $request, $id) {
    try {
        $user = Name::findOrFail($id);
        $user->delete();

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'message' => 'Record deleted successfully'], 200);
        }
        return back()->with('success', 'Record deleted successfully!');
    } catch (\Throwable $e) {
        if ($request->wantsJson()) {
            return response()->json(['status' => false, 'error_details' => $e->getMessage()], 500);
        }
        return back()->with('error', $e->getMessage());
    }
});

/*
|--------------------------------------------------------------------------
| API / Links Endpoints (With Editable Timestamps)
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
            'name'       => 'required|string|max:255',
            'api'        => 'required|string',
            'category'   => 'nullable|string|max:255',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
        ]);

        $api = Api::findOrFail($id);
        $api->name = $validated['name'];
        $api->api = $validated['api'];
        $api->category = $validated['category'] ?? null;

        if (!empty($validated['created_at'])) {
            $api->created_at = $validated['created_at'];
        }
        if (!empty($validated['updated_at'])) {
            $api->updated_at = $validated['updated_at'];
        }

        $api->save();

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'data' => $api], 200);
        }
        return back()->with('success', 'API and timestamps updated successfully!');
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
