<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use DB;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::all();
        return view('languages.index', compact('languages'));
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
        if(!auth()->user()->canDo('add.language')) {
            return redirect()->route('languages.index')->withErrors([
                'error' => 'You are not authorize !'
            ]);
        }

        $language = new Language;
        $language->name = $request->input('name');
        $language->direction = $request->input('dir');
        $language->slug = $request->input('slug');
        $language->save();

        return redirect()->route('languages.index');
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

        $language = Language::find($id);
        $dictionaryTexts = DB::table('dictionary')->where('language_id', '=', $id)->get();

        return view('languages.show', compact('language', 'dictionaryTexts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->canDo('delete.language')) {
            return redirect()->route('languages.index')->withErrors([
                'error' => 'You are not authorize !'
            ]);
        }

        $language = Language::find($id);
        DB::table('category_language')->where('language_id', '=', $id)->delete();
        DB::table('item_language')->where('language_id', '=', $id)->delete();
        DB::table('language_menu')->where('language_id', '=', $id)->delete();
        DB::table('dictionary')->where('language_id', '=', $id)->delete();
        $language->delete();

        return redirect()->route('languages.index');
    }
}
