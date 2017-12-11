<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
     public function languages()
    {
    	return $this->belongsToMany('App\Language')->withPivot('page_id', 'language_id');
    }
}
