<?php

namespace Tests\Feature;

use App\Project;
use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker,FakeData;

    /**
     * @test
     */
    public function a_project_can_be_updated()
    {
        $user = Sentinel::registerAndActivate($this->userData());
        Sentinel::authenticate($user);
        $this->post('/projects', $this->projectData());

        $project = Project::first();
        $response = $this->put('/projects/' . $project->id, array_merge($this->projectData(), ['title' => 'New Project Title']));

        $response->assertOk();
        $this->assertEquals('New Project Title', $project->refresh()->title);
    }


    /**
     * @test
     */
    public function a_user_can_update_their_projects_only()
    {
        $user1 = Sentinel::registerAndActivate($this->userData());
        Sentinel::authenticate($user1);

        $this->post('/projects', $this->projectData());
        Sentinel::logout($user1);

        $user2 = Sentinel::registerAndActivate($this->userData());
        Sentinel::authenticate($user2);

        $this->post('/projects', $this->projectData());
        $project = Project::first();
        $response = $this->put('/projects/' . $project->id, array_merge($this->projectData(), ['title' => 'New Project Title']));

        $response->assertForbidden();
        $this->assertNotEquals('New Project Title', $project->refresh()->title);
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
