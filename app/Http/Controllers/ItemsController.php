<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use Illuminate\Http\Request;

class ItemsController extends Controller
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
        return view('items.index')->withItems(Item::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.createItem')->withCategories(Category::all());
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
			'name' => 'required',
			'ingredients' => 'required',
			'price' => 'required|numeric',
			'category_id' => 'required|exists:categories,id'
		]);

		Category::find($request->category_id)->items()->save(
			Item::make($request->all())
		);

		return redirect('/manage/items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('admin.editItem')->withItem($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
		$this->validate($request, [
			'name' => 'required',
			'ingredients' => 'required',
			'price' => 'required|min:0|numeric'
		]);

		$item->name = $request->name;
		$item->ingredients = $request->ingredients;
		$item->price = $request->price;
		$item->save();

		return redirect('/manage/items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
	{
		$item->delete();

		return redirect('/manage/items');
    }
}
