@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
  <div>
    <h1 class="h4 mb-0">Tasks</h1>
    <div class="text-muted small">Manage tasks — create, edit, delete, and filter.</div>
  </div>
  <div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
  </div>
</div>

{{-- FILTER / SEARCH --}}
<form method="GET" action="{{ route('tasks.index') }}" class="row g-2 align-items-end mb-3">
  <div class="col-md-4">
    <label class="form-label small">Search</label>
    <input type="text" name="q" value="{{ old('q', $q ?? '') }}" class="form-control" placeholder="Search title or description">
  </div>

  <div class="col-md-3">
    <label class="form-label small">Status</label>
    <select name="status" class="form-select">
      <option value="">All</option>
      <option value="pending" {{ (isset($status) && $status=='pending') ? 'selected' : '' }}>Pending</option>
      <option value="in_progress" {{ (isset($status) && $status=='in_progress') ? 'selected' : '' }}>In Progress</option>
      <option value="done" {{ (isset($status) && $status=='done') ? 'selected' : '' }}>Done</option>
    </select>
  </div>

  <div class="col-md-3">
    <label class="form-label small">Due date</label>
    <input type="date" name="due_date" value="{{ old('due_date', $due ?? '') }}" class="form-control">
  </div>

  <div class="col-md-2 d-grid">
    <div class="d-flex gap-2">
      <button class="btn btn-outline-primary w-100">Filter</button>
      <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
  </div>
</form>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>Title</th>
            @if(auth()->user()->isAdmin())
                <th>Role</th>
            @endif
            <th style="width:170px">Status</th>
            <th style="width:140px">Due</th>
            <th style="width:150px" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tasks as $task)
          <tr>
            <td>
              <div class="fw-semibold">{{ $task->title }}</div>
              <div class="text-muted small">{{ \Illuminate\Support\Str::limit($task->description, 80) }}</div>
            </td>
            @if(auth()->user()->isAdmin())
                <td>Admin</td>
            @endif
            <td class="align-middle">
              @if($task->status === 'done')
                <span class="badge bg-success">Done</span>
              @elseif($task->status === 'in_progress')
                <span class="badge bg-warning text-dark">In Progress</span>
              @else
                <span class="badge bg-secondary">Pending</span>
              @endif
            </td>

            <td class="text-muted align-middle">{{ optional($task->due_date)->format('Y-m-d') ?? '-' }}</td>

            <td class="text-end align-middle">
              <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
              <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this task?')">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center py-5 text-muted">No tasks found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-3 d-flex justify-content-center">
  {{ $tasks->withQueryString()->links() }}
</div>
@endsection