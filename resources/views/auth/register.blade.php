@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h3 class="card-title mb-3">Create account</h3>

        <form method="POST" action="{{ url('register') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Password</label>
              <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
              @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Confirm Password</label>
              <input name="password_confirmation" type="password" class="form-control" required>
            </div>
          </div>

          <div class="d-grid">
            <button class="btn btn-primary">Create account</button>
          </div>

          <p class="mt-3 text-center small text-muted">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
          </p>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection