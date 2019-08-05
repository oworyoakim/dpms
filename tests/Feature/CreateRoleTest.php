<?php

namespace Tests\Feature;

use App\Project;
use App\Role;
use App\Traits\FakeData;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */
    public function only_authenticated_users_can_create_a_role()
    {
        $data = $this->roleData();
        $response = $this->post('/roles', $data);

        $this->assertCount(0, Role::all());
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */

    public function authenticated_users_can_create_a_role()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);
        $response = $this->post('/roles', $data = $this->roleData());
        $response->assertOk();
        $this->assertCount(1, Role::all());
    }




    /**
     * @test
     */
    public function a_role_name_is_required()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);

        $response = $this->post('/roles', Arr::except($this->roleData(),['name']));

        $this->assertCount(0, Role::all());
    }
}
