<?php

namespace Tests\Feature;

use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListRolesTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */
    public function only_authenticated_users_can_see_roles_list()
    {
        $response = $this->get('/roles');
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function authenticated_users_can_see_roles_list()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);

        $response = $this->get('/roles');
        $response->assertOk();
    }
}
