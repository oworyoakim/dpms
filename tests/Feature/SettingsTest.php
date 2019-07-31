<?php

namespace Tests\Feature;

use App\Setting;
use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsTest extends TestCase
{
    use RefreshDatabase, WithFaker, FakeData;

    /**
     * @test
     */
    public function only_authenticated_users_can_see_settings()
    {
        $response = $this->get('/settings');
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function authenticated_users_can_see_settings()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);
        $response = $this->get('/settings');

        $response->assertOk();
    }

    /**
     * @test
     */
    public function only_authenticated_users_can_create_or_update_settings()
    {
        $data = [
            'company_name' => $this->faker->company,
            'company_email' => $this->faker->unique()->companyEmail,
        ];
        $response = $this->post('/settings', $data);
        $this->assertCount(0, Setting::all());
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function authenticated_users_can_create_or_update_settings()
    {
        $user = Sentinel::registerAndActivate($this->userData());

        Sentinel::authenticate($user);
        $data = [
            'company_name' => $this->faker->company,
            'company_email' => $this->faker->unique()->companyEmail,
        ];
        $response = $this->post('/settings', $data);
        $response->assertOk();
        $this->assertCount(2, Setting::all());
    }
}
