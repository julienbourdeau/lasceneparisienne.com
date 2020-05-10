<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IcalController
 *
 * @internal
 * @coversNothing
 */
class IcalControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function feed()
    {
        factory(Event::class, 3)->create();

        $events = Event::all();

        $response = $this->get(route('ics'));

        $response->assertOk();

        $this->assertIsIcalResponse($response);

        $events->map->uuid->each(fn ($uuid) => $this->assertStringContainsString($uuid, $response->content()));
    }

    /**
     * @test
     */
    public function event()
    {
        $e = factory(Event::class)->create();

        $response = $this->get(route('event.ics', ['uuid' => $e->uuid]));

        $response->assertOk();

        $this->assertIsIcalResponse($response);

        $this->assertEquals('attachment; filename="'.$e->slug.'.ics"', $response->headers->get('content-disposition'));
    }

    private function assertIsIcalResponse(TestResponse $response)
    {
        $this->assertEquals("text/calendar; charset=utf-8", $response->headers->get('content-type'));

        $this->assertStringStartsWith("BEGIN:VCALENDAR\r\nVERSION:2.0\r\n", $response->content());
        $this->assertStringEndsWith("END:VEVENT\r\nEND:VCALENDAR", $response->content());
    }
}
