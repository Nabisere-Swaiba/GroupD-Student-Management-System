<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['code', 'title', 'description', 'credits', 'lecturer_id'];

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // Q1c: students registered for a course  ->  $course->students
    public function students()
    {
        return $this->belongsToMany(Student::class, 'registrations')
            ->withPivot('registered_at')
            ->withTimestamps();
    }
}
