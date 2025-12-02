<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $q = $request->query('q');
        $status = $request->query('status');
        $due = $request->query('due_date');

        // Admin sees all tasks, normal user sees only own tasks
        $query = $user->isAdmin() ? Task::with('user') : $user->tasks()->with('user');

        if ($status) $query->where('status', $status);
        if ($due) $query->whereDate('due_date', $due);
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $tasks = $query->latest()->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks', 'q', 'status', 'due'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $request->user()->tasks()->create($data);
        return redirect()->route('tasks.index')->with('success','Task created');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.create', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->validated());
        return redirect()->route('tasks.index')->with('success','Task updated');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success','Task deleted');
    }
}