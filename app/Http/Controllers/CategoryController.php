<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Language;
use DB;

class CategoryController extends Controller
{

    protected $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $categories;
        return view('categories.index')->withCategories($this->categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        //return $category;
        $title = 'Create New Category';
        $categories_list = $this->categories;
        $languages = Language::all();
        return view('categories.form', compact('category', 'title', 'categories_list', 'languages'));
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
            'title' => 'required|unique:categories',
            'image' => 'required',
            'desc' => 'required'
        ]);

        $category = new Category;
        $category->parent = $request->input('parent');
        $category->title = $request->input('title');
        

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            
            $category->image = $image_name;
        }

        $category->desc = $request->input('desc');
        $category->created_by = 1;
        $category->updated_by = 1;

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

        return view('categories.show', compact('category'));
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
        $categories_list = $this->categories;
        
        //return $content;
        $title = 'Edit Category';
        $languages = Language::all();

        //return $category;

        return view('categories.update', compact('category', 'title', 'categories_list', 'languages'));
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

        return $request;
        $this->validate($request, [
            'title' => 'unique:categories',
        ]);

        $category = Category::find($id);
        //return $category;
        $category->parent = $request->input('parent');
        $category->title = $request->input('title');
        
        if($request->image != $category->image) {
            if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            
            $category->image = $image_name;
        }
        }

        $category->desc = $request->input('desc');
        $category->created_by = 1;
        $category->updated_by = 1;

        $category->save();

        //$category->fill($request->only())


        return redirect()->route('categories.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Item::where('category_id', $id)->get();

        foreach ($items as $item) {
            $item->languages()->detach();
            $item->delete();    
        }
        

        $category = Category::find($id);

        $category->languages()->detach();

        $category->delete();



        return redirect()->route('categories.index');
    }
}
