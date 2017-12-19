<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use App\Category;
use App\Language;
use Baum\MoveNotPossibleException;
use App\Item;
use Session;

class MenuController extends Controller
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
        //return Menu::all()->toHierarchy();
        $menus = Menu::all();

        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $title = "Create New Menu item";
        $languages = Language::all();
        $menuList = Menu::all();
        return view('menus.create', compact('categories', 'title', 'languages', 'menuList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if($request->type != "parent") {
                $this->validate($request, [
                'name' => 'required',
                'category_id' => 'required'
                ]);    
            } else {
                $this->validate($request, [
                'name' => 'required',
                
                ]);
            }
            

            $menu = new Menu;
            $menu->name = $request->input('name');
            $menu->category_id = $request->input('category_id');
            $menu->type = $request->input('type');

            $menu->save();

            $menu->languages()->attach($request->input('language_id'));

            $this->updateMenuOrder($menu, $request);

            $menu->save();

            Session::flash('success', 'This Menu item was successfully created.');
            return redirect()->route('menus.index');    
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        $title = "Edit Menu item";
        $languages = Language::all();
        $menuList = Menu::all();
        return view('menus.edit', compact('categories', 'title', 'languages', 'menuList', 'menu'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'category_id' => 'required'
        ]);
        
        $menu->fill($request->only('name', 'type', 'category_id'))->save();

        if($response = $this->updateMenuOrder($menu, $request)) {
            return $response;
        }

        Session::flash('success', 'This Menu item was successfully updated.');
        return redirect()->route('menus.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if($menu->type == "item_per_page" && auth()->user()->type == 'dbentry') {
            return redirect()->route('menus.index')->withErrors([
                'error' => 'You can not delete item per page type'
            ]);
        }
        foreach($menu->children as $child) {
            $child->makeRoot();
        }

        $menu->languages()->detach();

        $menu->delete();

        Session::flash('success', 'This Menu item was successfully deleted.');
        return redirect()->route('menus.index');
    }

    public function getMenuType($id)
    {
        $type= "";

        $categories = Category::where('parent_id', $id)->get();

        if(count($categories) == 0) {
            $items = Item::where('category_id', $id)->get();
            if(count($items) == 1) {
                $type = "item_per_page";
            } else {
                $type = "list_of_items";
            }
        } else {
            $type= "list_of_categories";
        }

        return $type;
    }

    public function updateMenuOrder(Menu $menu, Request $request)
    {
        if($request->has('order', 'orderPage')) {
            try {
                $menu->updateOrder($request->input('order'), $request->input('orderPage'));
            } catch (MoveNotPossibleException $e) {
                return redirect()->back()->withInput()->withErrors([
                    'error' => 'Can not make an item child of itself.'
                ]);
            }
        }
    }
}
