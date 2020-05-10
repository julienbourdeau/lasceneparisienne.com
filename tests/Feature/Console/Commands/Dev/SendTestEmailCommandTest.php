<?php

namespace Tests\Feature\Console\Commands\Dev;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \App\Console\Commands\Dev\SendTestEmailCommand
 */
class SendTestEmailCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_runs_successfully()
    {
        $this->artisan('dev:email:test julien@sigerr.org')
            ->assertExitCode(0)
            ->run();

        // TODO: perform additional assertions to ensure the command behaved as expected
    }
}

