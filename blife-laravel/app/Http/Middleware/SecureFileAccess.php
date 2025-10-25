<?php

namespace App\Http\Middleware;

use App\Models\File;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecureFileAccess
{
    public function handle(Request $request, Closure $next)
    {
        $fileId = $request->route('file');

        if ($fileId && is_numeric($fileId)) {
            $file = File::find($fileId);

            if ($file && !$file->is_public) {
                $user = Auth::user();

                if (!$user || !Auth::user()->can('view', $file)) {
                    abort(403, 'คุณไม่มีสิทธิ์เข้าถึงไฟล์นี้');
                }
            }
        }

        return $next($request);
    }
}
