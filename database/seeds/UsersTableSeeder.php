<?php

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($adminRole = Sentinel::getRoleRepository()->findBySlug('admin'))
        {
            $user = User::query()->create([
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'first_name' => 'Test',
                'last_name' => 'Admin',
            ]);
            $adminRole->users()->attach($user);
            // activate user
            $activation = Activation::create($user);
            Activation::complete($user, $activation->code);
        }
    }
}
