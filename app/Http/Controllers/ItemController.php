<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Language;
use App\Category;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::all();
        $categories = Category::all();
        $title = "Create Item";

        return view('items.create', compact('languages', 'categories', 'title'));
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
            'title' => 'required',
            'language_id' => 'required',
        ]);

        $item = new Item;
        $item->title = $request->input('title');
        $item->category_id = $request->input('category_id');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            
            $item->image = $image_name;
        }

        $item->desc = $request->input('desc');
        $item->info = $request->input('info');
        $item->created_by = 1;
        $item->updated_by = 1;

        $item->save();

        $item->languages()->attach($request->language_id);

        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $languages = Language::all();
        $categories = Category::all();
        $title = "Edit Item";

        return view('items.edit', compact('languages', 'categories', 'title', 'item'));
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
        return redirect('item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->languages()->detach();

        $item->delete();

        return redirect()->route('items.index');
    }
}
