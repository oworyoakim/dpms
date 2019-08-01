<?php

namespace App\Http\Controllers;

use App\Repositories\ISettingRepository;
use App\Setting;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{
    /**
     * @var ISettingRepository
     */
    private $repository;

    /**
     * SettingsController constructor.
     * @param ISettingRepository $repository
     */
    public function __construct(ISettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try
        {
            $settings = $this->repository->all()->flatMap(function ($setting) {
                $data[$setting->setting_key] = $setting->setting_value;
                return  $data;
            })->toJson();
            //dd($settings);
            return view('settings', compact('settings'));
        } catch (Exception $ex)
        {
            //dd($ex->getMessage());
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        try
        {
            $data = Arr::except($request->all(), ['_token']);
            //dd($data);
            foreach ($data as $key => $value)
            {
                $this->repository->set($key,$value);
            }
            return response()->json('Settings saved!');
        } catch (Exception $ex)
        {
            return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
