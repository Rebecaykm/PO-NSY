<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    //
    public function index(){
        return view('Home.Menu.index');
    }
    public function download($filename)
    {
        $filePath = 'public/items/' . $filename;

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        } else {
            return abort(404, 'File not found.');
        }
    }
}
