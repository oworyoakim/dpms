<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Project;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class CreateProjectController extends Controller
{

    public function store(StoreProjectRequest $request)
    {
        $user = Sentinel::getUser();

        $project = $user->projects()->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'image' => $request->get('image'),
        ]);

        return response()->json($project);
    }
}
