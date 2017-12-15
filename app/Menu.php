<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;

class Menu extends Node
{
    protected $guarded= [];
     public function languages()
    {
    	return $this->belongsToMany('App\Language')->withPivot('menu_id', 'language_id');
    }

    public function paddedName()
    {
    	return str_repeat('&nbsp;', $this->depth*4).$this->name;
    }

    public function updateOrder($order, $orderPage)
    {
    	$orderPage = $this->findOrFail($orderPage);

    	if($order == 'before') {
    		$this->moveToLeftOf($orderPage);
    	} elseif($order == 'after') {
    		$this->moveToRightOf($orderPage);
    	} else {
    		$this->makeChildOf($orderPage);
    	}
    }
}
