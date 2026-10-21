@extends('adminlte::page')

@section('title', 'Add New Hero Slide')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h1 class="m-0">Add New Hero Slide</h1>
      <small class="text-muted">Create a new slide item for the homepage viewport slider.</small>
    </div>
    <a href="{{ route('admin.slides.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-1"></i> Back to Slides
    </a>
  </div>
@endsection

@section('content')

@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <strong><i class="bi bi-exclamation-triangle me-2"></i>Please correct the following errors:</strong>
    <ul class="mb-0 mt-2">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<form method="POST" action="{{ route('admin.slides.store') }}" enctype="multipart/form-data">
  @csrf

  <div class="row">
    <!-- Left Column: Content Details -->
    <div class="col-lg-8">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
          <h5 class="card-title mb-0 fw-bold"><i class="bi bi-fonts me-2"></i>Slide Content</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Hero Tag / Category Badge</label>
            <input type="text" name="tag" class="form-control" value="{{ old('tag') }}" placeholder="e.g. Trade Finance • Banking Instruments • Project Finance">
            <div class="form-text">Small uppercase tag badge displayed above the main headline.</div>
          </div>

          <div class="row">
            <div class="col-md-7 mb-3">
              <label class="form-label fw-bold">Headline Main Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="e.g. Structured Trade Finance &amp;">
            </div>
            <div class="col-md-5 mb-3">
              <label class="form-label fw-bold">Title Accent (Gold Highlight)</label>
              <input type="text" name="title_accent" class="form-control" value="{{ old('title_accent') }}" placeholder="e.g. Capital Solutions">
              <div class="form-text">Rendered with the signature gold gradient effect.</div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Subtitle / Description</label>
            <textarea name="subtitle" class="form-control" rows="3" placeholder="Connecting Real Transactions with the Right Financial Solutions&#10;Dubai-Based | 40+ Banking Relationships Worldwide">{{ old('subtitle') }}</textarea>
            <div class="form-text">Appears directly beneath the headline. Multiple lines supported.</div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold">Button Text</label>
              <input type="text" name="button_text" class="form-control" value="{{ old('button_text', 'Submit Requirement') }}">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold">Inquiry Form Vertical</label>
              <select name="button_vertical" class="form-select">
                <option value="general" {{ old('button_vertical') == 'general' ? 'selected' : '' }}>General Business Inquiry</option>
                <option value="lc" {{ old('button_vertical') == 'lc' ? 'selected' : '' }}>Trade Finance (LC / SBLC / UPAS)</option>
                <option value="uae-banking" {{ old('button_vertical') == 'uae-banking' ? 'selected' : '' }}>UAE Corporate Banking</option>
                <option value="project" {{ old('button_vertical') == 'project' ? 'selected' : '' }}>Project Finance</option>
                <option value="commodity" {{ old('button_vertical') == 'commodity' ? 'selected' : '' }}>Commodity Trade Solutions</option>
              </select>
              <div class="form-text">Pre-selects this trade vertical in the popup form.</div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold">Custom URL (Optional)</label>
              <input type="text" name="button_link" class="form-control" value="{{ old('button_link') }}" placeholder="e.g. #requirement-ingestion or /about-us">
              <div class="form-text">Leave blank to open the inquiry modal popup.</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Background Image & Settings -->
    <div class="col-lg-4">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
          <h5 class="card-title mb-0 fw-bold"><i class="bi bi-image me-2"></i>Background Image</h5>
        </div>
        <div class="card-body">
          <div class="mb-3 text-center">
            <img id="bgPreview" src="{{ asset('images/hero/dubai_hero_bg_2k.webp') }}" alt="Preview" class="img-fluid rounded border shadow-sm mb-2" style="max-height:180px; width:100%; object-fit:cover;">
            <div class="small text-muted mb-2">High resolution WebP / JPG recommended (1920x1080 or 2560x1440).</div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Upload Background Image</label>
            <input type="file" name="image_file" class="form-control" accept="image/*" onchange="previewImage(this, 'bgPreview')">
          </div>
        </div>
      </div>

      <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
          <h5 class="card-title mb-0 fw-bold"><i class="bi bi-gear me-2"></i>Publishing Settings</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Slide Order Index</label>
            <input type="number" name="order_index" class="form-control" value="{{ old('order_index', $nextOrder) }}" min="1">
            <div class="form-text">Lower numbers appear first in the viewport slider.</div>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="is_active">Active &amp; Published in Slider</label>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-check-lg me-1"></i> Save Hero Slide
          </button>
        </div>
      </div>
    </div>
  </div>
</form>

@push('js')
<script>
  function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(previewId).src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush

@endsection
