<?php

namespace App\Http\Controllers;

use App\Models\BreakRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class BreakController extends Controller
{
    private const BREAK_DURATION = 60; // in minutes
    private const CACHE_TTL = 300; // in seconds (5 minutes)

    /**
     * Start a new break for the authenticated user.
     */
    public function startBreak()
    {
        try {
            // Ensure no active break exists
            if ($this->getActiveBreak()) {
                throw ValidationException::withMessages([
                    'break' => ['You already have an active break.']
                ]);
            }

            // Check if break time limit is reached
            $totalUsed = $this->calculateTotalBreakTime();
            if ($totalUsed >= self::BREAK_DURATION) {
                throw ValidationException::withMessages([
                    'break' => ['Daily break time limit reached.']
                ]);
            }

            // Start the break
            $break = BreakRecord::create([
                'user_id' => Auth::id(),
                'start_time' => Carbon::now(),
            ]);

            $this->clearBreakCache();

            return response()->json([
                'success' => true,
                'id' => $break->id,
                'start_time' => $break->start_time,
                'total_break_time_used' => $totalUsed,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['break'][0],
            ], 422);
        }
    }

    /**
     * End the active break for the authenticated user.
     */
    public function endBreak(Request $request)
    {
        try {
            $break = BreakRecord::findOrFail($request->break_id);

            if ($break->user_id !== Auth::id()) {
                throw ValidationException::withMessages([
                    'break' => ['Unauthorized access to break record.']
                ]);
            }

            if ($break->end_time) {
                throw ValidationException::withMessages([
                    'break' => ['Break already ended.']
                ]);
            }

            // End the break
            $break->end_time = Carbon::now();
            $break->save();

            $this->clearBreakCache();

            $totalUsed = $this->calculateTotalBreakTime();
            $timeLeft = max(0, self::BREAK_DURATION - $totalUsed);

            return response()->json([
                'success' => true,
                'duration' => $break->start_time->diffInMinutes($break->end_time),
                'time_left' => $timeLeft,
                'total_break_time_used' => $totalUsed,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['break'][0],
            ], 422);
        }
    }

    /**
     * Get the active break for the authenticated user.
     */
    protected function getActiveBreak()
    {
        $cacheKey = $this->cacheKey('active_break');
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return BreakRecord::where('user_id', Auth::id())
                ->whereNull('end_time')
                ->first();
        });
    }

    /**
     * Calculate the total break time used today.
     */
    protected function calculateTotalBreakTime()
    {
        $cacheKey = $this->cacheKey('total_break_time', Carbon::today()->format('Y-m-d'));

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            $breaks = BreakRecord::where('user_id', Auth::id())
                ->whereDate('start_time', Carbon::today())
                ->get();

            return $breaks->sum(function ($break) {
                $endTime = $break->end_time ?? Carbon::now();
                return abs($endTime->diffInMinutes($break->start_time));
            });
        });
    }

    /**
     * Clear all break-related cache for the authenticated user.
     */
    protected function clearBreakCache()
    {
        $userId = Auth::id();
        Cache::forget($this->cacheKey('break_info'));
        Cache::forget($this->cacheKey('active_break'));
        Cache::forget($this->cacheKey('total_break_time', Carbon::today()->format('Y-m-d')));
    }

    /**
     * Generate a cache key for the user.
     */
    protected function cacheKey(string $type, string $suffix = ''): string
    {
        $userId = Auth::id();
        return "{$type}_{$userId}" . ($suffix ? "_{$suffix}" : '');
    }

    /**
     * Get all breaks between specified dates.
     */
    public function getBreaks(Request $request)
    {
        $startDate = Carbon::parse($request->get('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse($request->get('end_date', Carbon::now()));

        $breaks = BreakRecord::whereBetween('start_time', [$startDate, $endDate])
            ->with('user')
            ->get();

        return response()->json($breaks);
    }

    /**
     * Export breaks between specified dates as a CSV file.
     */
    public function exportBreaks(Request $request)
    {
        $startDate = Carbon::parse($request->get('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse($request->get('end_date', Carbon::now()));

        $breaks = BreakRecord::whereBetween('start_time', [$startDate, $endDate])
            ->with('user')
            ->get();

        $csvFileName = 'breaks_report_' . $startDate->toDateString() . '_to_' . $endDate->toDateString() . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$csvFileName}",
        ];

        $callback = function () use ($breaks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Employee Name', 'Start Time', 'End Time', 'Total Break Time']);

            foreach ($breaks as $break) {
                fputcsv($handle, [
                    $break->user->name ?? 'Unknown', // Fallback for missing user
                    $break->start_time,
                    $break->end_time ?? 'Ongoing',
                    $break->end_time
                        ? $break->start_time->diffInMinutes($break->end_time) . ' mins'
                        : 'N/A',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
