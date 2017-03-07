<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('home')->withItems(Item::all());
    }
}
