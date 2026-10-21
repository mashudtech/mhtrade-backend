@extends('adminlte::page')

@section('title', 'Solutions Management')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Solutions Management</h1>
    <a href="{{ route('admin.solutions.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg me-1"></i> Add New Solution
    </a>
  </div>
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
            <th>Items</th>
            <th>Badge / Tags</th>
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
            <td>
              <span class="badge text-bg-light border">{{ $solution->items_count ?? $solution->items->count() }} items</span>
            </td>
            <td><small class="text-muted">{{ Str::limit($solution->badge, 40) }}</small></td>
            <td>
              @if($solution->is_published)
                <span class="badge text-bg-success">Published</span>
              @else
                <span class="badge text-bg-secondary">Unpublished</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1 align-items-center">
                <a href="{{ route('admin.solutions.edit', $solution) }}" class="btn btn-sm btn-outline-primary py-0 px-2" title="Edit Solution">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <form method="POST" action="{{ route('admin.solutions.toggle', $solution) }}" class="d-inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-{{ $solution->is_published ? 'warning' : 'success' }} py-0 px-2" title="{{ $solution->is_published ? 'Unpublish' : 'Publish' }}">
                    <i class="bi bi-{{ $solution->is_published ? 'eye-slash' : 'eye' }}"></i>
                    {{ $solution->is_published ? 'Unpublish' : 'Publish' }}
                  </button>
                </form>
                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-delete-solution"
                  data-bs-toggle="modal" data-bs-target="#deleteSolutionModal"
                  data-id="{{ $solution->id }}"
                  data-title="{{ $solution->title }}"
                  data-items-count="{{ $solution->items_count ?? $solution->items->count() }}"
                  data-url="{{ route('admin.solutions.destroy', $solution) }}"
                  title="Delete Solution">
                  <i class="bi bi-trash"></i> Delete
                </button>
                <a href="{{ route('solutions.show', $solution->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-0 px-2" title="View Public Page">
                  <i class="bi bi-box-arrow-up-right"></i>
                </a>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center text-muted py-4">No solutions found. Click "Add New Solution" to create one.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal with explicit warning about solution items -->
<div class="modal fade" id="deleteSolutionModal" tabindex="-1" aria-labelledby="deleteSolutionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteSolutionModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Delete Solution Warning</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteSolutionForm" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="modal-body p-4 text-center">
          <div class="text-danger mb-3">
            <i class="bi bi-trash3-fill" style="font-size: 3rem;"></i>
          </div>
          <h5 class="fw-bold mb-2">Are you sure you want to delete this solution?</h5>
          <p class="text-muted mb-3">
            You are about to delete: <br>
            <strong class="text-dark fs-5" id="deleteModalSolutionTitle"></strong>
          </p>
          <div class="alert alert-warning text-start py-2 px-3 small">
            <i class="bi bi-exclamation-circle-fill me-1 text-danger"></i>
            <strong>Important:</strong> Deleting this solution will automatically and permanently delete all <strong id="deleteModalItemsCount">0</strong> associated solution item(s) and uploaded image files. This action cannot be reversed.
          </div>
          <p class="small text-secondary mb-0">Please confirm if you want to permanently delete this solution and its items.</p>
        </div>
        <div class="modal-footer bg-light justify-content-between">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger px-4"><i class="bi bi-trash-fill me-1"></i> Yes, Delete Solution &amp; Items</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const deleteModal = document.getElementById('deleteSolutionModal');
  const deleteForm = document.getElementById('deleteSolutionForm');
  const titleEl = document.getElementById('deleteModalSolutionTitle');
  const countEl = document.getElementById('deleteModalItemsCount');

  document.querySelectorAll('.btn-delete-solution').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const url = this.getAttribute('data-url');
      const title = this.getAttribute('data-title');
      const count = this.getAttribute('data-items-count') || '0';

      if (deleteForm) deleteForm.action = url;
      if (titleEl) titleEl.textContent = title;
      if (countEl) countEl.textContent = count;
    });
  });
});
</script>
@endpush
