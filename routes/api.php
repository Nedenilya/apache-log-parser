<?php

use App\Http\Controllers\ApacheLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("/parse-logs", [ApacheLogController::class, "parseLogs"]);
Route::get("/logs", [ApacheLogController::class, "fetchLogs"]);
