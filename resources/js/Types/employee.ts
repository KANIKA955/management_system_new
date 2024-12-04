export interface Employee {
    id: string;
    employee_id: string;
    first_name: string;
    middle_name?: string;
    last_name: string;
    father_name?: string;
    mother_name?: string;
    date_of_birth: string;
    gender: 'male' | 'female' | 'other';
    marital_status: 'unmarried' | 'married' | 'divorced';
    blood_group?: string;
    disability?: string;
    city: string;
    country: string;

    // Contact Information
    email: string;
    phone?: string;
    mobile: string;
    alternate_number?: string;
    address: string;

    // Professional Information
    department: string;
    designation: string;
    reporting_manager: string;
    shift_start_time: string;
    shift_end_time: string;
    profile_status: boolean;
}
