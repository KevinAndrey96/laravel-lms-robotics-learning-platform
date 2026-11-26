<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class ChangePasswordUsersController extends Controller
{
    public function changePassword()
    {
        return view('users.changePassword');
    }
}
