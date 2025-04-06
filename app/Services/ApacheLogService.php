<?php

namespace App\Services;

use BenMorel\ApacheLogParser\Parser;

class ApacheLogService
{
    public function parseLogFile(string $filePath): array
    {
        $logs = [];
        $lines = file($filePath);
        
        $pattern = '/^(.*?):\s(\S+)\s\[(.*?)\s(\+\d+)]\s"(GET|POST|PUT|DELETE)\s(\S+)\s(HTTP\/\d\.\d)"\s(\d+)\s(\S+)\s"(.*?)"\s"(.*?)"$/';

        foreach ($lines as $line) {
            if (!preg_match($pattern, trim($line), $matches)) 
                continue;

            $logHash = md5($matches[2] . $matches[3] . $matches[6]);
            
            $logs[] = [
                'hostname' => $matches[1],
                'ip' => $matches[2],
                'timestamp' => $matches[3],
                'timezone' => $matches[4],
                'request_method' => $matches[5],
                'url' => $matches[6],
                'protocol' => $matches[7],
                'status_code' => $matches[8],
                'response_size' => $matches[9],
                'referrer' => $matches[10],
                'user_agent' => $matches[11],
                'hash' => $logHash
            ];
        }

        return $logs;
    }
}
