<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VenueController
 *
 * @internal
 * @coversNothing
 */
class VenueControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function showReturnsAnOkResponse()
    {
        $venue = factory(\App\Venue::class)->create();
        factory(Event::class, 5)->create([
            'venue_id' => $venue->id
        ]);

        $response = $this->get(route('venue', ['slug' => $venue->slug]));

        $response->assertOk();
        $response->assertViewIs('venues.show');
        $response->assertViewHas('venue');
        $response->assertViewHas('upcomingEvents');
        $response->assertViewHas('pastEvents');

        $this->assertEquals($venue->id, $response->viewData('venue')->id);

        $eventCount = $response->viewData('upcomingEvents')->count() + $response->viewData('pastEvents')->count();
        $this->assertEquals(5, $eventCount);
    }
}
