<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'subject_code',
        'subject_description',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Student::class);
    }
}
