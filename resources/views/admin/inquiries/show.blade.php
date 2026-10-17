@extends('adminlte::page')

@section('title', 'Inquiry ' . $inquiry->request_id)

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Inquiry <code class="text-primary">{{ $inquiry->request_id }}</code></h1>
    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to List</a>
  </div>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">

  <!-- Left: Inquiry Details -->
  <div class="col-lg-8">
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h3 class="card-title"><i class="bi bi-person-fill me-2 text-primary"></i>Client Information</h3></div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">Request ID</dt>
          <dd class="col-sm-8"><code class="text-primary fw-bold">{{ $inquiry->request_id }}</code></dd>

          <dt class="col-sm-4">Vertical</dt>
          <dd class="col-sm-8">{{ $inquiry->vertical_label }}</dd>

          <dt class="col-sm-4">Full Name</dt>
          <dd class="col-sm-8">{{ $inquiry->name }}</dd>

          <dt class="col-sm-4">Company</dt>
          <dd class="col-sm-8">{{ $inquiry->company ?? '—' }}</dd>

          <dt class="col-sm-4">Position</dt>
          <dd class="col-sm-8">{{ $inquiry->position ?? '—' }}</dd>

          <dt class="col-sm-4">Email</dt>
          <dd class="col-sm-8"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></dd>

          <dt class="col-sm-4">Phone / WhatsApp</dt>
          <dd class="col-sm-8">
            @if($inquiry->phone)
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp text-success"></i> {{ $inquiry->phone }}
              </a>
            @else
              —
            @endif
          </dd>

          <dt class="col-sm-4">Country</dt>
          <dd class="col-sm-8">{{ $inquiry->country ?? '—' }}</dd>

          <dt class="col-sm-4">Submitted</dt>
          <dd class="col-sm-8">{{ $inquiry->created_at->format('d M Y, H:i') }} ({{ $inquiry->created_at->diffForHumans() }})</dd>
        </dl>
      </div>
    </div>

    @if($inquiry->details)
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h3 class="card-title"><i class="bi bi-file-text me-2 text-info"></i>Requirement Specifications</h3></div>
      <div class="card-body"><p class="mb-0" style="white-space: pre-wrap;">{{ $inquiry->details }}</p></div>
    </div>
    @endif

    @if($inquiry->doc_path)
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h3 class="card-title"><i class="bi bi-paperclip me-2 text-warning"></i>Attached Document</h3></div>
      <div class="card-body">
        <a href="{{ route('admin.inquiries.show', $inquiry) }}?download=1" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-download"></i> Download Document
        </a>
        <small class="text-muted ms-2">{{ basename($inquiry->doc_path) }}</small>
      </div>
    </div>
    @endif
  </div>

  <!-- Right: Status & Notes -->
  <div class="col-lg-4">
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h3 class="card-title"><i class="bi bi-flag-fill me-2 text-warning"></i>Status &amp; Lifecycle</h3></div>
      <div class="card-body">
        @php
          $statusColors = ['new' => 'warning', 'in_review' => 'info', 'information_required' => 'secondary', 'processing' => 'primary', 'completed' => 'success', 'closed' => 'dark'];
          $color = $statusColors[$inquiry->status] ?? 'secondary';
        @endphp
        <div class="mb-3">
          <span class="badge text-bg-{{ $color }} fs-6 px-3 py-2">{{ $inquiry->status_label }}</span>
        </div>

        <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
          @csrf
          @method('PATCH')

          <div class="mb-3">
            <label class="form-label fw-semibold">Update Status</label>
            <select name="status" class="form-select">
              @foreach(\App\Models\Inquiry::$statusLabels as $val => $label)
                <option value="{{ $val }}" {{ $inquiry->status === $val ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Internal Notes</label>
            <textarea name="internal_notes" class="form-control" rows="5" placeholder="Internal operational notes (not visible to client)...">{{ $inquiry->internal_notes }}</textarea>
          </div>

          <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Save Updates</button>
        </form>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-header"><h3 class="card-title"><i class="bi bi-link-45deg me-2"></i>Quick Actions</h3></div>
      <div class="card-body d-grid gap-2">
        @if($inquiry->phone)
          <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="btn btn-outline-success btn-sm">
            <i class="bi bi-whatsapp"></i> WhatsApp Client
          </a>
        @endif
        <a href="mailto:{{ $inquiry->email }}" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-envelope"></i> Email Client
        </a>
      </div>
    </div>
  </div>

</div>
@endsection
