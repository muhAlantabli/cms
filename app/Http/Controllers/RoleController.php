<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \YaroslavMolchan\Rbac\Models\Role;
use \YaroslavMolchan\Rbac\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Role';

        return view('roles.create', compact('title'));
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
            'name' => 'required',
            'slug' => 'required'
        ]);

        $role = new Role;

        $role->name = $request->input('name');
        $role->slug = $request->input('slug');

        $role->save();

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        //return $role->permissions->toArray();
        
        $permissions = $role->permissions->toArray();


        return view('roles.show', compact('role', 'permissions')); 
    }

    public function addPermissions(Request $request) 
    {
        //return $request;
        $role = Role::find($request->input('role_id'));
        if($request->input('create_category') == 'on') {
            $role->attachPermission(1);
        }

        if($request->input('edit_category') == 'on') {
            $role->attachPermission(2);
        }

        if($request->input('show_category') == 'on') {
            $role->attachPermission(3);
        }

        if($request->input('delete_category') == 'on') {
            $role->attachPermission(4);
        }

        if($request->input('create_item') == 'on') {
            $role->attachPermission(5);
        }

        if($request->input('edit_item') == 'on') {
            $role->attachPermission(6);
        }

        if($request->input('show_item') == 'on') {
            $role->attachPermission(7);
        }

        if($request->input('delete_item') == 'on') {
            $role->attachPermission(8);
        }

        if($request->input('create_menu') == 'on') {
            $role->attachPermission(9);
        }

        if($request->input('edit_menu') == 'on') {
            $role->attachPermission(10);
        }

        if($request->input('show_menu') == 'on') {
            $role->attachPermission(11);
        }

        if($request->input('delete_menu') == 'on') {
            $role->attachPermission(12);
        }

        if($request->input('show_extrafield') == 'on') {
            $role->attachPermission(13);
        }

        if($request->input('add_extrafield') == 'on') {
            $role->attachPermission(14);
        }

        if($request->input('delete_extrafield') == 'on') {
            $role->attachPermission(15);
        }

        if($request->input('add_language') == 'on') {
            $role->attachPermission(16);
        }

        if($request->input('delete_language') == 'on') {
            $role->attachPermission(17);
        }

        if($request->input('translate_text') == 'on') {
            $role->attachPermission(18);
        }

        if($request->input('delete_text') == 'on') {
            $role->attachPermission(19);
        }

        if($request->input('delete_comment') == 'on') {
            $role->attachPermission(20);
        }

        if($request->input('add_tag') == 'on') {
            $role->attachPermission(21);
        }

        if($request->input('delete_tag') == 'on') {
            $role->attachPermission(22);
        }

        if($request->input('show_tag') == 'on') {
            $role->attachPermission(23);
        }
        
        return redirect()->route('roles.index');
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
        $role = Role::find($id);
        DB::table('role_user')->where('role_id', $role->id)->delete();

        $role->permissions()->detach();

        $role->delete();

        return redirect()->route('roles.index');
    }
}
