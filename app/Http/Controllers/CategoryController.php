<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Language;
use DB;
use Session;
use App\Menu;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index')->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New Category';
        $categories = Category::all();
        $languages = Language::all();
        return view('categories.create', compact('category', 'title', 'categories_list', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:categories|max:10',
            'image' => 'required',
            'desc' => 'required'
        ]);

        $category = new Category;
        $category->parent = $request->input('parent');
        $category->title = $request->input('title');
        $url = '';
        $category->url = $this->setUrl($request->input('parent'), $url).strtolower($request->input('title'));

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $category->image = $image_name;
        }

        $category->desc = $request->input('desc');
        $category->created_by = auth()->user()->id;
        $category->updated_by = auth()->user()->id;

        $category->save();
        $category->languages()->attach($request->language_id);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        $items = Item::where('category_id', $category->id)->get();
        $custom_fields = DB::table('category_custom_field')->where('category_id', '=', $id)->get();
        return view('categories.show', compact('category', 'items', 'custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        $title = 'Edit Category';
        $languages = Language::all();
        return view('categories.edit', compact('category', 'title', 'categories', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request;
        
        $this->validate($request, [
            'title' => 'unique:categories',
        ]);
    
        $category = Category::find($id);
        $parent = $category->parent;

        $category->fill($request->only('title', 'parent', 'desc'));

        $url = '';
        if($request->has('title')) {
            $category->url = 
            $this->setUrl($request->has('parent') ? $request->input('parent') : $parent, $url).strtolower($request->input('title'));            
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $category->image = $image_name;
        }
        

        //$category->desc = $request->input('desc');
        $category->updated_by = auth()->user()->id;

        $category->save();
        //$category->languages()->attach($request->language_id);
        

        return redirect()->route('categories.show', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::where('category_id', $id)->first();
        if($menu) {
            $menu->languages()->detach();
            $menu->delete();
        }

        $items = Item::where('category_id', $id)->get();

        foreach ($items as $item) {
            DB::table('custom_field_item')->where('item_id', '=', $item->id)->delete();
            $item->languages()->detach();
            $item->delete();    
        }
        
        DB::table('category_custom_field')->where('category_id', '=', $id)->delete();
        
        $category = Category::find($id);
        $category->languages()->detach();
        $category->delete();
        
        return redirect()->route('categories.index');
    }


    public function setUrl($id, $url)
    {
        $parent = Category::where('id', $id)->get();
        //return $parent;
        if(!count($parent)) {
            return '';
        }

        if($parent[0]->url) {
            return $parent[0]->url.'/';
        }

        if($url) {
            $url = $url.'/'.strtolower($parent[0]->title);
        } else {
            $url = strtolower($parent[0]->title).'/';
        }
        
        $this->setUrl($parent[0]->parent, $url);

        return $url;
    }
}
