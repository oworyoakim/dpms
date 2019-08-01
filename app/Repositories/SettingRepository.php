<?php


namespace App\Repositories;


use App\Setting;

class SettingRepository extends GenericRepository implements ISettingRepository
{
    /**
     * SettingRepository constructor.
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }


    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        if ($setting = $this->model->newQuery()->where('setting_key',$key)->first()) {
            return $setting->setting_value;
        }
        return null;
    }


    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function set($key, $value)
    {
        $setting = $this->model->newQuery()->firstOrNew([
            'setting_key' => $key
        ]);
        $setting->setting_value = $value;
        return $setting->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->newQuery()->get();
    }
}
