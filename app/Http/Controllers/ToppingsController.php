<?php

namespace App\Http\Controllers;

use App\Topping;
use Illuminate\Http\Request;

class ToppingsController extends Controller
{

	public function __construct()
	{
		$this->middleware('admin')->except([
			'index', 'show'
		]);
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.createTopping');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:toppings',
			'price' => 'required|numeric'
		]);

		Topping::create($request->all());

		return redirect('/manage/toppings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topping  $topping
     * @return \Illuminate\Http\Response
     */
    public function show(Topping $topping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topping  $topping
     * @return \Illuminate\Http\Response
     */
    public function edit(Topping $topping)
    {
		return view('admin.editTopping')->withTopping($topping);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topping  $topping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topping $topping)
    {
		$this->validate($request, [
			'name' => 'required',
			'price' => 'required|min:0|numeric'
		]);

		$topping->name = $request->name;
		$topping->price = $request->price;
		$topping->save();

		return redirect('/manage/toppings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topping  $topping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topping $topping)
    {
		$topping->delete();

		return redirect('/manage/toppings');
    }
}
