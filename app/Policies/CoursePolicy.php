<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class CoursePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(User $user)
    {
        return $user->role === 'teacher';
    }

    public function create(User $user)
    {
        Log::info('Checking create course permission', ['user_id' => $user->id, 'role' => $user->role]);
        return $user->role === 'teacher' || $user->role === 'admin';
    }
}
