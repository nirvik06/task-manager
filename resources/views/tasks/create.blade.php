@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-10 col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="h5 mb-3">{{ isset($task) ? 'Edit Task' : 'Create Task' }}</h3>

        <form method="POST" action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}">
          @csrf
          @if(isset($task)) @method('PUT') @endif

          <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $task->title ?? '') }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Due Date</label>
              <input type="date" name="due_date" class="form-control" value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="pending" {{ old('status', $task->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('status', $task->status ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done" {{ old('status', $task->status ?? '') == 'done' ? 'selected' : '' }}>Done</option>
              </select>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button class="btn btn-primary">{{ isset($task) ? 'Update' : 'Create' }}</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection