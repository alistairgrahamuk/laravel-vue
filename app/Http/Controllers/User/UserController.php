<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index()
    {
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
    }

    public function edit($id)
    {
        return Inertia::render('Users/Edit', [
            'user' => User::select(['name', 'id'])->where('id', $id)->get()->first()
        ]);
    }

    public function store($id)
    {
        $attributes = Request::validate([
            'name' => 'required',
        ]);

        User::where('id', $id)->update($attributes);

        return redirect('/users');
    }

    public function create()
    {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($attributes);

        return redirect('/users');
    }


    public function showIfUserCanCreate()
    {
        if (Auth::User()->can('create', 'App\Models\User')) {
            return Inertia::render('Users/Create');
        }
    }
}
