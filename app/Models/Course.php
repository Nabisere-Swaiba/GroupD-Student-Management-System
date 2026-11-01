<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'title', 'description', 'credit_units', 'capacity', 'lecturer_id',
    ];

    /** A course belongs to one lecturer (a User with the lecturer role). */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /** A course has many registrations. */
    public function registrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    /** Many-to-many: the students registered for a course. */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_registrations')
                    ->withPivot('registered_at')
                    ->withTimestamps();
    }

    public function isFull(): bool
    {
        return $this->students()->count() >= $this->capacity;
    }
}
