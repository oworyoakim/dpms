<?php
/**
 * Created by PhpStorm.
 * User: Yoakim
 * Date: 8/01/2019
 * Time: 12:34 PM
 */

use App\Repositories\SettingRepository;
use App\Setting;

if(!function_exists('settings')){
    function settings() {
        return new SettingRepository(new Setting);
    }
}
