<?php

namespace Tests\Feature\Http\Controllers;

use App\ApiDefinition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ApiController
 *
 * @internal
 * @coversNothing
 */
class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function invokeReturnsAnOkResponse()
    {
        $response = $this->get(route('page.api'));

        $response->assertOk();
        $response->assertViewIs('api');
        $response->assertViewHas('endpoints');
        $response->assertViewHas('xData');

        $this->assertEquals(ApiDefinition::get(), $response->viewData('endpoints'));
    }
}
