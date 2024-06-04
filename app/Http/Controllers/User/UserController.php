<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class UserController extends Controller
{
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
}
