@extends('adminlte::page')

@section('title', 'Admin Profile')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0"><i class="bi bi-person-circle me-2 text-primary"></i>Admin Profile</h1>
    <a href="{{ route('admin.password') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-key-fill me-1"></i> Change Password
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

<div class="row g-3">
  <!-- Left Column: User Summary Card -->
  <div class="col-lg-4">
    <div class="card shadow-sm text-center">
      <div class="card-body p-4">
        <div class="mb-3">
          <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px; font-size: 32px;">
            <i class="bi bi-person-fill"></i>
          </div>
        </div>
        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
        <p class="text-muted mb-2">{{ $user->email }}</p>
        <div class="mb-3">
          <span class="badge bg-success text-uppercase px-2 py-1" style="letter-spacing: 0.5px;">
            <i class="bi bi-shield-check me-1"></i>{{ $user->role ?? 'Administrator' }}
          </span>
        </div>
        <hr>
        <div class="text-start small text-muted">
          <div class="d-flex justify-content-between py-1">
            <span><i class="bi bi-calendar3 me-1"></i> Member Since:</span>
            <span class="fw-semibold text-dark">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
          </div>
          <div class="d-flex justify-content-between py-1">
            <span><i class="bi bi-clock-history me-1"></i> Last Updated:</span>
            <span class="fw-semibold text-dark">{{ $user->updated_at ? $user->updated_at->format('M d, Y H:i') : 'N/A' }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column: Profile Edit Form -->
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-header bg-light">
        <h3 class="card-title fw-bold text-dark m-0">
          <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Profile Details
        </h3>
      </div>
      <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <small class="text-muted">This email is used for administrator login.</small>
          </div>
        </div>
        <div class="card-footer bg-white text-end p-3">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-save me-1"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
