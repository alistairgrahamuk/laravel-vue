<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use App\Models\User;

Route::get('login', [ LoginController::class, 'create' ])->name('login');
Route::post('login', [ LoginController::class, 'store' ]);
Route::post('/logout', [ LoginController::class, 'destroy'])->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return Inertia::render('Home');
    });

    Route::get('/users', function () {
        return Inertia::render('Users/Index', [
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ],
            'users' => User::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate(16)
                ->withQueryString()
                ->through(function ($user) {
                    return
                        [
                            'id' => $user->id,
                            'name' => $user->name,
                            'can' => [
                                'edit'=> Auth::user()->can('edit', $user)
                            ]
                        ];
                }),
            'filters' => Request::only(['search']),
        ]);
    });


    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->can('create', 'App\Models\User');


    Route::get('/users/{id}/edit', [ UserController::class, 'edit' ]);

    Route::post('/users/{id}/edit', [ UserController::class, 'store' ]);


    Route::post('/users', function () {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($attributes);

        return redirect('/users');

    });


    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });

});
