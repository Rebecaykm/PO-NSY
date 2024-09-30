<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteAssignmentController extends Controller
{
    //
    public function index(){
        return view('purchasing.QuoteAssignment.index');
    }
}
