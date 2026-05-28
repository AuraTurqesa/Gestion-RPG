<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * GET /users
     * Muestra un listado web de usuarios.
     */
    public function index()
    {
        $users = User::withCount('characters')
            ->orderBy('id')
            ->get();

        return view('user.index', compact('users'));
    }
}
