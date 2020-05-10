<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FacebookConnectController
 *
 * @internal
 * @coversNothing
 */
class FacebookConnectControllerTest extends TestCase
{
    /**
     * @test
     */
    public function callbackReturnsAnOkResponse()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->get(route('fb.callback'));

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function loginReturnsAnOkResponse()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->get(route('fb.login'));

        $response->assertOk();
        $response->assertViewIs('facebook_connect.login');
        $response->assertViewHas('loginUrl');

        // TODO: perform additional assertions
    }

    // test cases...
}
