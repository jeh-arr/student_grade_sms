<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'year_level',
        'date_of_birth',
        'gender',
        'address',
        'contact_number',
        'course_id',
        'user_id',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    public function grades()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
