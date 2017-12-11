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
}
