<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use DB;

class PageController extends Controller
{
    public function show($page)
    {
        $category_url = Category::where('id', $page->category_id)->value('url');

        $urls = explode('/', $category_url);
        //return $urls;

        $custom_fields = DB::table('category_custom_field')
            ->select('category_custom_field.id', 'category_custom_field.field_key',
             'custom_field_item.value')
            ->join('custom_field_item', 'category_custom_field.id', '=', 'custom_field_item.field_id')
            ->where(['category_custom_field.category_id' => $page->category_id, 'custom_field_item.item_id' => $page->id])
            ->get();

            $tags = $page->tags;
            //return $item;
        if($page) {
            
            return view('pages.page', compact('page', 'custom_fields', 'urls', 'tags'));    
        } else {
            return view('pages.blank');
    }
}
}
