<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    // Define the fillable attributes
    protected $fillable = ['name', 'description', 'department_id'];

    /**
     * Get the department this team belongs to.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get all members of this team.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'team_employee')
            ->withPivot('position')
            ->withTimestamps();
    }

    /**
     * Get all managers of this team.
     */
    public function managers(): BelongsToMany
    {
        return $this->members()->wherePivot('position', 'manager');
    }

    /**
     * Get the team lead of this team.
     * Assumes a team has only one team lead.
     */
    public function teamLead(): BelongsToMany
    {
        return $this->members()->wherePivot('position', 'team_lead');
    }

    /**
     * Get all executives in this team.
     */
    public function executives(): BelongsToMany
    {
        return $this->members()->wherePivot('position', 'executive');
    }

    /**
     * Check if a given employee is part of the team.
     *
     * @param int $employeeId
     * @return bool
     */
    public function hasMember(int $employeeId): bool
    {
        return $this->members()->where('employee_id', $employeeId)->exists();
    }

    /**
     * Assign an employee to the team with a specific position.
     *
     * @param int $employeeId
     * @param string $position
     * @return void
     */
    public function assignMember(int $employeeId, string $position): void
    {
        $this->members()->attach($employeeId, ['position' => $position]);
    }

    /**
     * Remove an employee from the team.
     *
     * @param int $employeeId
     * @return void
     */
    public function removeMember(int $employeeId): void
    {
        $this->members()->detach($employeeId);
    }

    /**
     * Update an employee's position in the team.
     *
     * @param int $employeeId
     * @param string $position
     * @return void
     */
    public function updateMemberPosition(int $employeeId, string $position): void
    {
        $this->members()->updateExistingPivot($employeeId, ['position' => $position]);
    }
}
