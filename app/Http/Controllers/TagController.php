<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Tag;
use Illuminate\Http\Request;
use Input;
use DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index')->withTags(Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'unique:tags',
        ]);

        $tag = new Tag;

        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //return $tag->items->get();
        $items = $tag->items;
        return view('tags.show', compact('items', 'tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $link_tag = DB::table('link_tag')->where('tag_id', '=', $tag->id)->delete();

        $tag->delete();

        return redirect()->route('tags.index');
    }

    public function search(Request $request)
    {
        $text = $request->input('search');

        $items = Item::whereHas('languages', function($query) use ($text) {
            return $query->where('language_id', session('lang_id'))->where('title', 'like', '%' . $text . '%');
        })->get()->toArray();

        //$items = Item::where('title', 'like', '%' . $text . '%')->get()->toArray();
        //return $items;
        $itemTags = Item::whereHas('tags', function ($query) use ($text) {
            return $query->where('name', $text);
        })->get()->toArray();

        //return Category::find(72)->items;

        $categoryTags = [];
        foreach (Category::all() as $category) {
            if($category->languages->find(session('lang_id'))) {
                    if ($category->languages->find(session('lang_id'))->pivot->title == $text && count($category->children)) {
                    $categoryTags = $this->getAllItems($category->children, $categoryTags, $text);
                } elseif ($category->languages->find(session('lang_id'))->pivot->title == $text) {
                    foreach ($category->items as $item) {
                        array_push($categoryTags, $item);
                    }
                }
            } else {
                if ($category->languages->first()->pivot->title == $text && count($category->children)) {
                $categoryTags = $this->getAllItems($category->children, $categoryTags, $text);
            } elseif ($category->languages->first()->pivot->title == $text) {
                foreach ($category->items as $item) {
                    array_push($categoryTags, $item);
                }
            }
            }
            
        }

        $allItems = array_merge($items, $itemTags, $categoryTags);
        $allItems = collect($allItems)->unique('id');

        //return $allItems;
        return view('pages.searchResults', compact('allItems'));
    }

    public function search2($text)
    {
        //$text = $request->input('search');

        $items = Item::whereHas('languages', function($query) use ($text) {
            return $query->where('language_id', session('lang_id'))->where('title', 'like', '%' . $text . '%');
        })->get()->toArray();

        //$items = Item::where('title', 'like', '%' . $text . '%')->get()->toArray();
        //return $items;
        $itemTags = Item::whereHas('tags', function ($query) use ($text) {
            return $query->where('name', $text);
        })->get()->toArray();

        //return Category::find(72)->items;

        $categoryTags = [];
        foreach (Category::all() as $category) {
            if($category->languages->find(session('lang_id'))) {
                if ($category->languages->find(session('lang_id'))->pivot->title == $text && count($category->children)) {
                $categoryTags = $this->getAllItems($category->children, $categoryTags, $text);
            } elseif ($category->languages->find(session('lang_id'))->pivot->title == $text) {
                foreach ($category->items as $item) {
                    array_push($categoryTags, $item);
                }
            }
            } else {
                if ($category->languages->first()->pivot->title == $text && count($category->children)) {
                $categoryTags = $this->getAllItems($category->children, $categoryTags, $text);
            } elseif ($category->languages->first()->pivot->title == $text) {
                foreach ($category->items as $item) {
                    array_push($categoryTags, $item);
                }
            }
            }
            
        }

        $allItems = array_merge($items, $itemTags, $categoryTags);
        $allItems = collect($allItems)->unique('id');

        //return $allItems;
        return view('pages.searchResults', compact('allItems'));
    }

    public function getAllItems($categories, $items, $text)
    {
        foreach ($categories as $category) {
            //return $category;
            if (count($category->children)) {
                $items = $this->getAllItems($category->children, $items, $text);
            } elseif ($category->items) {
                foreach ($category->items as $item) {
                    array_push($items, $item);
                }
            }
        }

        return $items;
    }
}
