<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogActivityMiddleware
{
    public function handle($request, Closure $next)
    {
        // Tambahkan logging di sini untuk memastikan middleware dijalankan
        Log::channel('activitylog')->info("Middleware diakses.");

        if (Auth::check()) {
            // Debugging: Log informasi ini untuk memastikan middleware dijalankan
            Log::info("Middleware dijalankan. User: " . Auth::user()->id);

            $routeName = $request->route()->getName();

            // Periksa apakah rute memiliki nama
            if (!is_null($routeName)) {
                $activity = $request->method();
                $module = $routeName; // Gunakan nama rute

                // Debugging: Log informasi ini untuk memastikan middleware dijalankan
                Log::info("Logging activity: $activity pada module: $module oleh user: " . Auth::user()->id);

                ActivityLog::logLoginLogout($activity, $module);
            } else {
                // Opsional: Tangani kasus ketika rute tidak memiliki nama
                Log::warning("Middleware diakses tanpa nama rute.");
            }
        } else {
            // Tambahkan logging untuk kasus ketika pengguna tidak diautentikasi
            Log::info("Pengguna tidak diautentikasi.");
        }

        return $next($request);
    }
}