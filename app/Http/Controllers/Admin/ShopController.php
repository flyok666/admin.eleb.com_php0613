<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    //
    public function index()
    {
        /*Storage::disk('oss');

        Storage::put('images/2.jpg', file_get_contents(public_path('/images/1.jpg')));
        dd(Storage::url('images/2.jpg'));*/
    }
}
