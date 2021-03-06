<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventController
 *
 * @internal
 * @coversNothing
 */
class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function showReturnsAnOkResponse()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $event = factory(\App\Event::class)->create();

        $response = $this->get(route('event', ['slug' => $event->slug]));

        $response->assertOk();
        $response->assertViewIs('events.show');
        $response->assertViewHas('event');
        $response->assertViewHas('breadcrumb');
        $response->assertViewHas('schema');
        $response->assertViewHas('title');
        $response->assertViewHas('description');
        $response->assertViewHas('canonical');

        // TODO: perform additional assertions
    }

    // test cases...
}
