<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Language;
use App\Category;
use DB;
use App\Menu;
use App\Tag;

class ItemController extends Controller
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
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return $category;
        $languages = Language::all();
        $title = "Create Item";

        return view('items.create', compact('languages', 'category', 'title'));
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
        foreach(Language::all() as $language) {
            $this->validate($request, [
            'title_'.$language->slug => 'required',
            'desc_'.$language->slug => 'required',
            'info_'.$language->slug => 'required'
        ]);
        }

        $menu = Menu::where('category_id', $request->input('category_id'))->first();
        if($menu) {
            if($menu->type == 'list_of_categories') {
                return redirect()->route('categories.index')->withErrors([
                    'error' => 'You Can not add items to this category'
                ]);
            } elseif($menu->type == 'item_per_page') {
                $items = Item::where('category_id', $request->input('category_id'))->get();
                if(count($items) >= 1) {
                   return redirect()->route('categories.index')->withErrors([
                    'error' => 'You Can not add items to this category'
                ]); 
                }
            }
        }

        $parent = Category::where('id', $request->input('category_id'))->first();
        if(count($parent->children)) {
            return redirect()->route('categories.index')->withErrors([
                'error' => 'You can not add item to this Category Parent.'
            ]);
        }
        

        $item = new Item;
        
        $item->category_id = $request->input('category_id');
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            
            $item->image = $image_name;
        }

        $item->created_by = auth()->user()->id;
        $item->updated_by = auth()->user()->id;

        $item->save();
        foreach(Language::all() as $language) {
            $item->languages()->attach($language->id, ['title' => $request->input('title_'.$language->slug), 'desc' => $request->input('desc_'.$language->slug), 'info' => $request->input('info_'.$language->slug)]);
            $item->tags()->sync($request->input('tags_'.$language->slug), false);
        }
        
        if($request->input('length') > 0) {
            for($i =0; $i < $request->input('length'); $i++) {
                if($request->has('custom_field_value'.$i)) {
                    DB::table('custom_field_item')->insert([
                        'item_id' => $item->id,
                        'value' => $request->input('custom_field_value'.$i),
                        'field_id' =>  $request->input('field_id'.$i)
                    ]);
                } elseif ($request->hasFile('custom_field_value_file'.$i)) {
                    $file = $request->file('file');
                    $file_name = time()."-".$image->getClientOriginalExtension();
                    $file->move('files', $file_name);
                    DB::table('custom_field_item')->insert([
                        'item_id' => $item->id,
                        'value' => $file_name,
                        'field_id' =>  $request->input('field_id'.$i)
                    ]);
                    
                } elseif($request->has('custom_field_value_t'.$i)) {
                    DB::table('custom_field_item')->insert([
                        'item_id' => $item->id,
                        'value' => $request->input('custom_field_value_t'.$i),
                        'field_id' =>  $request->input('field_id'.$i)
                    ]);
                }
            }
        }
        
        return redirect()->route('categories.show', $item->category_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $custom_fields = DB::table('category_custom_field')
                        ->select('category_custom_field.id', 'category_custom_field.field_key', 'category_custom_field.type', 'custom_field_item.value')
                        ->leftjoin('custom_field_item', 'category_custom_field.id', '=', 'custom_field_item.field_id')
                        ->where(['category_custom_field.category_id' => $item->category_id, 'custom_field_item.item_id' => $item->id])
                        ->get();
        return view('items.show', compact('item', 'custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $languages = Language::all();
        $categories = Category::all();
        $category = $item->category_id;
        
        $custom_fields = DB::table('category_custom_field')
                    ->select('category_custom_field.id', 'category_custom_field.field_key', 'category_custom_field.type', 'custom_field_item.value')
                    ->leftjoin('custom_field_item', 'category_custom_field.id', '=', 'custom_field_item.field_id')
                    
                    ->where(['category_custom_field.category_id' => $item->category_id, 'custom_field_item.item_id' => $item->id])
                    ->get();
        $title = "Edit Item";
        //return $custom_field;
        $tags = Tag::all();

        return view('items.edit', compact('languages', 'categories', 'title', 'item', 'category', 'custom_fields', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //return $request;

        $item->fill($request->only(['category_id']));
        
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            
            $item->image = $image_name;
        }

        $item->updated_by = auth()->user()->id;
        $item->save();

        $data = [];
        foreach(Language::all() as $language) {
            $data[$language->id] = ['title' => $request->input('title_'.$language->slug), 'desc' => $request->input('info_'.$language->slug)];
        }

        $item->languages()->sync($data);

        if($request->input('length') > 0) {
            for($i =0; $i < $request->input('length'); $i++) {
                if($request->has('custom_field_value'.$i)) {
                    $query = DB::table('custom_field_item')->where('field_id', '=', $request->input('field_id'.$i))->get();
                    if(count($query)) {
                        DB::table('custom_field_item')->where('item_id', '=', $item->id)
                        ->where('field_id', '=', $request->input('field_id'.$i))->update([
                            'value' => $request->input('custom_field_value'.$i),
                        ]);
                    } else {
                        DB::table('custom_field_item')->insert([
                        'item_id' => $item->id,
                        'value' => $request->input('custom_field_value'.$i),
                        'field_id' =>  $request->input('field_id'.$i)
                    ]);
                    }
                    
                } elseif ($request->hasFile('custom_field_value_file')) {
                    $query = DB::table('custom_field_item')->where('field_id', '=', $request->input('field_id'.$i))->get();
                    if(count($query)) {
                        $file = $request->file('file');
                        $file_name = time()."-".$image->getClientOriginalExtension();
                        $file->move('files', $file_name);
                        DB::table('custom_field_item')->where('item_id', '=', $item->id)
                        ->where('field_id', '=', $request->input('field_id'.$i))->update([
                            
                            'value' => $file_name,
                            
                        ]);
                    } else {
                        $file = $request->file('file');
                        $file_name = time()."-".$image->getClientOriginalExtension();
                        $file->move('files', $file_name);
                        DB::table('custom_field_item')->insert([
                            'item_id' => $item->id,
                            'value' => $file_name,
                            'field_id' =>  $request->input('field_id'.$i)
                        ]);
                    }
                    
                    
                } elseif($request->has('custom_field_value_t'.$i)) {
                    $query = DB::table('custom_field_item')->where('field_id', '=', $request->input('field_id'.$i))->get();
                    if(count($query)) {
                        DB::table('custom_field_item')->where('item_id', '=', $item->id)
                        ->where('field_id', '=', $request->input('field_id'.$i))->update([
                            
                            'value' => $request->input('custom_field_value_t'.$i),
                            
                        ]);
                    } else {
                        DB::table('custom_field_item')->insert([
                            'item_id' => $item->id,
                            'value' => $request->input('custom_field_value_t'.$i),
                            'field_id' =>  $request->input('field_id'.$i)
                        ]);
                    }
                    
                }
            }
        }

        if(isset($request->tags)) {
            $item->tags()->sync($request->input('tags'));
        } else {
            $item->tags()->sync([]);
        }

        
        return redirect()->route('categories.show', $item->category_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        DB::table('custom_field_item')->where('item_id', '=', $item->id)->delete();
        $id = $item->category_id;
        $item->languages()->detach();
        
        $item->delete();

        return redirect()->route('categories.show', $id);
    }
}
