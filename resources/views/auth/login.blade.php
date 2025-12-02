@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h3 class="card-title mb-3">Sign in</h3>

        <form method="POST" action="{{ url('login') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input name="remember" class="form-check-input" type="checkbox" id="remember">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <a href="#" class="small">Forgot password?</a>
          </div> -->

          <div class="d-grid mb-2">
            <button class="btn btn-primary">Login</button>
          </div>

          <div class="text-center small text-muted">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection