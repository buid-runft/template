<?php

namespace App\Services\System;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    public function log(string $action, string $table, string $recordId, array $changes = []): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'table_name' => $table,
            'record_id' => $recordId,
            'old_values' => $changes['old'] ?? null,
            'new_values' => $changes['new'] ?? null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public function logFileAccess(int $fileId): void
    {
        $this->log('file_access', 'files', $fileId);
    }
}
