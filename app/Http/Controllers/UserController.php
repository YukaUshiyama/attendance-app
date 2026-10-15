<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request, CreateNewUser $creator)
    {
        $creator->create($request->all());

        return redirect('/login');
    }
}
