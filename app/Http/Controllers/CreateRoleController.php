<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Role;
use Exception;
use Illuminate\Http\Response;

class CreateRoleController extends Controller
{
    public function store(StoreRoleRequest $request){
        try{
            $role = Role::create([
              'name'=> $request->get('name'),
              'slug'=> $request->get('slug'),
            ]);
            return response()->json($role);
        }catch (Exception $ex){
            return response()->json($ex->$this->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
