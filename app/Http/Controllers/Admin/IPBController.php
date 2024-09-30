<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IPB;
use Illuminate\Http\Request;

class IPBController extends Controller
{
    public function index()
    {
        return view('Admin.IPB.index');
    }
}
