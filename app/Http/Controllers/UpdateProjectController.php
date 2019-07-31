<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateProjectController extends Controller
{
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try
        {
            // check user
            $user = Sentinel::getUser();
            if ($user->id != $project->user_id)
            {
                return response()->json('This project does not belong to you!', Response::HTTP_FORBIDDEN);
            }

            $project->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'image' => $request->get('image'),
            ]);

            return response()->json('Project updated!');
        } catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
