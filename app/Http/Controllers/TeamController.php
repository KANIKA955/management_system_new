<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    public function index()
    {
        return Inertia::render('Teams/Index', [
            'teams' => Team::with(['department', 'members' => function($query) {
                $query->with(['department', 'currentTeam' => function($query) {
                    $query->select('teams.id', 'teams.name')
                        ->with('department:id,name');
                }])
                    ->select('employees.id', 'employees.first_name', 'employees.email',
                        'employees.phone', 'employees.department_id');
            }])->get(),
            'departments' => Department::select('id', 'name')->get(),
            'employees' => Employee::select('employees.id', 'employees.first_name')
                ->with(['currentTeam' => function($query) {
                    $query->select('teams.id', 'teams.name');
                }])
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'members' => 'array',
            'members.*.employee_id' => 'required|exists:employees,id',
            'members.*.position' => ['required', Rule::in(['manager', 'team_lead', 'executive'])],
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'department_id' => $validated['department_id'],
        ]);

        // Attach team members with their positions
        foreach ($validated['members'] as $member) {
            $team->members()->attach($member['employee_id'], [
                'position' => $member['position']
            ]);
        }

        return redirect()->back()->with('success', 'Team created successfully.');
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'members' => 'array',
            'members.*.employee_id' => 'required|exists:employees,id',
            'members.*.position' => ['required', Rule::in(['manager', 'team_lead', 'executive'])],
        ]);

        $team->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'department_id' => $validated['department_id'],
        ]);

        // Sync team members with their positions
        $team->members()->sync(collect($validated['members'])->mapWithKeys(function ($member) {
            return [$member['employee_id'] => ['position' => $member['position']]];
        }));

        return redirect()->back()->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->back()->with('success', 'Team deleted successfully.');
    }
}
