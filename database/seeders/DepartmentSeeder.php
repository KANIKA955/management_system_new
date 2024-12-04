<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // departments with dummy description
        $departments = [
            ['name' => 'HR', 'description' => 'Human Resource Department'],
            ['name' => 'IT', 'description' => 'Information Technology Department'],
            ['name' => 'Finance', 'description' => 'Finance Department'],
            ['name' => 'Marketing', 'description' => 'Marketing Department'],
            ['name' => 'Sales', 'description' => 'Sales Department'],
        ];
        Department::insert($departments);
    }
}
