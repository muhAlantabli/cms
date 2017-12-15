<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
class ListOfCategoriesController extends Controller
{
   	public function show($page)
   	{
   		 $categories = Category::where('parent', $page->id)->get();
       return view('pages.list_of_categories', compact('categories'));
   	}
}
