<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\System\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    public function show(File $file, Request $request): Response
    {
        // ตรวจสอบสิทธิ์ผ่าน policy
        $this->authorize('view', $file);

        // บันทึก log การเข้าถึง
        $this->activityLogService->logFileAccess($file->id);

        $path = storage_path("app/{$file->path}");

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function download(File $file): Response
    {
        $this->authorize('view', $file);
        $this->activityLogService->logFileAccess($file->id);

        $path = storage_path("app/{$file->path}");

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, $file->original_name);
    }
}
