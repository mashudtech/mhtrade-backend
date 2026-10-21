@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0"><i class="bi bi-key-fill me-2 text-primary"></i>Change Password</h1>
    <a href="{{ route('admin.profile') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-1"></i> Back to Profile
    </a>
  </div>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="row g-3 justify-content-center">
  <div class="col-lg-6 col-md-8">
    <div class="card shadow-sm">
      <div class="card-header bg-light">
        <h3 class="card-title fw-bold text-dark m-0">
          <i class="bi bi-shield-lock me-2 text-primary"></i>Update Security Password
        </h3>
      </div>
      <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
          <div class="mb-3">
            <label for="current_password" class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
              @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <small class="text-muted">Enter your existing account password to authorize the change.</small>
          </div>

          <hr class="my-4">

          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-key"></i></span>
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required minlength="8" autocomplete="new-password">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <small class="text-muted">Password must be at least 8 characters.</small>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-check2-circle"></i></span>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8" autocomplete="new-password">
            </div>
          </div>
        </div>
        <div class="card-footer bg-white text-end p-3">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-lg me-1"></i> Update Password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
