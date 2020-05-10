<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VenueListController
 *
 * @internal
 * @coversNothing
 */
class VenueListControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function indexReturnsAnOkResponse()
    {
        $this->seed();

        $response = $this->get(route('venues'));

        $response->assertOk();
        $response->assertViewIs('venues.index');
        $response->assertViewHas('venuesAlpha');
        $response->assertViewHas('top');

        // TODO: perform additional assertions
    }

    // test cases...
}
