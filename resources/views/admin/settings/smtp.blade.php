@extends('adminlte::page')

@section('title', 'SMTP & Email Configuration')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">SMTP & Email Configuration</h1>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-1"></i> Back to Settings
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

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
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

@php
  $smtpMap = $smtp->pluck('value', 'key')->toArray();
@endphp

<div class="row g-3">
  <!-- SMTP Form -->
  <div class="col-lg-8">
    <form method="POST" action="{{ route('admin.smtp.update') }}">
      @csrf
      @method('PUT')

      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-server me-2 text-primary"></i>Outgoing Mail Server (SMTP)</h3>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-8">
              <label class="form-label fw-semibold">SMTP Host <span class="text-danger">*</span></label>
              <input type="text" name="settings[smtp_host]" class="form-control @error('settings.smtp_host') is-invalid @enderror" value="{{ old('settings.smtp_host', $smtpMap['smtp_host'] ?? '') }}" placeholder="e.g. smtp.gmail.com or mail.yourdomain.com" required>
              @error('settings.smtp_host')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">SMTP Port <span class="text-danger">*</span></label>
              <input type="number" name="settings[smtp_port]" class="form-control @error('settings.smtp_port') is-invalid @enderror" value="{{ old('settings.smtp_port', $smtpMap['smtp_port'] ?? '587') }}" placeholder="587 or 465" required>
              @error('settings.smtp_port')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">SMTP Username / Email <span class="text-danger">*</span></label>
              <input type="text" name="settings[smtp_username]" class="form-control @error('settings.smtp_username') is-invalid @enderror" value="{{ old('settings.smtp_username', $smtpMap['smtp_username'] ?? '') }}" placeholder="user@domain.com" required>
              @error('settings.smtp_username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">SMTP Password</label>
              <input type="password" name="settings[smtp_password]" class="form-control @error('settings.smtp_password') is-invalid @enderror" placeholder="{{ empty($smtpMap['smtp_password']) ? 'Enter password' : '•••••••• (leave blank to keep unchanged)' }}">
              @error('settings.smtp_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Encryption <span class="text-danger">*</span></label>
              <select name="settings[smtp_encryption]" class="form-select @error('settings.smtp_encryption') is-invalid @enderror" required>
                @php $currentEnc = old('settings.smtp_encryption', $smtpMap['smtp_encryption'] ?? 'tls'); @endphp
                <option value="tls" {{ $currentEnc === 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                <option value="ssl" {{ $currentEnc === 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                <option value="none" {{ $currentEnc === 'none' ? 'selected' : '' }}>None (Port 25)</option>
              </select>
              @error('settings.smtp_encryption')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <hr class="my-4">

          <h5 class="fw-bold mb-3"><i class="bi bi-person-badge me-2 text-info"></i>Sender Details</h5>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">From Name <span class="text-danger">*</span></label>
              <input type="text" name="settings[smtp_from_name]" class="form-control @error('settings.smtp_from_name') is-invalid @enderror" value="{{ old('settings.smtp_from_name', $smtpMap['smtp_from_name'] ?? 'MH Trade Capital Solutions') }}" required>
              @error('settings.smtp_from_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">From Email Address <span class="text-danger">*</span></label>
              <input type="email" name="settings[smtp_from_email]" class="form-control @error('settings.smtp_from_email') is-invalid @enderror" value="{{ old('settings.smtp_from_email', $smtpMap['smtp_from_email'] ?? 'contact@mhtradecap.com') }}" required>
              @error('settings.smtp_from_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-save me-1"></i> Save SMTP Settings
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Test Email & Info Sidebar -->
  <div class="col-lg-4">
    <div class="card shadow-sm mb-3">
      <div class="card-header bg-light">
        <h3 class="card-title fw-bold text-dark"><i class="bi bi-send-check me-2 text-success"></i>Test Email Delivery</h3>
      </div>
      <div class="card-body">
        <p class="text-muted small">
          Send a quick test message using the saved SMTP credentials to verify configuration.
        </p>

        <form method="POST" action="{{ route('admin.smtp.test') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label fw-semibold">Recipient Email Address</label>
            <input type="email" name="test_email" class="form-control" placeholder="your-email@example.com" value="{{ old('test_email', auth()->user()->email ?? '') }}" required>
          </div>
          <button type="submit" class="btn btn-outline-success w-100">
            <i class="bi bi-send me-1"></i> Send Test Email
          </button>
        </form>
      </div>
    </div>

    <div class="card shadow-sm border-0 bg-body-tertiary">
      <div class="card-body">
        <h6 class="fw-bold"><i class="bi bi-lightbulb text-warning me-1"></i> Common Ports:</h6>
        <ul class="small text-muted mb-0 ps-3">
          <li><strong>587</strong>: TLS / STARTTLS (Recommended)</li>
          <li><strong>465</strong>: SSL</li>
          <li><strong>25</strong>: Unencrypted (Usually blocked by ISPs)</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
