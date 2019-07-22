<?php

namespace Tests\Feature;

use App\Project;
use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */

    public function a_project_can_be_created()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);

        $response = $this->post('/projects', $data = $this->projectData());

        $response->assertOk();
        $this->assertCount(1, Project::all());
        $this->assertEquals($data['title'], Project::first()->title);
    }

    /**
     * @test
     */
    public function only_authenticated_users_can_create_a_project()
    {
        $response = $this->post('/projects', $this->projectData());

        $this->assertCount(0, Project::all());
        $response->assertRedirect('/login');
    }


    /**
     * @test
     */
    public function a_project_title_is_required()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);

        $this->post('/projects', Arr::except($this->projectData(), ['title']));

        $this->assertCount(0, Project::all());
    }
}
