<?php

namespace App;

use Illuminate\Support\Facades\File;

trait HasCoverImageAttribute
{
    public function updateCover($force = false)
    {
        $cover = $this->getCoverPath();
        $finalPath = storage_path('app/public/covers'.$cover);

        if (!File::isDirectory($dir = dirname($finalPath))) {
            File::makeDirectory($dir, 0755, true);
        }

        if (!$force && !$this->shouldUpdateCover($finalPath)) {
            return;
        }

        File::put($tmpPath = storage_path($this->uuid), file_get_contents($this->meta['cover']));
        File::move($tmpPath, $finalPath);

        $this->update(['cover' => $cover]);
    }

    protected function shouldUpdateCover($file)
    {
        if (! File::exists($file)) {
            return true;
        }

        if (File::lastModified($file) > now()->subDays(2)->timestamp) {
            return false;
        }

        if ($this->start_time->timestamp < now()->addDays(30)->timestamp) {
            return true;
        }

        return false;
    }

    protected function getCoverPath()
    {
        $ext = File::extension(parse_url($this->meta['cover'])['path']);
        return "/{$this->start_time->year}/{$this->slug}.$ext";
    }
}
