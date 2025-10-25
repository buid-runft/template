<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Jobs\GenerateThumbnailJob;

class ProcessImageListener
{
    public function handle(FileUploaded $event): void
    {
        if (str_starts_with($event->file->mime_type, 'image/')) {
            GenerateThumbnailJob::dispatch($event->file->path);
        }
    }
}