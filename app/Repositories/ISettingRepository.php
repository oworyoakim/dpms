<?php


namespace App\Repositories;


interface ISettingRepository extends IGenericRepository
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key);

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function set($key, $value);

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all();
}
