<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 *
 * @internal
 * @coversNothing
 */
class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function invokeReturnsAnOkResponse()
    {
        factory(Event::class)->create([
            'start_time' => now()->addHour(),
            'name' => 'soon',
        ]);

        factory(Event::class)->create([
            'start_time' => now()->addWeek(),
            'name' => 'next week',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('home');
        $response->assertViewHas('thisWeek');
        $response->assertViewHas('nextWeek');

        $thisWeek = $response->viewData('thisWeek');
        $this->assertCount(1, $thisWeek);
        $this->assertEquals($thisWeek->first()['name'], 'soon');

        $nextWeek = $response->viewData('nextWeek');
        $this->assertCount(1, $nextWeek);
        $this->assertEquals($nextWeek->first()['name'], 'next week');
    }
}
