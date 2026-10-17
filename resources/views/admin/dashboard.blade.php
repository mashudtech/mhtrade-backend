@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="m-0">Dashboard</h1>
@endsection

@section('content')
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-primary shadow-sm">
      <div class="inner"><h3>{{ $stats['total'] }}</h3><p>Total Inquiries</p></div>
      <div class="small-box-icon"><i class="bi bi-inbox-fill"></i></div>
      <a href="{{ route('admin.inquiries.index') }}" class="small-box-footer">View All <i class="bi bi-arrow-right-circle"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-warning shadow-sm">
      <div class="inner"><h3>{{ $stats['new'] }}</h3><p>New Inquiries</p></div>
      <div class="small-box-icon"><i class="bi bi-bell-fill"></i></div>
      <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" class="small-box-footer">View New <i class="bi bi-arrow-right-circle"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-info shadow-sm">
      <div class="inner"><h3>{{ $stats['processing'] }}</h3><p>In Progress</p></div>
      <div class="small-box-icon"><i class="bi bi-gear-fill"></i></div>
      <a href="{{ route('admin.inquiries.index', ['status' => 'in_review']) }}" class="small-box-footer">View Processing <i class="bi bi-arrow-right-circle"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box text-bg-success shadow-sm">
      <div class="inner"><h3>{{ $stats['completed'] }}</h3><p>Completed</p></div>
      <div class="small-box-icon"><i class="bi bi-check-circle-fill"></i></div>
      <a href="{{ route('admin.inquiries.index', ['status' => 'completed']) }}" class="small-box-footer">View Completed <i class="bi bi-arrow-right-circle"></i></a>
    </div>
  </div>
</div>

<div class="row g-3">

  <!-- Inquiries by Vertical -->
  <div class="col-lg-5">
    <div class="card shadow-sm h-100">
      <div class="card-header"><h3 class="card-title"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Inquiries by Vertical</h3></div>
      <div class="card-body p-0">
        <ul class="list-group list-group-flush">
          @forelse($byVertical as $vertical => $count)
          @php
            $labels = ['lc' => 'Trade Finance', 'uae-banking' => 'UAE Banking', 'project' => 'Project Finance', 'commodity' => 'Commodity', 'general' => 'General'];
            $label = $labels[$vertical] ?? ucfirst($vertical);
          @endphp
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $label }}
            <span class="badge text-bg-primary rounded-pill">{{ $count }}</span>
          </li>
          @empty
          <li class="list-group-item text-muted">No inquiries yet.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  <!-- Recent Inquiries -->
  <div class="col-lg-7">
    <div class="card shadow-sm h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="bi bi-clock-history me-2 text-warning"></i>Recent Inquiries</h3>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>Request ID</th>
                <th>Name</th>
                <th>Vertical</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($recent as $inquiry)
              <tr>
                <td><code class="text-primary">{{ $inquiry->request_id }}</code></td>
                <td>{{ $inquiry->name }}</td>
                <td><small>{{ $inquiry->vertical_label }}</small></td>
                <td>
                  @php
                    $statusColors = ['new' => 'warning', 'in_review' => 'info', 'information_required' => 'secondary', 'processing' => 'primary', 'completed' => 'success', 'closed' => 'dark'];
                    $color = $statusColors[$inquiry->status] ?? 'secondary';
                  @endphp
                  <span class="badge text-bg-{{ $color }}">{{ $inquiry->status_label }}</span>
                </td>
                <td><a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-xs btn-outline-primary py-0 px-2"><i class="bi bi-eye"></i></a></td>
              </tr>
              @empty
              <tr><td colspan="5" class="text-center text-muted py-3">No inquiries yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
