<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use stdClass;

class ListUsersController extends Controller
{
    public function index()
    {
        try
        {
            $roles = Role::all();
            return view('users',compact('roles'));
        } catch (Exception $ex)
        {
            return redirect('/');
        }
    }

    public function listUsers(Request $request)
    {
        try
        {
            $builder = User::with(['projects']);
            $users = $builder->get()->transform(function (User $item){
                $user = new stdClass();
                $user->id = $item->id;
                $user->firstName = $item->first_name;
                $user->lastName = $item->last_name;
                $user->email = $item->email;
                $user->username = $item->username;
                $user->role = $item->roles()->first();
                $user->projects = $item->projects;
                return $user;
            });
            return response()->json($users);
        } catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
