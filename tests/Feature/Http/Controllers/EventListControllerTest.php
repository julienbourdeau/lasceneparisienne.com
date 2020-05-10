<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventListController
 *
 * @internal
 * @coversNothing
 */
class EventListControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index()
    {
        $this->markTestSkipped("Doesnt work with SQLite");
        factory(Event::class, 3)->create([
            'start_time' => now()->addDay()
        ]);

        $response = $this->get(route('events'));

        dump($response->json());
        $response->assertOk();
        $response->assertViewIs('events.index');
        $response->assertViewHas('eventsPerMonth');
        $response->assertViewHas('events');
        $response->assertViewHas('monthlyLinks');
        $response->assertViewHas('canonical');
        $response->assertViewHas('display');
    }
}
