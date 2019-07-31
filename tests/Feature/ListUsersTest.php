<?php

namespace Tests\Feature;

use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */
    public function only_authenticated_users_can_see_users_list()
    {
        $response = $this->get('/users');
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function authenticated_users_can_see_users_list()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);
        $response = $this->get('/users');

        $response->assertOk();
    }
}
