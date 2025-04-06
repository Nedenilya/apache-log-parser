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

        $filters = [
            'hostname' => $request->hostname,
            'ip' => $request->ip,
            'status_code' => $request->status_code,
            'request_method' => $request->request_method,
        ];
        
        foreach ($filters as $field => $value) {
            if ($value) {
                $query->where($field, 'like', '%' . $value . '%');
            }
        }

        $logs = $query->orderBy($request->get('sort_by', 'timestamp'), $request->get('sort_dir', 'asc'))
            ->paginate(15);

        return response()->json($logs);
    }
}
