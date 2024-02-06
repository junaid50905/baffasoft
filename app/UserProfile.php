<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    
    protected $table = 'users_profiles';

    
    protected $fillable = [
        'user_id', 'department_id', 'father_name', 'mother_name', 'emergancy_contact', 'blood_group', 'last_education', 'years_of_experience',
        'present_address', 'permanent_address','confirmation_date','joining_date', 'place_of_posting', 'designation', 'date_of_promotion', 'job_status' ];



    
}
