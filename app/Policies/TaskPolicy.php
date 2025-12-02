<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any task.
     * Admin can view any; users can view their own via controller or index.
     */
    public function viewAny(User $user): bool
    {
        return true; // controllers handle scoping for lists; keep permissive
    }

    /**
     * Determine whether the user can view the task.
     */
    public function view(User $user, Task $task)
    {
        return $user->isAdmin() || $task->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this task.');
    }

    /**
     * Determine whether the user can create tasks.
     */
    public function create(User $user): bool
    {
        // all authenticated users can create
        return true;
    }

    /**
     * Determine whether the user can update the task.
     */
    public function update(User $user, Task $task)
    {
        return $user->isAdmin() || $task->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this task.');
    }

    /**
     * Determine whether the user can delete the task.
     */
    public function delete(User $user, Task $task)
    {
        return $user->isAdmin() || $task->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this task.');
    }
}