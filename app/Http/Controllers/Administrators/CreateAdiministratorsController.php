<?php

namespace App\Http\Controllers\Administrators;

use App\Http\Controllers\Controller;

class CreateAdiministratorsController extends Controller
{
    public function create()
    {
        return view('administrators.create');
    }
}
