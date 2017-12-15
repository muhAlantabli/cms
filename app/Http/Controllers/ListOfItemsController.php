<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
class ListOfItemsController extends Controller
{
   	public function show($page)
   	{
   		$items = Item::where('category_id', $page->id)->get();
        return view('pages.list_of_items', compact('items'));
   	}
}
