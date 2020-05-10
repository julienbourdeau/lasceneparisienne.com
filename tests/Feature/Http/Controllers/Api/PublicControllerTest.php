<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Event;
use App\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\PublicController
 *
 * @internal
 * @coversNothing
 */
class PublicControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function event()
    {
        $uuid = factory(Event::class)->create()->refresh()->uuid;

        $response = $this->getJson(route('api.event', ['uuid' => $uuid]));

        $response->assertOk();
        $response->assertJson(Event::where('uuid', $uuid)->first()->toArray());
        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    /**
     * @test
     */
    public function eventWasDeleted()
    {
        $event = factory(Event::class)->create(['deleted_at' => now()->subDay()])->refresh();

        $response = $this->getJson(route('api.event', ['uuid' => $event->uuid]));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function events()
    {
        $this->seed();

        $response = $this->getJson(route('api.events'));

        $response->assertOk();
        $response->assertJsonStructure([
            "current_page",
            "data",
            "first_page_url",
            "from",
            "last_page",
            "last_page_url",
            "next_page_url",
            "path",
            "per_page",
            "prev_page_url",
            "to",
            "total",
        ]);

        $this->assertEquals(12, $response->json('total'));

        $first = $response->json('data')[0];
        $expected = Event::where(['uuid' => $first['uuid']])->first()->toArray();
        $this->assertEquals($expected, $first);

        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    /**
     * @test
     */
    public function venue()
    {
        $uuid = factory(Venue::class)->create()->refresh()->uuid;

        $response = $this->getJson(route('api.venue', ['uuid' => $uuid]));

        $response->assertOk();

        $expected = Venue::where('uuid', $uuid)
            ->withCount(['upcomingEvents', 'events'])
            ->with(['nextEvents'])
            ->first()
            ->toArray();

        $this->assertEquals($expected, $response->json());

        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    /**
     * @test
     */
    public function venuesReturnsAnOkResponse()
    {
        $this->seed();

        $response = $this->getJson(route('api.venues'));

        $response->assertOk();
        $response->assertJsonStructure([
            "current_page",
            "data",
            "first_page_url",
            "from",
            "last_page",
            "last_page_url",
            "next_page_url",
            "path",
            "per_page",
            "prev_page_url",
            "to",
            "total",
        ]);

        $this->assertEquals(12, $response->json('total'));

        $first = $response->json('data')[0];
        $expected = Venue::whereUuid($first['uuid'])
            ->withCount(['upcomingEvents'])
            ->first()
            ->toArray();
        $this->assertEquals($expected, $first);

        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }
}
