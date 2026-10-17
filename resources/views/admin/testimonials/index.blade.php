@extends('adminlte::page')

@section('title', 'Testimonials Management')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Testimonials</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg me-1"></i> Add Testimonial
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

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 50px;">Order</th>
            <th>Client</th>
            <th>Company & Position</th>
            <th>Deal Size / Badge</th>
            <th>Quote Preview</th>
            <th>Status</th>
            <th style="width: 140px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($testimonials as $t)
          <tr>
            <td><span class="badge text-bg-light border">{{ $t->sort_order }}</span></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem;">
                  {{ $t->initials ?: substr($t->name, 0, 2) }}
                </div>
                <div>
                  <strong>{{ $t->name }}</strong>
                </div>
              </div>
            </td>
            <td>
              <div>{{ $t->position }}</div>
              <small class="text-muted">{{ $t->company }}</small>
            </td>
            <td>
              @if($t->deal_size)
                <span class="badge text-bg-info text-dark mb-1">{{ $t->deal_size }}</span><br>
              @endif
              @if($t->badge)
                <span class="badge text-bg-secondary">{{ $t->badge }}</span>
              @endif
            </td>
            <td>
              <small class="text-muted" title="{{ $t->quote }}">
                {{ Str::limit($t->quote, 70) }}
              </small>
            </td>
            <td>
              @if($t->is_published)
                <span class="badge text-bg-success">Published</span>
              @else
                <span class="badge text-bg-secondary">Draft</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-outline-primary py-0 px-2">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this testimonial?');" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center text-muted py-4">No testimonials found. Click "Add Testimonial" to create one.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
