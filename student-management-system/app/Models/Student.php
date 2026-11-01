<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_number', 'first_name', 'last_name',
        'email', 'phone', 'date_of_birth', 'programme',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::get(fn () => $this->first_name . ' ' . $this->last_name);
    }

    /** A student belongs to one login account. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** A student has many registrations. */
    public function registrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    /** Many-to-many: the courses a student is registered for. */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_registrations')
                    ->withPivot('registered_at')
                    ->withTimestamps();
    }
}
