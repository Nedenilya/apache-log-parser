<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApacheLog extends Model
{
    use HasFactory;

    protected $table = "logs";

    protected $fillable = [
        "hostname", "ip", "timestamp", "timezone", "request_method", "url", "protocol", 
        "status_code", "response_size", "referrer", "user_agent", "hash"
    ];
}