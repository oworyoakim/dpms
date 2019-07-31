<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListRolesController extends Controller
{
    public function index()
    {
        try
        {
            $permissions = [];
            $perms = Permission::where('parent_id', 0)->get();
            foreach ($perms as $permission) {
                array_push($permissions, $permission);
                $subs = Permission::where('parent_id', $permission->id)->get();
                foreach ($subs as $sub) {
                    array_push($permissions, $sub);
                }
            }
            return view('roles',compact('permissions'));
        } catch (Exception $ex)
        {
            return redirect('/');
        }
    }

    public function listRoles(Request $request)
    {
        try
        {
            $roles = Role::all();
            return response()->json($roles);
        } catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
