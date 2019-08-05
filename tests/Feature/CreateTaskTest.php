<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */
    public function only_authenticated_users_can_create_a_task()
    {
        $user = Sentinel::registerAndActivate($this->userData());
        Sentinel::authenticate($user);

        $this->post('/projects', $this->projectData());
        Sentinel::logout($user);

        $project = Project::first();
        $data = array_merge($this->taskData(), ['project_id' => $project->id]);
        $response = $this->post("/projects/tasks", $data);
        $this->assertCount(0, Task::all());
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function authenticated_users_can_create_a_task()
    {
        $user = Sentinel::registerAndActivate($this->userData());
        Sentinel::authenticate($user);

        $this->post('/projects', $this->projectData());

        $project = Project::first();
        $data = array_merge($this->taskData(), ['project_id' => $project->id]);
        $response = $this->post("/projects/tasks", $data);
        $response->assertOk();
        $this->assertCount(1, Task::all());
        $response->assertSee('Task created!');
    }

    /**
     * @test
     */
    public function a_valid_project_id_is_required_to_create_a_task()
    {
        $this->withoutExceptionHandling();
        $user = Sentinel::registerAndActivate($this->userData());
        Sentinel::authenticate($user);
        $data = array_merge($this->taskData(), ['project_id' => random_int(1,10)]);
        $response = $this->post("/projects/tasks", $data);
        $response->assertNotFound();
        $this->assertCount(0, Task::all());
        $response->assertSee('Project not found!');
    }
}
