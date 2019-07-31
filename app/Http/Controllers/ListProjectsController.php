<?php

namespace App\Http\Controllers;

use App\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListProjectsController extends Controller
{
    public function index(){
        try{
            return view('projects');
        }catch (Exception $ex){
            return redirect('/');
        }
    }

    public function listProjects(Request $request){
        try{
            $builder = Project::with(['user']);
            $status = $request->get('status');
            $user_id = $request->get('user_id');
            if($status){
                $builder->where('status',$status);
            }
            if($user_id){
                $builder->where('user_id',$user_id);
            }
            $projects = $builder->get();
            return response()->json($projects);
        }catch (Exception $ex){
            return response()->json($ex->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
