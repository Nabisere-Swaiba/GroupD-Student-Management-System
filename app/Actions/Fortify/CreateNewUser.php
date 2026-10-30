<?php

namespace App\Actions\Fortify;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Self-registration always creates a STUDENT (role + student profile).
     * Admin and lecturer accounts are created by seeders / the administrator.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'student_number' => ['required', 'string', 'max:50', 'unique:students,student_number'],
            'programme'      => ['required', 'string', 'max:100'],
            'password'       => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name'     => $input['name'],
                'email'    => $input['email'],
                'password' => $input['password'],   // hashed by the model cast
            ]);

            $user->assignRole('student');

            Student::create([
                'user_id'        => $user->id,
                'student_number' => $input['student_number'],
                'programme'      => $input['programme'],
            ]);

            return $user;
        });
    }
}
