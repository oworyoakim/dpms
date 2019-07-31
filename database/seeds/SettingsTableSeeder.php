<?php

use App\Setting;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::query()->truncate();
        Setting::create(['setting_key'=>'company_name','setting_value' => 'DPMS']);
        Setting::create(['setting_key'=>'company_email','setting_value' => 'dpms@example.com']);
    }
}
