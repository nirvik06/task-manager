<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        // Read filter inputs
        $q = $request->query('q');
        $status = $request->query('status');
        $due = $request->query('due_date');

        // Start query: admin sees all tasks, regular user only their own
        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            $query = Task::with('user');
        } else {
            $query = $user->tasks()->with('user');
        }

        // Apply filters
        if ($status) {
            $query->where('status', $status);
        }

        if ($due) {
            $query->whereDate('due_date', $due);
        }

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Paginate and keep the query string on links
        $tasks = $query->latest()->paginate(10)->withQueryString();

        // Pass current filters to view so the form stays filled
        return view('tasks.index', [
            'tasks'  => $tasks,
            'q'      => $q,
            'status' => $status,
            'due'    => $due,
        ]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $r)
    {
        // Basic validation — consider extracting to FormRequest
        $data = $r->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'in:pending,in_progress,done',
        ]);

        // Create via relationship ensures user_id is set
        auth()->user()->tasks()->create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.create', compact('task'));
    }

    public function update(Request $r, Task $task)
    {
        $this->authorize('update', $task);

        $data = $r->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'in:pending,in_progress,done',
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted');
    }
}