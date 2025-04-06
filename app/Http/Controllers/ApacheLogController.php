<?php

namespace App\Http\Controllers;

use App\Models\ApacheLog;
use Illuminate\Http\Request;
use App\Services\ApacheLogService;

class ApacheLogController extends Controller
{
    public function parseLogs(Request $request)
    {
        $filePath = public_path('logs/apache.log');
        $apacheService = new ApacheLogService();
        $logs = $apacheService->parseLogFile($filePath);
        
        foreach ($logs as $log) {
            if (!ApacheLog::where('hash', $log['hash'])->exists())
                ApacheLog::create($log);
        }


        return response()->json(['message' => 'Logs processed successfully']);
    }

    public function fetchLogs(Request $request)
    {
        $query = ApacheLog::query();

        if ($request->ip) {
            $query->where('ip', 'like', '%' . $request->ip . '%');
        }
        if ($request->status_code) {
            $query->where('status_code', 'like', '%' . $request->status_code . '%');
        }

        $logs = $query->orderBy($request->get('sort_by', 'timestamp'), $request->get('sort_dir', 'asc'))
            ->paginate(15);

        return response()->json($logs);
    }
}
