@extends('adminlte::page')

@section('title', 'Website Settings')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Website Settings</h1>
    <a href="{{ route('admin.smtp.index') }}" class="btn btn-outline-primary btn-sm">
      <i class="bi bi-envelope-gear me-1"></i> Configure SMTP / Email
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
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="row g-3">
    <!-- Left Column: General & Contact -->
    <div class="col-lg-7">
      
      <!-- General Settings -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-globe me-2 text-primary"></i>General Settings</h3>
        </div>
        <div class="card-body">
          @foreach($general as $item)
          <div class="mb-3">
            <label class="form-label fw-semibold">{{ $item->label }}</label>
            <input type="text" name="settings[{{ $item->key }}]" class="form-control" value="{{ old('settings.' . $item->key, $item->value) }}">
            <small class="text-muted">Key: <code>{{ $item->key }}</code></small>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Contact Information -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-telephone me-2 text-success"></i>Contact Details</h3>
        </div>
        <div class="card-body">
          @foreach($contact as $item)
          <div class="mb-3">
            <label class="form-label fw-semibold">{{ $item->label }}</label>
            @if($item->key === 'office_address')
              <textarea name="settings[{{ $item->key }}]" rows="2" class="form-control">{{ old('settings.' . $item->key, $item->value) }}</textarea>
            @else
              <input type="text" name="settings[{{ $item->key }}]" class="form-control" value="{{ old('settings.' . $item->key, $item->value) }}">
            @endif
            <small class="text-muted">Key: <code>{{ $item->key }}</code></small>
          </div>
          @endforeach
        </div>
      </div>

    </div>

    <!-- Right Column: Logo & Social Media -->
    <div class="col-lg-5">

      <!-- Site Logo Upload -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-image me-2 text-primary"></i>Website Logo</h3>
        </div>
        <div class="card-body">
          <div class="mb-3 text-center p-3 rounded" style="background: #070F1E;">
            <img id="site-logo-preview" src="{{ asset('images/logo/logo.webp') }}" alt="Site Logo" style="max-height: 60px; max-width: 100%; object-fit: contain;">
          </div>
          <div class="mb-2">
            <label class="form-label small fw-semibold">Upload New Logo <small class="text-muted">(PNG, WebP, SVG)</small></label>
            <input type="file" name="site_logo_file" class="form-control form-control-sm" accept="image/*" onchange="if(this.files && this.files[0]){var r=new FileReader();r.onload=function(e){document.getElementById('site-logo-preview').src=e.target.result;};r.readAsDataURL(this.files[0]);}">
          </div>
        </div>
      </div>
      
      <!-- Social Media -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-share me-2 text-info"></i>Social Links</h3>
        </div>
        <div class="card-body">
          @foreach($social as $item)
          <div class="mb-3">
            <label class="form-label fw-semibold">{{ $item->label }}</label>
            <div class="input-group">
              @if(str_contains(strtolower($item->key), 'linkedin'))
                <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
              @elseif(str_contains(strtolower($item->key), 'facebook'))
                <span class="input-group-text"><i class="bi bi-facebook"></i></span>
              @else
                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
              @endif
              <input type="url" name="settings[{{ $item->key }}]" class="form-control" value="{{ old('settings.' . $item->key, $item->value) }}" placeholder="https://...">
            </div>
            <small class="text-muted">Key: <code>{{ $item->key }}</code></small>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Action Card -->
      <div class="card shadow-sm sticky-top" style="top: 20px;">
        <div class="card-body">
          <p class="text-muted small mb-3">
            <i class="bi bi-info-circle me-1"></i> Changes made here will instantly update the public website footer, header, and contact pages.
          </p>
          <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-save me-1"></i> Save All Settings
          </button>
        </div>
      </div>

    </div>
  </div>
</form>
@endsection
