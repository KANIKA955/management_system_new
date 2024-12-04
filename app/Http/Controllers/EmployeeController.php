<?php

namespace App\Http\Controllers;

use App\Helpers\Toast;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = Employee::with('department')->get();
        return Inertia::render('Employee/Index', [
            'employees' => $employees,
        ]);
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return Inertia::render('Employee/Form', [
            'isEditing' => false,
            'departments' => Department::all(),
        ]);
    }

    /**
     * Store a newly created employee in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        try {
            $employee = Employee::create($validated + ['department_id' => $request->department]);

            Toast::success("Employee {$employee->first_name} {$employee->last_name} created successfully.");

            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            Toast::error('Failed to create employee. Please try again.');
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while creating the employee.'])
                ->withInput();
        }
    }

    /**
     * Display the specified employee's details.
     */
    public function show(Employee $employee)
    {
        return Inertia::render('Employee/Show', [
            'employee' => $employee->load('department'),
        ]);
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        return Inertia::render('Employee/Form', [
            'employee' => $employee,
            'isEditing' => true,
            'departments' => Department::all(),
        ]);
    }

    /**
     * Update the specified employee in the database.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate($this->validationRules($employee->id));

        try {
            $employee->update($validated);

            Toast::success("Employee {$employee->first_name} {$employee->last_name} updated successfully.");

            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            Toast::error('Failed to update employee. Please try again.');
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while updating the employee.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified employee from the database.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            Toast::success("Employee {$employee->first_name} {$employee->last_name} deleted successfully.");

            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            Toast::error('Failed to delete employee. Please try again.');
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while deleting the employee.']);
        }
    }

    /**
     * Toggle the active status of an employee.
     */
    public function toggleStatus(Employee $employee)
    {
        try {
            $employee->update([
                'profile_status' => !$employee->profile_status,
            ]);

            Toast::success("Employee {$employee->first_name} {$employee->last_name} status updated successfully.");

            return redirect()->back();
        } catch (\Exception $e) {
            Toast::error('Failed to update employee status. Please try again.');
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while updating the employee status.']);
        }
    }

    /**
     * Validation rules for storing and updating employees.
     */
    private function validationRules($employeeId = null): array
    {
        return [
            // Personal Information
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:unmarried,married,divorced',
            'blood_group' => 'nullable|string|max:5',
            'disability' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',

            // Contact Information
            'email' => 'required|email|unique:employees,email,' . $employeeId,
            'phone' => 'nullable|string|max:20',
            'mobile' => 'required|string|max:20',
            'alternate_number' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',

            // Professional Information
            'department' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'reporting_manager' => 'required|string|max:255',
            'shift_start_time' => 'required|date_format:H:i',
            'shift_end_time' => 'required|date_format:H:i|after:shift_start_time',
        ];
    }
}
