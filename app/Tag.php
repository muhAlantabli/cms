<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

	protected $table = 'tags';
	
    protected $guarded = [];

    public function items()
    {
    	return $this->belongsToMany('App\Item')->withPivot('tag_id', 'item_id');
    }
}
