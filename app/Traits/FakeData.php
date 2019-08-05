<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait FakeData
{
    private function roleData()
    {
        $name = $this->faker->unique()->userName;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }

    private function userData()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
        ];
    }

    private function projectData()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
        ];
    }
    private function taskData()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => Carbon::now()->addDays($this->faker->numberBetween(5,100))->toDateString(),
        ];
    }
}
