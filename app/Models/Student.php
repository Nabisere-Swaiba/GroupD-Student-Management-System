<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'student_number', 'programme'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // Q1c: a student's registered courses  ->  $student->courses
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'registrations')
            ->withPivot('registered_at')
            ->withTimestamps();
    }
}
