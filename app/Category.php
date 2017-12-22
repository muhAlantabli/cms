<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\item;
use Baum\Node;

class Category extends Node
{
	protected $guarded = [];
    public function languages()
    {
    	return $this->belongsToMany('App\Language')->withPivot('category_id', 'language_id', 'title', 'desc');
    }

    public function items()
    {
        return $this->hasMany('App\Item');
    }

    public static function getCategoryType($id)
    {
    	$type= "";

        $categories = static::where('parent', $id)->get();

        if(count($categories) == 0) {
            $items = Item::where('category_id', $id)->get();
            if(count($items) == 1) {
                $type = "item_per_page";
            } else {
                $type = "list_of_items";
            }
        } else {
            $type= "list_of_categories";
        }

        return $type;
    }

    public function paddedTitle($id = 1)
    {
        return str_repeat('&nbsp;', $this->depth*4).$this->languages()->first()->pivot->title;
        $title =  Category::whereHas('languages', function($query) use ($id) {
            return $query->where('language_id', $id);
        })->get();

        //return $title;
        return str_repeat('&nbsp;', $title[0]->title);
    }

    public function updateOrder($parent_id)
    {
        $Category = $this->findOrFail($parent_id);
        $this->makeChildOf($Category);
    }
}
