<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
class ListOfCategoriesController extends Controller
{
   	public function show($page)
   	{
   		$urls = explode('/', $page->url);
   		//return $urls;

   		$categories = Category::where('parent_id', $page->id)->get();
       	return view('pages.list_of_categories', compact('categories', 'urls'));
   	}
}
