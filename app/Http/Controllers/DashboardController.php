<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BreakRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BreakResource;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Get active break
        $activeBreak = BreakRecord::where('user_id', $user->id)
            ->whereDate('start_time', $today)
            ->whereNull('end_time')
            ->first();

        $totalBreakTimeUsed = BreakRecord::getTodaysTotalBreakTime($user->id);

        // Get remaining break time
        $remainingBreakTime = BreakRecord::getRemainingBreakTime($user->id);

        // Get break statistics for today only
        $breakStats = $this->getTodayBreakStats($user->id);

        $employeesList = Employee::all();
        $teamList = Team::all();

        return Inertia::render('Dashboard', [
            'breakInfo' => [
                'activeBreak' => $activeBreak ? new BreakResource($activeBreak) : null,
                'totalBreakTimeUsed' => round($totalBreakTimeUsed, 1),
                'remainingBreakTime' => round($remainingBreakTime, 1),
                'canTakeBreak' => $remainingBreakTime > 0 && !$activeBreak,
                'isBreakTimeExhausted' => $remainingBreakTime <= 0,
                'breakStats' => $breakStats,
            ],
            'employeeList'=>$employeesList,
            'teamList'=>$teamList
        ]);
    }

    /**
     * Get break statistics for today
     */
    protected function getTodayBreakStats(int $userId): array
    {
        $today = Carbon::today();

        $breaks = BreakRecord::where('user_id', $userId)
            ->whereDate('start_time', $today)
            ->get();

        $totalDuration = $breaks->sum(function ($break) {
            return $break->duration;
        });

        return [
            'total_breaks' => $breaks->count(),
            'total_duration' => number_format($totalDuration, 1),
            'average_duration' => $breaks->count() ?
                number_format($totalDuration / $breaks->count(), 1) : '0.0',
            'remaining_time' => number_format(BreakRecord::getRemainingBreakTime($userId), 1),
            'completed_breaks' => $breaks->whereNotNull('end_time')->count(),
            'incomplete_breaks' => $breaks->whereNull('end_time')->count(),
        ];
    }
}
