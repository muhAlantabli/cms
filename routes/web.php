<?php
use App\Language;
use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Tag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


foreach(Language::all() as $language) {
	Route::group(['prefix' => $language->slug ], function() use ($language){
		Route::get('/', function () use ($language){
		    session(['slug' => $language->slug ]);
		    session(['lang_id'=> $language->id]);
		    //return session('lang_id');
		    return view('welcome');
		});
	});
}



Route::get('/backend', function() {
    return view('admin.index');
})->middleware('auth');

Route::resource('/backend/categories', 'CategoryController');

Route::get('/backend/categories/custom_fields/create_custom_field/{id}', [ 'as' => 'categories.create_custom_field' ,function($id) {
	
	return view('custom_fields.create', compact('id'));
}]);

Route::post('/backend/categories/custom_fields', [ 'as' => 'categories.store_custom_field' ,function(Request $request) {
	//return $request;
	DB::table('category_custom_field')->insert([
		'category_id' => $request->input('category_id'),
		'field_key' => $request->input('field_key'),
		'type' => $request->input('type')
	]);

	return redirect()->route('categories.show', $request->input('category_id'));
}]);

Route::delete('/backend/categories/custom_fields/{category_id}/{id}', [ 'as' => 'categories.delete_custom_field' ,function($category_id, $id) {
	
	$items = Item::where('category_id', $category_id)->get();
	foreach($items as $item) {
		DB::table('custom_field_item')->where('item_id', '=', $item->id)->delete();
	}
	DB::table('category_custom_field')->where('id', '=', $id)->delete();
	return redirect()->route('categories.show', $category_id);
}]);

//Item Extra Field


Route::resource('/backend/items', 'ItemController')->middleware('auth');
Route::resource('comments', 'CommentController')->middleware('auth');
Route::resource('tags', 'TagController')->middleware('auth');
Route::post('/search', [ 'as' => 'search' , function(Request $request) {
	$text = $request->input('search');
	return $text;
	return $this->app->call('App\Http\Controllers\TagController@search', [
            'text' => $text,
        ]); 
}]);
Route::resource('languages', 'LanguageController')->middleware('auth');

Route::get('/languages/translate/{id}', [ 'as' => 'languages.translate' ,function($id) {
		return view('languages.translate', compact('id'));
	}]);

Route::post('/languages/translate_text', [ 'as' => 'languages.store_text' ,function(Request $request) {
		DB::table('dictionary')->insert([
			'text' => $request->input('text'),
			'translated_text' => $request->input('translated_text'),
			'language_id' => $request->input('language_id')
		]);

		return redirect()->route('languages.show', $request->input('language_id'));
	}]);

Route::delete('/delete_text/{language_id}/{id}', function($language_id, $id) {
	DB::table('dictionary')->where('id', '=', $id)->delete();

	return redirect()->route('languages.show', $language_id);
});

Route::get('/backend/items/create/{id}', function($id) {
	$languages = Language::all();
    $title = "Create Item";
    $category_id = $id;
    $custom_fields = DB::table('category_custom_field')->where('category_id', $id)->get();
    $tags = Tag::all();

    return view('items.create', compact('languages', 'category_id', 'title', 'custom_fields', 'tags'));
});
Route::resource('/backend/menus', 'MenuController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
