<?php

namespace App\Traits;

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
}
