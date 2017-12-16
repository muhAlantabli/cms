<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
class ItemPerPageController extends Controller
{
   	public function show($page)
   	{
      $url = $page->url;
      
   		$item = Item::where('category_id', $page->id)->get();
            //return $item;
        if(count($item)) {
            $item = $item[0];
            return view('pages.item_per_page', compact('item', 'url'));    
        } else {
            return view('pages.blank');
   	}
}
}
