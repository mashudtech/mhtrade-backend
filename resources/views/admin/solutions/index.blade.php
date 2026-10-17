@extends('adminlte::page')

@section('title', 'Solutions Management')

@section('content_header')
  <h1 class="m-0">Solutions Management</h1>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:40px;">#</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Badge / Instruments</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($solutions as $solution)
          <tr>
            <td class="text-muted">{{ $solution->sort_order }}</td>
            <td><strong>{{ $solution->title }}</strong></td>
            <td><code>{{ $solution->slug }}</code></td>
            <td><small class="text-muted">{{ Str::limit($solution->badge, 60) }}</small></td>
            <td>
              @if($solution->is_published)
                <span class="badge text-bg-success">Published</span>
              @else
                <span class="badge text-bg-secondary">Unpublished</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('admin.solutions.edit', $solution) }}" class="btn btn-sm btn-outline-primary py-0 px-2">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <form method="POST" action="{{ route('admin.solutions.toggle', $solution) }}" class="d-inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-{{ $solution->is_published ? 'warning' : 'success' }} py-0 px-2">
                    <i class="bi bi-{{ $solution->is_published ? 'eye-slash' : 'eye' }}"></i>
                    {{ $solution->is_published ? 'Unpublish' : 'Publish' }}
                  </button>
                </form>
                <a href="{{ route('solutions.show', $solution->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-0 px-2">
                  <i class="bi bi-box-arrow-up-right"></i>
                </a>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-4">No solutions found. Run the seeder to populate.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
