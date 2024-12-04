<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'father_name',
        'mother_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'blood_group',
        'disability',
        'city',
        'country',
        'email',
        'phone',
        'mobile',
        'alternate_number',
        'address',
        'department_id',
        'designation',
        'reporting_manager',
        'shift_start_time',
        'shift_end_time',
        'profile_status',
    ];

    /**
     * Boot method for model event hooks.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate unique employee ID before creating
        static::creating(function ($employee) {
            $employee->employee_id = static::generateEmployeeId();
        });
    }

    /**
     * Generate a unique employee ID.
     */
    protected static function generateEmployeeId(): string
    {
        return DB::transaction(function () {
            do {
                // Lock the table during ID generation
                $lastEmployee = static::lockForUpdate()->latest('employee_id')->first();

                // Extract numeric part of the last ID or initialize to 1
                if ($lastEmployee) {
                    $lastNumber = intval(substr($lastEmployee->employee_id, 3));
                    $number = $lastNumber + 1;
                } else {
                    $number = 1;
                }

                // Generate new employee ID
                $newEmployeeId = 'EMP' . str_pad($number, 4, '0', STR_PAD_LEFT);

                // Check if this ID already exists
                $exists = static::where('employee_id', $newEmployeeId)->exists();

            } while ($exists); // Retry if the ID already exists

            return $newEmployeeId;
        }, 5); // Retry the transaction up to 5 times
    }

    /**
     * Define a relationship to the Department model.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Define a many-to-many relationship to the Team model.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_employee')
            ->withPivot('position')
            ->withTimestamps();
    }

    /**
     * Get all teams managed by this employee.
     */
    public function managedTeams(): BelongsToMany
    {
        return $this->teams()->wherePivot('position', 'manager');
    }

    /**
     * Get all teams led by this employee.
     */
    public function leadTeams(): BelongsToMany
    {
        return $this->teams()->wherePivot('position', 'team_lead');
    }

    /**
     * Get the most recent team of the employee.
     */
    public function currentTeam(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_employee')
            ->withPivot('position')
            ->orderBy('team_employee.created_at', 'desc')
            ->limit(1);
    }

    /**
     * Define a relationship to the TeamTransfer model for tracking transfers.
     */
    public function transfers()
    {
        return $this->hasMany(TeamTransfer::class);
    }
}
