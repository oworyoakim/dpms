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

class CreateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */

    public function a_user_can_be_created()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);

        $role = Role::create($this->roleData());
        $data = array_merge($this->userData(), ['role_id' => $role->id]);
        $response = $this->post('/users', $data);
        $response->assertOk();
        $this->assertCount(2, User::all());
        $response->assertSee('User created!');
    }

    /**
     * @test
     */
    public function only_authenticated_users_can_create_a_user()
    {
        $role = Role::create($this->roleData());
        $data = array_merge($this->userData(), ['role_id' => $role->id]);
        $response = $this->post('/users', $data);

        $this->assertCount(0, User::all());
        $response->assertRedirect('/login');
    }


    /**
     * @test
     */
    public function a_role_id_is_required()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);

        $response = $this->post('/users', array_merge($this->userData(), ['role_id' => 100]));

        $this->assertCount(1, User::all());

        $response->assertForbidden();

        $this->assertEquals('Role not found!', $response->json());
    }
}
