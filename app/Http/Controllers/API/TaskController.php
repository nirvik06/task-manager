<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! $user) {
            return $this->error('Unauthenticated.', 401);
        }

        $status = $request->query('status');
        $due = $request->query('due_date');
        $q = $request->query('q');

        $query = $user->isAdmin() ? Task::with('user') : $user->tasks();

        if ($status) $query->where('status', $status);
        if ($due) $query->whereDate('due_date', $due);
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $tasks = $query->latest()->paginate(10);

        return $this->success(TaskResource::collection($tasks)->response()->getData(true), 'Tasks retrieved', 200);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! $user) return $this->error('Unauthenticated.', 401);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'in:pending,in_progress,done',
        ]);

        $task = $user->tasks()->create($data);

        return $this->success(new TaskResource($task), 'Task created', 201);
    }

    public function show(Request $request, Task $task): JsonResponse
    {
        $user = $request->user();
        if (! $user) return $this->error('Unauthenticated.', 401);
        if (! ($task->user_id === $user->id)) return $this->error('Forbidden', 403);

        return $this->success(new TaskResource($task->load('user')), 'Task retrieved', 200);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $user = $request->user();
        if (! $user) return $this->error('Unauthenticated.', 401);
        if (! ($task->user_id === $user->id)) return $this->error('Forbidden', 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'in:pending,in_progress,done',
        ]);

        $task->update($data);

        return $this->success(new TaskResource($task), 'Task updated', 200);
    }

    public function destroy(Request $request, Task $task): JsonResponse
    {
        $user = $request->user();
        if (! $user) return $this->error('Unauthenticated.', 401);
        if (! ($task->user_id === $user->id)) return $this->error('Forbidden', 403);

        $task->delete();
        return $this->success([
            'id' => $task->id,
            'title' => $task->title
        ], 'Task deleted successfully', 200);
    }
}