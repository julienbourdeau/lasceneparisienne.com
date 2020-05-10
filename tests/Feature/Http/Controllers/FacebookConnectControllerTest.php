<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FacebookConnectController
 *
 * @internal
 * @coversNothing
 */
class FacebookConnectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userIsLoggedInAndAdmin()
    {
        $this->seed(\AdminUserSeeder::class);

        $response = $this->actingAs(User::first())->get(route('fb.login'));

        $response->assertOk();
        $response->assertViewIs('facebook_connect.login');
        $response->assertViewHas('loginUrl');
    }

    /**
     * @test
     */
    public function userIsNotAdmin()
    {
        $response = $this->get(route('fb.login'));
        $response->assertNotFound();

        factory(User::class)->create();

        $response = $this->actingAs(User::first())->get(route('fb.login'));
        $response->assertNotFound();
    }
}
