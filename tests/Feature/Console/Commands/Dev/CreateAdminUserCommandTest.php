<?php

namespace Tests\Feature\Console\Commands\Dev;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \App\Console\Commands\Dev\CreateAdminUserCommand
 */
class CreateAdminUserCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_runs_successfully()
    {
        $this->artisan('dev:create-admin Juju --email=yolo@gmail.com --pwd=12345678')
            ->assertExitCode(0)
            ->run();

        $u = User::first();
        $this->assertEquals('yolo@gmail.com', $u->email);
        $this->assertEquals('Juju', $u->name);
    }
}

