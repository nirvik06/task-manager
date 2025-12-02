<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ config('app.name', 'TaskManager') }}</title>

  {{-- Vite will include compiled bootstrap css/js --}}
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('tasks.index') }}">
      <div class="rounded bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;font-weight:600;">TM</div>
      <span class="ms-2 fw-semibold">{{ config('app.name','TaskManager') }}</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsMain" aria-controls="navbarsMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsMain">
      <ul class="navbar-nav ms-auto align-items-center">
        @auth
          <li class="nav-item me-2">
            <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="{{ route('tasks.index') }}">My Tasks</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button class="dropdown-item text-danger" type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item"><a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary" href="{{ route('register') }}">Register</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<main class="py-5">
  <div class="container">
    {{-- Flash messages --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @yield('content')
  </div>
</main>

<footer class="border-top py-3 bg-white">
  <div class="container text-center text-muted small">
    &copy; {{ date('Y') }} {{ config('app.name','TaskManager') }} · Built with Bootstrap
  </div>
</footer>

</body>
</html>