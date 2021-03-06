<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ArchiveController
 *
 * @internal
 * @coversNothing
 */
class ArchiveControllerTest extends TestCase
{
    /**
     * @test
     */
    public function indexReturnsAnOkResponse()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->get(route('archives'));

        $response->assertOk();
        $response->assertViewIs('events.archive');
        $response->assertViewHas('count');
        $response->assertViewHas('years');
        $response->assertViewHas('current');
        $response->assertViewHas('events');
        $response->assertViewHas('period');
        $response->assertViewHas('start');

        // TODO: perform additional assertions
    }

    // test cases...
}
