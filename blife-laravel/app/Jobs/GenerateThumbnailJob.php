<?php

namespace App\Jobs;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GenerateThumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $filePath,
        protected string $disk = 'public'
    ) {}

    public function handle(): void
    {
        if (!Storage::disk($this->disk)->exists($this->filePath)) {
            return; // ไฟล์ไม่มีแล้ว
        }

        $image = Image::make(Storage::disk($this->disk)->path($this->filePath));
        $thumbPath = str_replace('/products/', '/products/thumbnails/', $this->filePath);
        $thumbPath = str_replace('/stores/', '/stores/thumbnails/', $thumbPath);

        $image->fit(300, 300)->save(Storage::disk($this->disk)->path($thumbPath));

        // บันทึก thumbnail path ไว้ใน database ถ้าต้องการ
        // ใช้ File model ได้ถ้าต้องการ
    }
}
