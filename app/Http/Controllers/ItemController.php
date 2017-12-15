<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Language;
use App\Category;
use DB;

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
        return $category;
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
        $this->validate($request, [
            'title' => 'required',
            'language_id' => 'required',
        ]);

        $item = new Item;
        $item->title = $request->input('title');
        $item->category_id = $request->input('category_id');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            
            $item->image = $image_name;
        }

        $item->desc = $request->input('desc');
        $item->info = $request->input('info');
        $item->created_by = auth()->user()->id;
        $item->updated_by = auth()->user()->id;

        $item->save();

        $item->languages()->attach($request->language_id);

        if($request->has('custom_field_value')) {
            DB::table('custom_field_item')->insert([
                'item_id' => $item->id,
                'value' => $request->input('custom_field_value'),
                'field_id' =>  $request->input('field_id')
            ]);
        } elseif ($request->hasFile('custom_field_value_file')) {
            $file = $request->file('file');
            $file_name = time()."-".$image->getClientOriginalExtension();
            $file->move('files', $file_name);
            DB::table('custom_field_item')->insert([
                'item_id' => $item->id,
                'value' => $file_name,
                'field_id' =>  $request->input('field_id')
            ]);
            
        } elseif($request->has('custom_field_value_t')) {
            DB::table('custom_field_item')->insert([
                'item_id' => $item->id,
                'value' => $request->input('custom_field_value_t'),
                'field_id' =>  $request->input('field_id')
            ]);
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
        //$custom_fields = DB::table('custom_field_item')->where('item_id', $item->id)->get();
        $custom_fields = DB::table('category_custom_field')
                    ->select('category_custom_field.id', 'category_custom_field.field_key', 'category_custom_field.type', 'custom_field_item.value')
                    ->leftjoin('custom_field_item', 'category_custom_field.id', '=', 'custom_field_item.field_id')
                    ->get();
        $title = "Edit Item";
        //return $custom_field;

        return view('items.edit', compact('languages', 'categories', 'title', 'item', 'category', 'custom_fields'));
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

        $item->fill($request->only(['title', 'info', 'desc', 'category_id']));
        
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time()."-".$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            
            $item->image = $image_name;
        }

        $item->updated_by = auth()->user()->id;
        $item->save();

        if($request->has('language_id')) {
            $item->languages()->sync($request->language_id);
        }

        if($request->has('custom_field_value')) {
            $query = DB::table('custom_field_item')->where('field_id', '=', $request->input('field_id'))->get();
            if(count($query)) {
                DB::table('custom_field_item')->where('item_id', '=', $item->id)
                ->where('field_id', '=', $request->input('field_id'))->update([
                    'value' => $request->input('custom_field_value'),
                ]);
            } else {
                DB::table('custom_field_item')->insert([
                'item_id' => $item->id,
                'value' => $request->input('custom_field_value'),
                'field_id' =>  $request->input('field_id')
            ]);
            }
            
        } elseif ($request->hasFile('custom_field_value_file')) {
            $query = DB::table('custom_field_item')->where('field_id', '=', $request->input('field_id'))->get();
            if(count($query)) {
                $file = $request->file('file');
                $file_name = time()."-".$image->getClientOriginalExtension();
                $file->move('files', $file_name);
                DB::table('custom_field_item')->where('item_id', '=', $item->id)
                ->where('field_id', '=', $request->input('field_id'))->update([
                    
                    'value' => $file_name,
                    
                ]);
            } else {
                $file = $request->file('file');
                $file_name = time()."-".$image->getClientOriginalExtension();
                $file->move('files', $file_name);
                DB::table('custom_field_item')->insert([
                    'item_id' => $item->id,
                    'value' => $file_name,
                    'field_id' =>  $request->input('field_id')
                ]);
            }
            
            
        } elseif($request->has('custom_field_value_t')) {
            $query = DB::table('custom_field_item')->where('field_id', '=', $request->input('field_id'))->get();
            if(count($query)) {
                DB::table('custom_field_item')->where('item_id', '=', $item->id)
                ->where('field_id', '=', $request->input('field_id'))->update([
                    
                    'value' => $request->input('custom_field_value_t'),
                    
                ]);
            } else {
                DB::table('custom_field_item')->insert([
                    'item_id' => $item->id,
                    'value' => $request->input('custom_field_value_t'),
                    'field_id' =>  $request->input('field_id')
                ]);
            }
            
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
