<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Category;
use App\Item;
use App\Menu;
use App\Language;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
             ///////////////////
        
        /////////////////////////////////
        foreach(Language::all() as $language) {
            Route::group(['prefix' => $language->slug ], function() {
                //App::setLocale($language->slug);
                foreach(Category::all() as $category) {
                    foreach(Item::where('category_id', $category->id)->get() as $item) {
                        Route::get($category->url.'/'.$item->id, ['middleware' => 'web', 'as' => $category->url.'.'.$item->id, function() use ($item) {
                                //App::setLocale($language->slug);
                                return $this->app->call('App\Http\Controllers\PageController@show', [
                            'page' => $item,
                        ]);
                        }]);
                    }

                    Route::get($category->url, ['middleware' => 'web', 'as' => $category->slug, function() use ($category) {

                        $categories = Category::where('parent_id', $category->id)->get();
                        $menu = Menu::where('category_id', $category->id)->first();

                        /////////////////////////////////////////////
                        if($menu) {
                            if(count($categories) == 0) {
                                $items = Item::where('category_id', $category->id)->get();
                                if(count($items) == 1 && $menu->type == 'item_per_page') {
                                    return $this->app->call('App\Http\Controllers\ItemPerPageController@show', [
                                        'page' => $category,
                                    ]);    
                                } else {
                                    return $this->app->call('App\Http\Controllers\ListOfItemsController@show', [
                                        'page' => $category,
                                    ]);
                                }
                            } else {
                                return $this->app->call('App\Http\Controllers\ListOfCategoriesController@show', [
                                    'page' => $category,
                                ]);
                            }

                        } else {
                            if(count($category->items)) {
                                return $this->app->call('App\Http\Controllers\ListOfItemsController@show', [
                                    'page' => $category,
                                ]);
                            } else {
                                return $this->app->call('App\Http\Controllers\ListOfCategoriesController@show', [
                                    'page' => $category,
                                ]);  
                            }
                        }

                        ////////////////////////////////////////////

                    }]);
              
                }
            });    
        }
        
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
