<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function login(Request $request)
    {
        try{
            if (Sentinel::check()) {
                return redirect('/');
            }
            return view('login');
        }catch (Exception $ex){
            return redirect('/');
        }
    }

    public function processLogin(ProcessLoginRequest $request)
    {
        try{
            $credentials = [
                "username" => $request->get('username'),
                "password" => $request->get('password'),
            ];
            //dd($credentials);
            if ($user = Sentinel::authenticate($credentials)) {
                //logged in, redirect
                return response()->json('Login successful!');
            } else {
                //return back
                return response()->json('Invalid Credentials!',Response::HTTP_BAD_REQUEST);
            }
        }catch (Exception $ex){
            Log::error($ex->getMessage());
            return response()->json('Server error, try again!',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(){
        try{
            $user = Sentinel::getUser();
            Sentinel::logout($user, true);
            return response()->json('Logged out!');
        }catch (Exception $ex){
            Log::error($ex->getMessage());
            return response()->json('Server error, try again!',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
