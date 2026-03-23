<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            User::ROLE_ADMIN,
            User::ROLE_CONSULTANT,
            User::ROLE_CLIENT,
        ], true);
    }

    public function view(User $user, Project $project): bool
    {
        if ($user->role === User::ROLE_ADMIN) {
            return true;
        }

        if ($user->role === User::ROLE_CLIENT) {
            return $project->client_id === $user->id;
        }

        if ($user->role === User::ROLE_CONSULTANT) {
            return $project->consultants()->whereKey($user->id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    public function update(User $user, Project $project): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }
}
