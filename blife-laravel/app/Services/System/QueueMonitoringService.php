<?php

namespace App\Services\System;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class QueueMonitoringService
{
    public function getQueueStats(): array
    {
        $jobs = DB::table('jobs')->selectRaw('queue, count(*) as pending')->groupBy('queue')->get();
        $failedJobs = DB::table('failed_jobs')->count();
        $recentFailed = DB::table('failed_jobs')->orderBy('failed_at', 'desc')->limit(5)->get();

        return [
            'pending_jobs' => $jobs->pluck('pending', 'queue')->toArray(),
            'total_failed' => $failedJobs,
            'recent_failed' => $recentFailed,
            'workers' => $this->getWorkerStats(),
        ];
    }

    protected function getWorkerStats(): array
    {
        // ตรวจสอบผ่าน Horizon ถ้าใช้ หรือใช้ process ตรวจสอบ
        $processes = shell_exec('ps aux | grep "queue:work" | grep -v grep | wc -l');
        return [
            'active_workers' => intval($processes),
            'last_heartbeat' => now(),
        ];
    }
}
