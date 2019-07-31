<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateProjectController extends Controller
{

    /**
     * @param StoreProjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        try
        {
            $user = Sentinel::getUser();

            $project = $user->projects()->create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'image' => $request->get('image'),
            ]);

            return response()->json('Project created!');
        } catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
