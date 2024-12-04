<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

class BreakRecord extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'breaks';

    /** @var int */
    public const MAX_BREAK_DURATION = 60;

    /** @var array */
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
    ];

    /** @var array */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /** @var array */
    protected $appends = [
        'duration',
        'is_active',
        'time_left',
        'formatted_duration'
    ];

    /**
     * Get the user that owns the break record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'user'); // Assuming Employee model
    }

protected function calculateExactDuration(): float
{
    // If start_time is null, return 0 duration
    if (is_null($this->start_time)) {
        return 0;
    }

    // If end_time is null, use current time
    $endTime = $this->end_time ?? Carbon::now();

    // If start_time is still null or not a valid date, return 0
    if (!($this->start_time instanceof Carbon)) {
        return 0;
    }

    // Calculate duration in seconds and convert to minutes
    $diffInSeconds = $this->start_time->diffInSeconds($endTime);
    return round($diffInSeconds / 60, 1); // Convert to minutes
}
    /**
     * Get formatted duration attribute
     */
    public function getFormattedDurationAttribute(): string
    {
        return number_format($this->calculateExactDuration(), 1);
    }

    /**
     * Get the duration of the break in minutes
     */
    public function getDurationAttribute(): float
    {
        return $this->calculateExactDuration();
    }

    /**
     * Calculate time left in minutes with decimals
     */
    protected function calculateTimeLeft(): float
    {
        return max(0, self::MAX_BREAK_DURATION - $this->duration);
    }

    /**
     * Get the time left in the break
     */
    public function getTimeLeftAttribute(): float
    {
        return round($this->calculateTimeLeft(), 1);
    }

    /**
     * Check if the break is currently active
     */
    public function getIsActiveAttribute(): bool
    {
        return is_null($this->end_time);
    }

    /**
     * Calculate total break time for today with decimals
     */
    public static function getTodaysTotalBreakTime(int $userId): float
    {
        $breaks = self::where('user_id', $userId)
            ->whereDate('start_time', Carbon::today())
            ->get();

        $totalMinutes = $breaks->sum(function ($break) {
            return $break->duration;
        });

        return round($totalMinutes, 1);
    }

    /**
     * Get remaining break time for today
     */
    public static function getRemainingBreakTime(int $userId): float
    {
        $totalUsed = self::getTodaysTotalBreakTime($userId);
        return round(max(0, self::MAX_BREAK_DURATION - $totalUsed), 1);
    }

    /**
     * Get break information array with exact values
     */
    public function getBreakInfo(): array
    {
        return [
            'id' => $this->id,
            'is_active' => $this->is_active,
            'duration' => $this->formatted_duration,
            'time_left' => number_format($this->time_left, 1),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Calculate total break time for a collection of breaks with decimals
     */
    public static function calculateTotalBreakTime($breaks): float
    {
        return round($breaks->sum(function ($break) {
            return $break->duration;
        }), 1);
    }

    /**
     * Boot the model with additional validation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($break) {
            if (empty($break->start_time)) {
                $break->start_time = Carbon::now(); // Set start time to current time if not provided
            }

            // Check if user has remaining break time
            $remainingTime = self::getRemainingBreakTime($break->user_id);
            if ($remainingTime <= 0) {
                throw new \InvalidArgumentException('No break time remaining for today');
            }
        });

        static::saving(function ($break) {
            if ($break->end_time && $break->start_time->isAfter($break->end_time)) {
                throw new \InvalidArgumentException('End time cannot be before start time');
            }
        });
    }

    /**
     * Check if the break has exceeded the maximum duration with decimal precision
     */
    public function hasExceededMaxDuration(): bool
    {
        return $this->duration >= self::MAX_BREAK_DURATION;
    }

    /**
     * Get user's break statistics with decimal precision
     */
    public static function getBreakStats(int $userId, ?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = self::where('user_id', $userId);

        if ($startDate && $endDate) {
            $query->whereDate('start_time', '>=', $startDate)
                ->whereDate('start_time', '<=', $endDate);
        }

        $breaks = $query->get();
        $totalDuration = self::calculateTotalBreakTime($breaks);
        $breakCount = $breaks->count();

        return [
            'total_breaks' => $breakCount,
            'total_duration' => number_format($totalDuration, 1),
            'average_duration' => $breakCount ?
                number_format($totalDuration / $breakCount, 1) : '0.0',
            'remaining_time' => number_format(self::getRemainingBreakTime($userId), 1),
            'completed_breaks' => $breaks->whereNotNull('end_time')->count(),
            'incomplete_breaks' => $breaks->whereNull('end_time')->count(),
        ];
    }

    /**
     * Fetch break records for users in a specified date range
     */
    public static function fetchBreakRecords(Request $request)
    {
        $startDate = Carbon::parse($request->query('start_date', Carbon::now()->startOfMonth()->toDateString()));
        $endDate = Carbon::parse($request->query('end_date', Carbon::now()->toDateString()));

        $breakRecords = Employee::with(['breaks' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_time', [$startDate, $endDate])
                ->orderBy('start_time');
        }])
            ->get()
            ->map(function ($employee) {
                return [
                    'employee_name' => $employee->name,
                    'break_details' => $employee->breaks->map(function ($break) {
                        return [
                            'start_time' => $break->start_time->format('Y-m-d H:i:s'),
                            'end_time' => $break->end_time ? $break->end_time->format('Y-m-d H:i:s') : 'Active',
                            'duration' => $break->duration . ' mins',
                        ];
                    }),
                    'total_break_time' => $employee->breaks->sum('duration') . ' mins',
                ];
            });

        return response()->json($breakRecords);
    }
}

