<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Task;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class CreateTaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        try
        {
            $user = Sentinel::getUser();
            $project_id = $request->get('project_id');
            if($project_id && $project = $user->projects()->find($project_id)){
                $task = $project->tasks()->save(new Task([
                    'title' => $request->get('title'),
                    'due_date' => Carbon::parse($request->get('due_date')),
                    'description' => $request->get('description'),
                    'user_id'=>$user->id,
                ]));
                return response()->json('Task created!');
            }
            return response()->json('Project not found!',Response::HTTP_NOT_FOUND);
        } catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
