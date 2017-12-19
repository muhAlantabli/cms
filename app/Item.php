<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $guarded= [];

    public function languages()
    {
    	return $this->belongsToMany('App\Language')->withPivot('item_id', 'language_id');
    }

    public function tags()
    {
    	return $this->belongsToMany('App\Tag', 'item_tag', 'item_id', 'tag_id');
    }

    public function categories()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }
}
