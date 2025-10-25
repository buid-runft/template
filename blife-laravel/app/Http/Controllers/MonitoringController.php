<?php

namespace App\Http\Controllers;

use App\Services\System\QueueMonitoringService;
use Illuminate\Http\JsonResponse;

class MonitoringController extends Controller
{
    public function __construct(
        protected QueueMonitoringService $queueService
    ) {}

    public function dashboard(): JsonResponse
    {
        $stats = [
            'queue_stats' => $this->queueService->getQueueStats(),
            'system_load' => $this->getSystemLoad(),
            'database_connections' => $this->getDbConnections(),
            'memory_usage' => $this->getMemoryUsage(),
        ];

        return response()->json($stats);
    }

    protected function getSystemLoad(): array
    {
        $load = sys_getloadavg();
        return [
            'load_1min' => $load[0],
            'load_5min' => $load[1],
            'load_15min' => $load[2],
        ];
    }

    protected function getDbConnections(): int
    {
        return \DB::connection()->getPdo()->query('SHOW STATUS LIKE "Threads_connected"')->fetchColumn();
    }

    protected function getMemoryUsage(): array
    {
        return [
            'used' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB',
        ];
    }
}
