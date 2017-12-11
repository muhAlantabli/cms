<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    public function languages()
    {
    	return $this->belongsToMany('App\Language')->withPivot('category_id', 'language_id');
    }
}
