<?php

namespace App;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HasCoverImageAttribute
{
    public function updateCover($force = false)
    {
        $coverPath = $this->getCoverPath();

        if (!$force) {
            if (!$this->shouldUpdateCover()) {
                return;
            }
        }

        Storage::disk('s3')->put($coverPath, file_get_contents($this->meta['cover']), 'public');

        $this->update(['cover' => Storage::disk('s3')->url($coverPath)]);
    }

    protected function shouldUpdateCover()
    {
        $path = parse_url($this->cover)['path'];

        if (!Storage::exists($path)) {
            return true;
        }

        return Storage::lastModified($path) > now()->subDays(2)->timestamp;
    }

    protected function getCoverPath()
    {
        $ext = File::extension(parse_url($this->meta['cover'])['path']);

        return "covers/{$this->start_time->year}/{$this->slug}.{$ext}";
    }
}
