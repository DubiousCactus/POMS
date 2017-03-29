<?php

namespace App\Http\Controllers;

use App\Item;
use App\Topping;
use Illuminate\Http\Request;

class PagesController extends Controller
{
	public function __construct()
	{
		$this->middleware('admin')->only([
			'manage', 'manageMenu', 'manageToppings'
		]);
	}

    public function index()
    {
        return view('home')->withItems(Item::all());
	}

	public function manage()
	{
		return view('admin.index');
	}

	public function manageMenu()
	{
		return view('admin.itemsIndex')->withItems(Item::all());
	}

	public function manageToppings()
	{
		return view('admin.toppingsIndex')->withToppings(Topping::all());
	}
}
