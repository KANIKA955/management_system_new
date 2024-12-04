<?php

use App\Events\Example;
use App\Http\Controllers\BreakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamTransferController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/broadcast/{message}', function ($message) {
        Example::dispatch(\App\Models\User::find(1),$message);
    });



//    Only Front End Routes
    Route::get('/employeeList', function () {
        $employees = [
            ['id' => 1, 'employee_id' => 'CR012M', 'name' => 'John Doe', 'department' => 'Customer Support', 'designation' => 'Employee', 'reporting_manager' => 'William Johns', 'shift_time' => '10:00AM - 12:00PM', 'profile_status' => 1],
            ['id' => 2, 'employee_id' => 'AC034N', 'name' => 'Alice Brown', 'department' => 'Accountant', 'designation' => 'Accountant', 'reporting_manager' => 'George Clark', 'shift_time' => '09:00AM - 05:00PM', 'profile_status' => 0],
            ['id' => 3, 'employee_id' => 'TC056O', 'name' => 'Michael Smith', 'department' => 'Technical', 'designation' => 'Team Lead', 'reporting_manager' => 'David Wilson', 'shift_time' => '11:00AM - 07:00PM', 'profile_status' => 1],
            ['id' => 4, 'employee_id' => 'CR078P', 'name' => 'Emily Davis', 'department' => 'Customer Support', 'designation' => 'Manager', 'reporting_manager' => 'Sophia Clark', 'shift_time' => '08:00AM - 04:00PM', 'profile_status' => 1],
            ['id' => 5, 'employee_id' => 'AC091Q', 'name' => 'Robert Taylor', 'department' => 'Accountant', 'designation' => 'Senior Accountant', 'reporting_manager' => 'John Adams', 'shift_time' => '10:00AM - 06:00PM', 'profile_status' => 0],
            ['id' => 6, 'employee_id' => 'TC113R', 'name' => 'Jessica White', 'department' => 'Technical', 'designation' => 'Developer', 'reporting_manager' => 'Chris Johnson', 'shift_time' => '12:00PM - 08:00PM', 'profile_status' => 1],
            ['id' => 7, 'employee_id' => 'CR125S', 'name' => 'David Wilson', 'department' => 'Customer Support', 'designation' => 'Support Lead', 'reporting_manager' => 'Emily Turner', 'shift_time' => '09:00AM - 05:00PM', 'profile_status' => 0],
            ['id' => 8, 'employee_id' => 'AC148T', 'name' => 'Linda Moore', 'department' => 'Accountant', 'designation' => 'Junior Accountant', 'reporting_manager' => 'Daniel Scott', 'shift_time' => '08:00AM - 04:00PM', 'profile_status' => 1],
            ['id' => 9, 'employee_id' => 'TC169U', 'name' => 'Chris Lee', 'department' => 'Technical', 'designation' => 'System Analyst', 'reporting_manager' => 'Michael Brown', 'shift_time' => '10:00AM - 06:00PM', 'profile_status' => 0],
            ['id' => 10, 'employee_id' => 'CR183V', 'name' => 'Sophia Clark', 'department' => 'Customer Support', 'designation' => 'Support Executive', 'reporting_manager' => 'Jessica White', 'shift_time' => '09:00AM - 05:00PM', 'profile_status' => 1]
        ];

        return Inertia::render('FrontEndPages/EmployeeList', [
            'employees' => $employees,
        ]);
    })->name('employeeList');

    Route::get('/employeeDetail', function () {
        return Inertia::render('FrontEndPages/EmployeeDetail');
    })->name('employeeDetail');

    Route::get('/teamList', function () {
        $teams = [
            ['id' => 1, 'name' => 'Team A', 'description' => 'Team for customer queries and support', 'department' => 'Customer Care', 'members' => ['Alice Johnson', 'Bob Lee Evans']],
            ['id' => 2, 'name' => 'Team B', 'description' => 'Team for handling financial accounts', 'department' => 'Accountant', 'members' => ['David Williams']],
            ['id' => 3, 'name' => 'Team C', 'description' => 'Technical team for IT support', 'department' => 'Technical', 'members' => ['Emily Clark', 'Franklin White', 'George Miller', 'Hannah Thompson']],
            ['id' => 4, 'name' => 'Team D', 'description' => 'Accounts and financial analysis team', 'department' => 'Accountant', 'members' => ['Ivy Carter', 'Jack Turner']],
            ['id' => 5, 'name' => 'Team E', 'description' => 'Customer service and feedback management', 'department' => 'Customer Care', 'members' => ['Karen Moore', 'Liam Hill', 'Megan Brown']]
        ];


        return Inertia::render('FrontEndPages/TeamList', [
            'teams' => $teams,
        ]);
    })->name('teamList');

    Route::get('/task', function () {
        $tasks = [
            ['date' => '10/12/2024', 'client_name' => 'Emma Johnson', 'mobile_number' => '9876543210', 'description' => 'Discuss new project requirements', 'assigned_to' => 'James', 'status' => 'complete'],
            ['date' => '10/13/2024', 'client_name' => 'Liam Brown', 'mobile_number' => '9876543211', 'description' => 'Follow-up on payment', 'assigned_to' => 'William', 'status' => 'pending'],
            ['date' => '10/14/2024', 'client_name' => 'Sophia Davis', 'mobile_number' => '9876543212', 'description' => 'Prepare quarterly report', 'assigned_to' => '', 'status' => 'incomplete'],
            ['date' => '10/15/2024', 'client_name' => 'Noah Wilson', 'mobile_number' => '9876543213', 'description' => 'Finalize contract with supplier', 'assigned_to' => 'Robort', 'status' => 'pending'],
            ['date' => '10/16/2024', 'client_name' => 'Olivia Martinez', 'mobile_number' => '9876543214', 'description' => 'Client meeting regarding feedback', 'assigned_to' => '', 'status' => 'complete'],
            ['date' => '10/17/2024', 'client_name' => 'Elijah Taylor', 'mobile_number' => '9876543215', 'description' => 'Send invoice for completed work', 'assigned_to' => 'Alice', 'status' => 'incomplete'],
            ['date' => '10/18/2024', 'client_name' => 'Ava Anderson', 'mobile_number' => '9876543216', 'description' => 'Update project documentation', 'assigned_to' => 'John', 'status' => 'complete'],
            ['date' => '10/19/2024', 'client_name' => 'Isabella Thomas', 'mobile_number' => '9876543217', 'description' => 'Arrange client call for feedback', 'assigned_to' => '', 'status' => 'pending'],
            ['date' => '10/20/2024', 'client_name' => 'Lucas Harris', 'mobile_number' => '9876543218', 'description' => 'Complete support tickets', 'assigned_to' => 'Emily', 'status' => 'incomplete'],
            ['date' => '10/21/2024', 'client_name' => 'Mia White', 'mobile_number' => '9876543219', 'description' => 'Prepare meeting agenda for Monday', 'assigned_to' => '', 'status' => 'complete'],
        ];




        return Inertia::render('FrontEndPages/Task', [
            'tasks' => $tasks,
        ]);
    })->name('task');

    Route::get('/clients', function () {
        $clients = [
            ['name' => 'John Doe', 'date_of_signup' => '12/10/2020', 'email' => 'john@gmail.com', 'mobile' => '0123456789'],
            ['name' => 'Jane Smith', 'date_of_signup' => '01/15/2021', 'email' => 'jane.smith@gmail.com', 'mobile' => '9876543210'],
            ['name' => 'Michael Johnson', 'date_of_signup' => '03/22/2021', 'email' => 'michael.johnson@gmail.com', 'mobile' => '0123456780'],
            ['name' => 'Emily Davis', 'date_of_signup' => '07/30/2021', 'email' => 'emily.davis@yahoo.com', 'mobile' => '0987654321'],
            ['name' => 'David Wilson', 'date_of_signup' => '11/05/2021', 'email' => 'david.wilson@hotmail.com', 'mobile' => '0123456781'],
            ['name' => 'Sophia Brown', 'date_of_signup' => '09/14/2022', 'email' => 'sophia.brown@gmail.com', 'mobile' => '9876543211'],
            ['name' => 'William Garcia', 'date_of_signup' => '04/18/2022', 'email' => 'william.garcia@gmail.com', 'mobile' => '0123456782'],
            ['name' => 'Olivia Martinez', 'date_of_signup' => '06/25/2022', 'email' => 'olivia.martinez@gmail.com', 'mobile' => '0987654322'],
            ['name' => 'James Anderson', 'date_of_signup' => '08/11/2022', 'email' => 'james.anderson@gmail.com', 'mobile' => '0123456783'],
            ['name' => 'Ava Thomas', 'date_of_signup' => '10/30/2023', 'email' => 'ava.thomas@gmail.com', 'mobile' => '9876543212'],
        ];


        return Inertia::render('FrontEndPages/Clients', [
            'clients' => $clients,
        ]);
    })->name('clients');
    Route::get('/serviceProvider', function () {
        $providers = [
            ['name' => 'John Doe', 'date_of_signup' => '12/10/2020', 'email' => 'john@gmail.com', 'mobile' => '0123456789'],
            ['name' => 'Jane Smith', 'date_of_signup' => '01/15/2021', 'email' => 'jane.smith@gmail.com', 'mobile' => '9876543210'],
            ['name' => 'Michael Johnson', 'date_of_signup' => '03/22/2021', 'email' => 'michael.johnson@gmail.com', 'mobile' => '0123456780'],
            ['name' => 'Emily Davis', 'date_of_signup' => '07/30/2021', 'email' => 'emily.davis@yahoo.com', 'mobile' => '0987654321'],
            ['name' => 'David Wilson', 'date_of_signup' => '11/05/2021', 'email' => 'david.wilson@hotmail.com', 'mobile' => '0123456781'],
            ['name' => 'Sophia Brown', 'date_of_signup' => '09/14/2022', 'email' => 'sophia.brown@gmail.com', 'mobile' => '9876543211'],
            ['name' => 'William Garcia', 'date_of_signup' => '04/18/2022', 'email' => 'william.garcia@gmail.com', 'mobile' => '0123456782'],
            ['name' => 'Olivia Martinez', 'date_of_signup' => '06/25/2022', 'email' => 'olivia.martinez@gmail.com', 'mobile' => '0987654322'],
            ['name' => 'James Anderson', 'date_of_signup' => '08/11/2022', 'email' => 'james.anderson@gmail.com', 'mobile' => '0123456783'],
            ['name' => 'Ava Thomas', 'date_of_signup' => '10/30/2023', 'email' => 'ava.thomas@gmail.com', 'mobile' => '9876543212'],
        ];


        return Inertia::render('FrontEndPages/ServiceProvider', [
            'providers' => $providers,
        ]);
    })->name('serviceProvider');



    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('users', UserController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class)->except(['create', 'edit', 'show']);
    Route::resource('teams', TeamController::class);



    // Break Management
    Route::prefix('break')->middleware(['auth'])->controller(BreakController::class)->group(function () {
        Route::get('/info', [BreakController::class, 'getBreakInformation'])->name('break.info');
        Route::post('/start', 'startBreak')->name('break.start');
        Route::post('/end', 'endBreak')->name('break.end');
    });

    //    Reports Routes
        Route::prefix('reports')->name('report.')->group(function () {
        Route::name('break.')->group(function(){
        Route::get('/break-report', [ReportController::class, 'breaks'])->name('index'); // Get all teams
      });

       Route::name('teams.')->group(function(){
       Route::get('/teams/members', [ReportController::class, 'getMembers'])->name('members'); // Get members of a team     Route::get('/employee/{employeeId}/history', [EmployeeController::class, 'history'])->name('employee.history'); // Get employee's team history
          });

          });


    Route::resource('teams', TeamController::class);
    Route::post('team-transfers', [TeamTransferController::class, 'store'])->name('team-transfers.store');
    Route::get('team-transfers/history/{employee}', [TeamTransferController::class, 'history'])->name('team-transfers.history');

    Route::middleware(['auth'])->group(function () {
        Route::prefix('chats')->name('chats.')->group(function () {
            Route::middleware(['permission:Chat view'])->group(function () {
                Route::get('/', [ChatController::class, 'index'])->name('index');
                Route::get('/{chatId}', [ChatController::class, 'show'])->name('show');
            });

            Route::middleware(['permission:Chat handle'])->group(function () {
                Route::post('/{chatId}/messages', [ChatController::class, 'sendMessage'])
                    ->name('messages.store');
            });

            Route::get('/attachments/{path}', [ChatController::class, 'getAttachment'])
                ->name('attachment.download')
                ->where('path', '.*');
        });
    });
});
