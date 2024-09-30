<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
    return view('Configuration.User.index');
    }
    public function pdf()
    {
        return view('Configuration.User.pdf');
    }
}
