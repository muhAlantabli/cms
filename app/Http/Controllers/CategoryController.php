<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Language;
use DB;
use Session;
use App\Menu;
use Baum\MoveNotPossibleException;
use App\Comment;

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
        //return Category::with('languages')->get();

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
        if(!auth()->user()->canDo('create.category')) {
            return redirect()->route('categories.index')->withErrors([
                'error' => 'You are not authorize !'
            ]);
        }

        $title = 'Create New Category';
        $categories = Category::all();
        $languages = Language::all();
        return view('categories.create', compact('category', 'title', 'categories', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //return $request;
        $this->validate($request, [
            'slug' => 'unique:categories'
        ]);

        if($request->has('parent_id')) {
            $menu = Menu::where('category_id', $request->input('parent_id'))->first();
            if($menu) {
                if($menu->type != 'list_of_categories') {
                    return redirect()->route('categories.index')->withErrors([
                        'error' => 'You Can not add categories to this category'
                    ]);
                }
            } else {
                $items = Item::where('category_id', $request->input('parent_id'))->first();
                if($items) {
                    return redirect()->route('categories.index')->withErrors([
                        'error' => 'You can not add Catgeory to this Category Parent.'
                    ]);
                }
            }
        }

        $category = new Category;

        foreach(Language::all() as $language) {

            if($language->slug == "en") {
                $url = '';
                $category->url = $this->setUrl($request->input('parent_id'), $url).strtolower($request->input('slug'));

                if($request->hasFile('image')) {
                    $image = $request->file('image');
                    $image_name = time()."-".$image->getClientOriginalExtension();
                    $image->move('images', $image_name);
                    $category->image = $image_name;
                }

                $category->created_by = auth()->user()->id;
                $category->updated_by = auth()->user()->id;
            }

        }

        $category->slug = $request->input('slug');
        $category->save();

        $this->updateCategoryOrder($category, $request);            
        $category->save();

        foreach (Language::all() as $language) {
            if($request->input('title_'.$language->slug) && $request->input('title_'.$language->slug)) {
                $category->languages()->attach($language->id, ['title' => $request->input('title_'.$language->slug), 'desc' => $request->input('desc_'.$language->slug)]);
            }    
        }
        
        Session::flash('success', 'This Category was successfully created.');

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
        if(!auth()->user()->canDo('show.category')) {
            return redirect()->route('categories.index')->withErrors([
                'error' => 'You are not authorize !'
            ]);
        }
        $category = Category::find($id);

        //return $category->languages()->first()->pivot->title;
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
        if(!auth()->user()->canDo('edit.category')) {
            return redirect()->route('categories.index')->withErrors([
                'error' => 'You are not authorize !'
            ]);
        }

        $category = Category::find($id);
        //return $category;
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
        $category = Category::find($id);
        if($request->input('slug') != $category->slug) {
            $this->validate($request, [
                'slug' => 'unique:categories'
            ]);
        }
        
        $parent_id = $category->parent_id;

        foreach(Language::all() as $language) {
            if($language->slug == 'en') {
                $category->fill($request->only('parent_id'));  
                
                $url = '';
        
                if($request->has('parent_id')) {
                    $category->url = 
                    $this->setUrl($request->input('parent_id'), $url).strtolower($request->input('slug'));            
                }

                if($request->has('title_en') && !$request->has('parent_id')) {
                    $category->url = 
                    $this->setUrl($parent_id, $url).strtolower($request->input('slug'));            
                }

                

                if($request->hasFile('image')) {
                    $image = $request->file('image');
                    $image_name = time()."-".$image->getClientOriginalExtension();
                    $image->move('images', $image_name);
                    $category->image = $image_name;
                }


            }

        }

        $category->updated_by = auth()->user()->id;

        if($response = $this->updateCategoryOrder($category, $request)) {
            return $response;
        }    
        $category->slug = $request->input('slug');
        $category->save();

        $data = [];
        foreach(Language::all() as $language) {
            $data[$language->id] = [ 'title' => $request->input('title_'.$language->slug),
            'desc' => $request->input('desc_'.$language->slug)];
           
        }

         $category->languages()->sync($data);
        
        Session::flash('success', 'This Category was successfully updated.');
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
        if(!auth()->user()->canDo('delete.category')) {
            return redirect()->route('categories.index')->withErrors([
                'error' => 'You are not authorize !'
            ]);
        }


        $menu = Menu::where('category_id', $id)->first();
        if($menu) {
            $menu->languages()->detach();
            $menu->delete();
        }

        $items = Item::where('category_id', $id)->get();

        foreach ($items as $item) {
            $comments = Comment::where('item_id', $item->id)->get();
            foreach($comments as $comment) {
                $comment->delete();
            }
            $item->tags()->detach();
            DB::table('custom_field_item')->where('item_id', '=', $item->id)->delete();
            $item->languages()->detach();
            $item->delete();    
        }
        
        DB::table('category_custom_field')->where('category_id', '=', $id)->delete();
        
        $category = Category::find($id);
        foreach($category->children as $child) {
            $child->makeRoot();
            $url = '';
            $this->setChildUrl($child, $url, $category->parent_id).strtolower($child->slug);
            $child->save();
        }

        $category->languages()->detach();
        $category->delete();
        
        Session::flash('success', 'This Category was successfully deleted.');
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
            $url = $url.'/'.strtolower($parent[0]->slug);
        } else {
            $url = strtolower($parent[0]->languages()->slug).'/';
        }
        
        $this->setUrl($parent[0]->parent_id, $url);

        return $url;
    }

    public function updateCategoryOrder(Category $category, Request $request)
    {
        if($request->has('parent_id')) {
            try {
                $category->updateOrder($request->input('parent_id'));
            } catch (MoveNotPossibleException $e) {
                return redirect()->route('categories.index')->withInput()->withErrors([
                    'error' => 'Can not make an category child of itself.'
                ]);
            }
        }
    }

    public function setChildUrl(Category $child, $url, $parent_id)
    {
        $child->url = $this->setUrl($parent_id, $url).strtolower($child->slug);
        $child->save();

        foreach($child->children as $ch) {
            $this->setChildUrl($ch, $url, $ch->parent_id);
        }

        if(!count($child->children)) {
            return;
        }

    }
}
