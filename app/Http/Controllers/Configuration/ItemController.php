<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    //
    public function index(){
        return view('Configuration.Item.index');
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
