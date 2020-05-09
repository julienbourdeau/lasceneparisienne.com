<?php

namespace App\Console\Commands\Dev;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserCommand extends Command
{
    protected $signature = 'dev:create-admin {name} {--email=} {--pwd=} {--truncate}';

    public function handle()
    {
        throw_unless($this->option('email') && $this->option('pwd'), new \ArgumentCountError('Both `email` and `pwd` are required.'));

        if ($this->option('truncate')) {
            $this->line('Deleting all existing users...');
            DB::table('users')->truncate();
        }

        $user = User::forceCreate([
            'name' => $this->argument('name'),
            'email' => $this->option('email'),
            'password' => Hash::make($this->option('pwd')),
            'email_verified_at' => now(),
        ]);

        $this->info("Created new {$user->name} <{$user->email}> user [ID:{$user->id}]");
    }
}
