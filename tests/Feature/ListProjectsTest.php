<?php

namespace Tests\Feature;

use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */
    public function only_authenticated_users_can_see_projects_list()
    {
        $response = $this->get('/projects');
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function authenticated_users_can_see_projects_list()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);
        $response = $this->get('/projects');

        $response->assertOk();
    }
}
