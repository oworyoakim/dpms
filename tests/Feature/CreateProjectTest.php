<?php

namespace Tests\Feature;

use App\Project;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */

    public function a_project_can_be_created()
    {
        $user = Sentinel::registerAndActivate([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'test123',
        ]);

        Sentinel::authenticate($user);

        $response = $this->post('/projects', $this->data());

        $response->assertOk();
        $this->assertCount(1, Project::all());
        $this->assertEquals($this->data()['title'], Project::first()->title);
    }

    /**
     * @test
     */
    public function only_authenticated_users_can_create_a_project()
    {
        $response = $this->post('/projects', $this->data());

        $this->assertCount(0, Project::all());
        $response->assertRedirect('/login');
    }


    /**
     * @test
     */
    public function a_project_title_is_required()
    {
        $user = Sentinel::registerAndActivate([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'test123',
        ]);

        Sentinel::authenticate($user);

        $this->post('/projects', Arr::except($this->data(), ['title']));

        $this->assertCount(0, Project::all());
    }

    private function data()
    {
        /*
        return [
            'name' => 'Project Title',
            'image' => '',
            'user_id' => '',
            'description' => 'Some description',
            'status' => 'pending',
            'complete' => 0,
        ];
        */
        return [
            'title' => 'Project Title',
            'description' => 'Some description text',
            'image' => '',
        ];
    }
}
