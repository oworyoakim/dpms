<?php

namespace App\Http\Controllers;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function userInfo()
    {
        $user = Sentinel::getUser();
        $role = $user->roles()->first();
        $data = [
            'user' => $user,
            'role' => $role,
        ];
        return response()->json($data);
    }
}
