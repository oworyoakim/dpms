<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CreateUserController extends Controller
{

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try
        {
            $role_id = $request->get('role_id');
            if ($role_id && $role = Sentinel::getRoleRepository()->find($role_id))
            {
                $user = Sentinel::registerAndActivate([
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'username' => $request->get('username'),
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                ]);
                $role->users()->attach($user);
                return response()->json('User created!');
            }
            return response()->json('Role not found!', Response::HTTP_FORBIDDEN);
        }catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
