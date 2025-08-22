<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class UserController extends Controller
{
    public function shop()
    {   
        $items = Item::paginate(12);
        return view('User.shop', compact('items'));
    }

    public function index()
    {
        return view('User.cart');
    }
}
