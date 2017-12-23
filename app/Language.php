<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Language extends Model
{
    public function categories()
    {
    	return $this->belongsToMany('App\Category');
    }

    public static function translate($text)
    {
    	$collection = DB::table('dictionary')->where('text', '=', $text)->where('language_id', '=', session('lang_id'))->get();
    	if(count($collection)) {
    		return $collection[0]->translated_text;
    	} else {
    		return $text;
    	}
    }

    public static function paddedDesc($text)
    {
        if(strlen($text) == 50) {
            return $text;
        } elseif(strlen($text) < 50) {
            $test = '';
            for($i=0; $i < (50 - strlen($text)); $i++) {
                $test = $test.'&nbsp;';
            }
            return $text.'<p>'.$test.'</p>';
        } else {
            return '<p>'.substr($text, 0, 50).'</p>';
        }
    }
}
