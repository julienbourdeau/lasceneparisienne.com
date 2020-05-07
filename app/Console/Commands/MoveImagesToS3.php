<?php

namespace App\Console\Commands;

use App\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MoveImagesToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:images-import';

    protected $description = 'Move local Images to s3';

    public function handle()
    {
        foreach (Event::all() as $event) {
            if (!$event->cover) {
                continue;
            }
            if (starts_with($event->cover, 'https://')) {
                $this->line('Already uploaded: '.$event->name);
                continue;
            }

            $folder = 'covers';
            $dest = $folder.$event->cover;
            $uploaded = \Storage::disk('s3')->put($dest, file_get_contents(storage_path('app/public/covers'.$event->cover)));

            if ($uploaded) {
                $meta = $event->meta;
                $meta['local_cover'] = $event->cover;
                $event->meta = $meta;
                $event->cover = \Storage::disk('s3')->url($dest);
                $event->save();

                $this->line($event->cover);
            } else {
                $this->warn("Hu-ho: {$event->cover} (id: {$event->id})");
            }
        }
    }
}
