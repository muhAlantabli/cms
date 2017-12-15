<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
class PageController extends Controller
{
   	public function show($page)
   	{
   		
   		//return view('pages.list_of_items', compact('items'));
   		//return $page;
   		//$items = Item::where('category_id', $page->id)->get();
      //return view('pages.list_of_items', compact('items'));
   		if($page->type == "item_per_page") {
            $item = Item::where('category_id', $page->id)->get();
            //return $item;
            if(count($item)) {
                $item = $item[0];
                return view('pages.item_per_page', compact('item'));    
            } else {
                return view('pages.blank');    
            }
            

        } elseif($page->type == "list_of_items") {
            $items = Item::where('category_id', $page->id)->get();
            return view('pages.list_of_items', compact('items'));

        } else {
            $categories = Category::where('parent', $page->id)->get();
            return view('pages.list_of_categories', compact('categories'));

        }
   	}
}
