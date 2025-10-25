<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HealthCheckController extends Controller
{
    public function check(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'storage' => $this->checkStorage(),
            'cache' => $this->checkCache(),
            'queue' => $this->checkQueue(),
        ];

        $overallStatus = collect($checks)->every(fn($status) => $status['status'] === 'ok');

        return response()->json([
            'status' => $overallStatus ? 'healthy' : 'unhealthy',
            'timestamp' => now()->toISOString(),
            'checks' => $checks,
        ], $overallStatus ? 200 : 503);
    }

    protected function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'ok', 'message' => 'Database connection successful'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function checkStorage(): array
    {
        try {
            Storage::disk('public')->put('health-check.txt', 'ok');
            Storage::disk('public')->delete('health-check.txt');
            return ['status' => 'ok', 'message' => 'Storage accessible'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function checkCache(): array
    {
        try {
            \Cache::put('health-check', 'ok', 60);
            return ['status' => 'ok', 'message' => 'Cache working'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function checkQueue(): array
    {
        try {
            \Queue::pushRaw(json_encode(['test' => 'health']));
            return ['status' => 'ok', 'message' => 'Queue accessible'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
