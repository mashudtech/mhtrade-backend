@extends('adminlte::page')

@section('title', 'Hero Slider Management')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Hero Slider Management</h1>
    <a href="{{ route('admin.slides.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg me-1"></i> Add New Slide
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
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:60px;">Order</th>
            <th style="width:120px;">Background</th>
            <th>Tag / Headline</th>
            <th>Subtitle Preview</th>
            <th>Button</th>
            <th>Status</th>
            <th style="width:160px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($slides as $slide)
          <tr>
            <td class="text-center fw-bold text-muted">{{ $slide->order_index }}</td>
            <td>
              <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="rounded border shadow-sm" style="width:100px; height:55px; object-fit:cover;">
            </td>
            <td>
              @if($slide->tag)
                <span class="badge bg-light text-dark border mb-1" style="font-size:11px;">{{ Str::limit($slide->tag, 40) }}</span><br>
              @endif
              <strong>{{ $slide->title }}</strong>
              @if($slide->title_accent)
                <span class="text-warning fw-bold">{{ $slide->title_accent }}</span>
              @endif
            </td>
            <td>
              <small class="text-muted">{{ Str::limit($slide->subtitle, 70) }}</small>
            </td>
            <td>
              <span class="badge bg-secondary">{{ $slide->button_text }}</span>
              @if($slide->button_vertical)
                <br><small class="text-muted">Vertical: {{ $slide->button_vertical }}</small>
              @endif
            </td>
            <td>
              @if($slide->is_active)
                <span class="badge text-bg-success">Active</span>
              @else
                <span class="badge text-bg-secondary">Inactive</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1 align-items-center">
                <a href="{{ route('admin.slides.edit', $slide) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Slide">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-delete-slide"
                  data-bs-toggle="modal" data-bs-target="#deleteSlideModal"
                  data-action="{{ route('admin.slides.destroy', $slide) }}"
                  data-title="{{ $slide->title }}"
                  title="Delete Slide">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-4 text-muted">
              No hero slides found. Click <strong>Add New Slide</strong> to create one.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Slide Deletion Confirmation Modal -->
<div class="modal fade" id="deleteSlideModal" tabindex="-1" aria-labelledby="deleteSlideModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title d-flex align-items-center gap-2" id="deleteSlideModalLabel">
          <i class="bi bi-exclamation-triangle-fill"></i> Confirm Slide Deletion
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p class="mb-2">Are you sure you want to permanently delete the slide:</p>
        <div class="p-3 bg-light rounded border mb-3">
          <strong id="deleteSlideTitle" class="text-dark"></strong>
        </div>
        <p class="text-muted small mb-0">This action cannot be undone.</p>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteSlideForm" method="POST" action="" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm">
            <i class="bi bi-trash-fill me-1"></i> Yes, Delete Slide
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteSlideModal');
    if (deleteModal) {
      deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const actionUrl = button.getAttribute('data-action');
        const title = button.getAttribute('data-title');

        document.getElementById('deleteSlideForm').action = actionUrl;
        document.getElementById('deleteSlideTitle').textContent = title || 'this slide';
      });
    }
  });
</script>
@endpush

@endsection
