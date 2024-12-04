<?php

namespace App\Http\Controllers;

use App\Models\BreakRecord; // Ensure this model exists
use App\Models\Employee; // Ensure this model exists
use App\Models\Team; // Ensure this model exists
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Function for generating break report within a date range.
     */
    public function breaks(Request $request)
    {
        // Validate input for date range selection
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Default date range: current month if not provided
        $startDate = $validated['start_date'] ?? now()->startOfMonth()->toDateString();
        $endDate = $validated['end_date'] ?? now()->endOfMonth()->toDateString();

        // Fetch break records within the date range, with employee details
        $breaks = BreakRecord::select(
            DB::raw('ROW_NUMBER() OVER (ORDER BY breaks.created_at) as sr_no'),
            'employees.id as user_id',
            DB::raw('CONCAT(employees.first_name, " ", employees.last_name) as name'),
            'breaks.created_at as break_time'
        )
            ->join('employees', 'employees.id', '=', 'breaks.user_id') // Ensure breaks.user_id is correct
            ->whereBetween('breaks.created_at', [$startDate, $endDate])
            ->get();

        // Return the view with breaks data
        return Inertia::render('Reports/BreakReport', [
            'breaks' => $breaks,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Function for generating total breaks report, aggregating breaks per employee.
     */
    public function totalBreaks(Request $request)
    {
        // Fetch total breaks for each employee, including their department and position
        $employees = Employee::select(
            'employees.id',
            DB::raw('CONCAT(employees.first_name, " ", employees.last_name) as full_name'),
            'employees.department_id',
            'employees.designation as position',
            DB::raw('COUNT(breaks.id) as total_breaks')
        )
            ->leftJoin('breaks', 'breaks.employee_id', '=', 'employees.id') // Ensure 'employee_id' is correct in breaks table
            ->groupBy('employees.id', 'employees.first_name', 'employees.last_name', 'employees.department_id', 'employees.designation')
            ->orderBy('total_breaks','desc')
            ->get();

        // Paginate if needed
        return Inertia::render('Reports/TotalBreakReport', [
            'employees' => $employees,
        ]);
    }

    /**
     * Function for getting team members including their positions within each team.
     */
    public function getMembers()
    {
        // Fetch all teams along with their associated members (employees)
        $teams = Team::with(['members' => function ($query) {
            $query->select(
                'employees.id as employee_id',
                'employees.first_name',
                'employees.last_name',
                'employees.designation',
                'team_employee.team_id',
                'team_employee.position' // This ensures team members and their positions are retrieved
            );
        }])->get(['id', 'name']); // Fetching team id and name

        return Inertia::render('Reports/TeamMembers', [
            'teams' => $teams,
        ]);
    }
}
