<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Employee;
use App\Models\TeamTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TeamTransferController extends Controller
{
    public function index()
    {
        $transfers = TeamTransfer::with(['employee', 'fromTeam', 'toTeam', 'transferredBy'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Teams/Transfers/Index', [
            'transfers' => $transfers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'to_team_id' => 'required|exists:teams,id',
            'new_position' => ['required', 'in:manager,team_lead,executive'],
            'reason' => 'nullable|string',
            'transfer_date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            // Get current team and position
            $currentTeam = Team::whereHas('members', function($query) use ($validated) {
                $query->where('employee_id', $validated['employee_id']);
            })->first();

            if ($currentTeam) {
                $currentPosition = $currentTeam->members()
                    ->where('employee_id', $validated['employee_id'])
                    ->first()
                    ->pivot
                    ->position;

                // Create transfer record
                TeamTransfer::create([
                    'employee_id' => $validated['employee_id'],
                    'from_team_id' => $currentTeam->id,
                    'to_team_id' => $validated['to_team_id'],
                    'previous_position' => $currentPosition,
                    'new_position' => $validated['new_position'],
                    'transferred_by' => auth()->id(),
                    'reason' => $validated['reason'],
                    'transfer_date' => $validated['transfer_date']
                ]);

                // Remove from current team
                $currentTeam->members()->detach($validated['employee_id']);
            }

            // Add to new team
            $newTeam = Team::find($validated['to_team_id']);
            $newTeam->members()->attach($validated['employee_id'], [
                'position' => $validated['new_position']
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Employee transferred successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to transfer employee.');
        }
    }

    public function employeeHistory($employeeId)
    {
        $transfers = TeamTransfer::with(['fromTeam', 'toTeam'])
            ->where('employee_id', $employeeId)
            ->latest()
            ->get();

        return response()->json($transfers);
    }
}
