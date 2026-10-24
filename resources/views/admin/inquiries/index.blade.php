@extends('adminlte::page')

@section('title', 'Inquiries')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1 class="m-0">All Inquiries</h1>
    <div class="btn-group">
      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel Report
      </button>
      <div class="dropdown-menu dropdown-menu-end shadow">
        <h6 class="dropdown-header">Report Frequency</h6>
        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.inquiries.export', ['period' => 'daily']) }}">
          <i class="bi bi-calendar-day me-2 text-primary"></i> Daily Report (Today)
        </a>
        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.inquiries.export', ['period' => 'weekly']) }}">
          <i class="bi bi-calendar-week me-2 text-info"></i> Weekly Report (This Week)
        </a>
        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.inquiries.export', ['period' => 'monthly']) }}">
          <i class="bi bi-calendar-month me-2 text-warning"></i> Monthly Report (This Month)
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.inquiries.export', array_merge(request()->query(), ['period' => 'all'])) }}">
          <i class="bi bi-download me-2 text-success"></i> Export Current Filter / All
        </a>
      </div>
    </div>
  </div>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<!-- Filters -->
<div class="card shadow-sm mb-3">
  <div class="card-body py-2">
    <form method="GET" class="row g-2 align-items-end">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search Request ID, Name, Company, Email...">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select form-select-sm">
          <option value="">All Statuses</option>
          @foreach(['new' => 'New', 'in_review' => 'In Review', 'information_required' => 'Information Required', 'processing' => 'Processing', 'completed' => 'Completed', 'closed' => 'Closed'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <select name="vertical" class="form-select form-select-sm">
          <option value="">All Verticals</option>
          @if(isset($solutions) && $solutions->isNotEmpty())
            @foreach($solutions as $sol)
              <option value="{{ $sol->slug }}" {{ request('vertical') === $sol->slug ? 'selected' : '' }}>{{ $sol->title }}</option>
            @endforeach
            <option value="general" {{ in_array(request('vertical'), ['general', 'general-inquiry']) ? 'selected' : '' }}>General Requirement</option>
          @else
            @foreach(['lc' => 'Trade Finance', 'uae-banking' => 'UAE Banking', 'project' => 'Project Finance', 'commodity' => 'Commodity', 'general' => 'General'] as $val => $label)
              <option value="{{ $val }}" {{ request('vertical') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-2 d-flex gap-1">
        <button type="submit" class="btn btn-primary btn-sm flex-fill"><i class="bi bi-search"></i> Filter</button>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x"></i></a>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover table-sm mb-0">
        <thead class="table-light">
          <tr>
            <th>Request ID</th>
            <th>Vertical</th>
            <th>Name</th>
            <th>Company</th>
            <th>Email</th>
            <th>Country</th>
            <th>Status</th>
            <th>Submitted</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($inquiries as $inquiry)
          @php
            $statusColors = ['new' => 'warning', 'in_review' => 'info', 'information_required' => 'secondary', 'processing' => 'primary', 'completed' => 'success', 'closed' => 'dark'];
            $color = $statusColors[$inquiry->status] ?? 'secondary';
          @endphp
          <tr>
            <td><code class="text-primary fw-bold">{{ $inquiry->request_id }}</code></td>
            <td><small class="text-muted">{{ $inquiry->vertical_label }}</small></td>
            <td>{{ $inquiry->name }}</td>
            <td>{{ $inquiry->company ?? '—' }}</td>
            <td><a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">{{ $inquiry->email }}</a></td>
            <td>{{ $inquiry->country ?? '—' }}</td>
            <td><span class="badge text-bg-{{ $color }}">{{ $inquiry->status_label }}</span></td>
            <td><small>{{ $inquiry->created_at->diffForHumans() }}</small></td>
            <td>
              <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-xs btn-outline-primary py-0 px-2">
                <i class="bi bi-eye"></i> View
              </a>
            </td>
          </tr>
          @empty
          <tr><td colspan="9" class="text-center text-muted py-4">No inquiries found matching the filters.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($inquiries->hasPages())
  <div class="card-footer">
    {{ $inquiries->links() }}
  </div>
  @endif
</div>

@endsection
