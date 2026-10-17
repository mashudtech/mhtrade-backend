@extends('adminlte::page')

@section('title', 'Add Testimonial')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Add Testimonial</h1>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-1"></i> Back to Testimonials
    </a>
  </div>
@endsection

@section('content')

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.testimonials.store') }}">
  @csrf

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card shadow-sm mb-3">
        <div class="card-header"><h3 class="card-title">Testimonial Details</h3></div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-3">
              <label class="form-label fw-semibold">Initials <span class="text-danger">*</span></label>
              <input type="text" name="initials" class="form-control @error('initials') is-invalid @enderror" value="{{ old('initials') }}" maxlength="5" placeholder="e.g. MK" required>
              @error('initials')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-9">
              <label class="form-label fw-semibold">Client Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Full Name" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
              <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" placeholder="e.g. Managing Director" required>
              @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Company <span class="text-danger">*</span></label>
              <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}" placeholder="e.g. Global Agri Commodities" required>
              @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Deal Size <small class="text-muted">(optional)</small></label>
              <input type="text" name="deal_size" class="form-control @error('deal_size') is-invalid @enderror" value="{{ old('deal_size') }}" placeholder="e.g. $4.2M SBLC Facility">
              @error('deal_size')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Badge / Instrument <small class="text-muted">(optional)</small></label>
              <input type="text" name="badge" class="form-control @error('badge') is-invalid @enderror" value="{{ old('badge') }}" placeholder="e.g. SBLC / Agri Trade">
              @error('badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Client Quote / Testimonial <span class="text-danger">*</span></label>
            <textarea name="quote" rows="4" class="form-control rich-editor @error('quote') is-invalid @enderror" data-height="160" placeholder="Client feedback or testimonial statement..." required>{{ old('quote') }}</textarea>
            @error('quote')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card shadow-sm mb-3">
        <div class="card-header"><h3 class="card-title">Publishing</h3></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
            <small class="text-muted">Lower numbers appear first.</small>
          </div>

          <div class="form-check form-switch mb-3">
            <input type="hidden" name="is_published" value="0">
            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', '1') == '1' ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="is_published">Published on website</label>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-save me-1"></i> Save Testimonial
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
