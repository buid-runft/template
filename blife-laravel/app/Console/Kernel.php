<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\DatabaseBackupJob;
use App\Jobs\FileBackupJob;
use App\Jobs\StorageCleanupJob;
use App\Jobs\LogRotationJob;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // สำรองข้อมูลทุกวัน ตอน 02:00 น.
        $schedule->job(new DatabaseBackupJob)->daily()->at('02:00');

        // สำรองไฟล์ทุกอาทิตย์ วันอาทิตย์ 03:00 น.
        $schedule->job(new FileBackupJob)->weeklyOn(0, '03:00');

        // ล้างไฟล์ชั่วคราวทุกวัน 04:00 น.
        $schedule->job(new StorageCleanupJob)->daily()->at('04:00');

        // หมุนเวียนไฟล์ log ทุกวัน 05:00 น.
        $schedule->job(new LogRotationJob)->daily()->at('05:00');

        // ตรวจสอบ job ที่ล้มเหลวทุก 10 นาที
        $schedule->command('queue:failed-check')->everyTenMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
