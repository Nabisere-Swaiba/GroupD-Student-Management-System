<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** A user (with the student role) has one student profile. */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /** A user (with the lecturer role) teaches many courses. */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'lecturer_id');
    }

    protected function initials(): Attribute
    {
        return Attribute::get(function () {
            return collect(preg_split('/\s+/', trim($this->name)))
                ->filter()
                ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))
                ->take(2)
                ->implode('');
        });
    }

    public function roleName(): string
    {
        return $this->getRoleNames()->first() ?? 'no role';
    }
}
