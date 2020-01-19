<?php

namespace App\Console\Commands;

use App\Event;
use App\Mail\NextWeekProgramme;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmailCommand extends Command
{
    protected $signature = 'dev:email:test {addresses*}';

   protected $description = 'Send test email to given addresses';

    public function handle()
    {
        $events =  Event::where([
            ['start_time', '>=', Carbon::yesterday()],
            ['start_time', '<=', $monday = now()->next(Carbon::MONDAY)],
            ['canceled', '!=', true]
        ])->get();

        Mail::to($this->argument('addresses'))->send(new NextWeekProgramme($events));
    }
}
