@extends('adminlte::page')

@section('title', 'Manage Why MH Page Content')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Why MH Page Content</h1>
    <a href="{{ route('why-mh') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-box-arrow-up-right me-1"></i> Preview Live Page
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

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.pages.why-mh.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="row g-3">
    <!-- Left Column: Content Cards -->
    <div class="col-lg-8">

      <!-- 1. Hero Section -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-image me-2 text-primary"></i>1. Hero Banner</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Hero Tag / Badge</label>
            <input type="text" name="settings[why_hero_tag]" class="form-control" value="{{ old('settings.why_hero_tag', $settings['why_hero_tag'] ?? '') }}">
          </div>

          @php
            $rawWhyHeroTitle = $settings['why_hero_title'] ?? '';
            $currentWhyAccent = $settings['why_hero_title_accent'] ?? '';
            $currentWhyMain = $rawWhyHeroTitle;
            if (empty($currentWhyAccent) && preg_match('/^(.*?)(?:<br\s*\/?>|\n)?<span[^>]*>(.*?)<\/span>/is', $rawWhyHeroTitle, $m)) {
                $currentWhyMain = trim(strip_tags($m[1]));
                $currentWhyAccent = trim(strip_tags($m[2]));
            }
          @endphp

          <div class="row g-2 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Hero Main Title (Line 1)</label>
              <input type="text" name="settings[why_hero_title]" class="form-control" value="{{ old('settings.why_hero_title', $currentWhyMain) }}" placeholder="e.g. Why MH Trade Capital Solutions">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-warning-emphasis"><i class="bi bi-stars me-1 text-warning"></i>Gold Highlight Accent (Line 2)</label>
              <input type="text" name="settings[why_hero_title_accent]" class="form-control border-warning" value="{{ old('settings.why_hero_title_accent', $currentWhyAccent) }}" placeholder="e.g. Dubai Gateway & Execution Philosophy">
            </div>
            <div class="col-12">
              <small class="text-muted"><i class="bi bi-info-circle me-1"></i>No HTML tags needed! The second line automatically renders in gold accent style.</small>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Hero Description</label>
            <textarea name="settings[why_hero_desc]" rows="3" class="form-control">{{ old('settings.why_hero_desc', $settings['why_hero_desc'] ?? '') }}</textarea>
          </div>
        </div>
      </div>

      <!-- 2. Core Pillars -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-diagram-3 me-2 text-primary"></i>2. 4 Strategic Pillars</h3>
        </div>
        <div class="card-body">
          <div class="row g-2 mb-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Section Subtitle</label>
              <input type="text" name="settings[why_pillars_subtitle]" class="form-control" value="{{ old('settings.why_pillars_subtitle', $settings['why_pillars_subtitle'] ?? '') }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-semibold">Section Heading</label>
              <input type="text" name="settings[why_pillars_title]" class="form-control" value="{{ old('settings.why_pillars_title', $settings['why_pillars_title'] ?? '') }}">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Introduction Overview Description</label>
            <textarea name="settings[why_pillars_desc]" rows="2" class="form-control rich-editor" data-height="160">{{ old('settings.why_pillars_desc', $settings['why_pillars_desc'] ?? '') }}</textarea>
          </div>

          <hr>

          <div class="row g-3">
            <div class="col-md-6 border-end">
              <h6 class="fw-bold text-primary mb-2">01 — Pillar</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_p1_title]" class="form-control" value="{{ old('settings.why_p1_title', $settings['why_p1_title'] ?? '') }}">
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_p1_desc]" rows="2" class="form-control rich-editor" data-height="150">{{ old('settings.why_p1_desc', $settings['why_p1_desc'] ?? '') }}</textarea>
              </div>

              <h6 class="fw-bold text-primary mb-2">03 — Pillar</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_p3_title]" class="form-control" value="{{ old('settings.why_p3_title', $settings['why_p3_title'] ?? '') }}">
              </div>
              <div>
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_p3_desc]" rows="2" class="form-control rich-editor" data-height="150">{{ old('settings.why_p3_desc', $settings['why_p3_desc'] ?? '') }}</textarea>
              </div>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-primary mb-2">02 — Pillar</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_p2_title]" class="form-control" value="{{ old('settings.why_p2_title', $settings['why_p2_title'] ?? '') }}">
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_p2_desc]" rows="2" class="form-control rich-editor" data-height="150">{{ old('settings.why_p2_desc', $settings['why_p2_desc'] ?? '') }}</textarea>
              </div>

              <h6 class="fw-bold text-primary mb-2">04 — Pillar</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_p4_title]" class="form-control" value="{{ old('settings.why_p4_title', $settings['why_p4_title'] ?? '') }}">
              </div>
              <div>
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_p4_desc]" rows="2" class="form-control rich-editor" data-height="150">{{ old('settings.why_p4_desc', $settings['why_p4_desc'] ?? '') }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. Why Dubai Advantages -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-geo-alt me-2 text-primary"></i>3. Why Dubai Advantage</h3>
        </div>
        <div class="card-body">
          <div class="row g-2 mb-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Subtitle</label>
              <input type="text" name="settings[why_dubai_subtitle]" class="form-control" value="{{ old('settings.why_dubai_subtitle', $settings['why_dubai_subtitle'] ?? '') }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-semibold">Heading</label>
              <input type="text" name="settings[why_dubai_title]" class="form-control" value="{{ old('settings.why_dubai_title', $settings['why_dubai_title'] ?? '') }}">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Intro Description</label>
            <textarea name="settings[why_dubai_desc]" rows="2" class="form-control rich-editor" data-height="160">{{ old('settings.why_dubai_desc', $settings['why_dubai_desc'] ?? '') }}</textarea>
          </div>

          <hr>

          <div class="row g-3">
            <div class="col-md-6 border-end">
              <h6 class="fw-bold text-success mb-2">Advantage 1: Global Connectivity</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_adv1_title]" class="form-control" value="{{ old('settings.why_adv1_title', $settings['why_adv1_title'] ?? '') }}">
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_adv1_desc]" rows="2" class="form-control rich-editor" data-height="140">{{ old('settings.why_adv1_desc', $settings['why_adv1_desc'] ?? '') }}</textarea>
              </div>

              <h6 class="fw-bold text-success mb-2">Advantage 3: Strategic Location</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_adv3_title]" class="form-control" value="{{ old('settings.why_adv3_title', $settings['why_adv3_title'] ?? '') }}">
              </div>
              <div>
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_adv3_desc]" rows="2" class="form-control rich-editor" data-height="140">{{ old('settings.why_adv3_desc', $settings['why_adv3_desc'] ?? '') }}</textarea>
              </div>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-success mb-2">Advantage 2: Business Infrastructure</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_adv2_title]" class="form-control" value="{{ old('settings.why_adv2_title', $settings['why_adv2_title'] ?? '') }}">
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_adv2_desc]" rows="2" class="form-control rich-editor" data-height="140">{{ old('settings.why_adv2_desc', $settings['why_adv2_desc'] ?? '') }}</textarea>
              </div>

              <h6 class="fw-bold text-success mb-2">Advantage 4: International Business Environment</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[why_adv4_title]" class="form-control" value="{{ old('settings.why_adv4_title', $settings['why_adv4_title'] ?? '') }}">
              </div>
              <div>
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[why_adv4_desc]" rows="2" class="form-control rich-editor" data-height="140">{{ old('settings.why_adv4_desc', $settings['why_adv4_desc'] ?? '') }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 4. Bottom CTA -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-megaphone me-2 text-primary"></i>4. Bottom Call To Action</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">CTA Banner Title</label>
            <input type="text" name="settings[why_cta_title]" class="form-control" value="{{ old('settings.why_cta_title', $settings['why_cta_title'] ?? '') }}">
          </div>
          <div>
            <label class="form-label fw-semibold">CTA Banner Description</label>
            <textarea name="settings[why_cta_desc]" rows="2" class="form-control">{{ old('settings.why_cta_desc', $settings['why_cta_desc'] ?? '') }}</textarea>
          </div>
        </div>
      </div>

    </div>

    <!-- Right Column: Sticky Action Box -->
    <div class="col-lg-4">

      <!-- Feature Image Card -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-image me-2 text-primary"></i>Why MH Banner Image</h3>
        </div>
        <div class="card-body">
          <div class="mb-3 text-center">
            <img id="why-image-preview" src="{{ content_image_url($settings['why_image'] ?? null, 'images/hero/dubai_hero_bg.webp') }}" alt="Why MH Banner Image" class="img-fluid rounded border shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
          </div>
          <div class="mb-2">
            <label class="form-label small fw-semibold">Upload New Image</label>
            <input type="file" name="why_image_file" class="form-control form-control-sm" accept="image/*" onchange="if(this.files && this.files[0]){var r=new FileReader();r.onload=function(e){document.getElementById('why-image-preview').src=e.target.result;};r.readAsDataURL(this.files[0]);}">
            <small class="text-muted">JPG, PNG, WebP up to 10MB</small>
          </div>
          <small class="text-muted d-block mt-2">Active path: <code>{{ $settings['why_image'] ?? 'images/hero/dubai_hero_bg.webp' }}</code></small>
        </div>
      </div>

      <div class="card shadow-sm sticky-top" style="top: 20px;">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title fw-bold"><i class="bi bi-floppy me-1"></i> Save Changes</h3>
        </div>
        <div class="card-body">
          <p class="text-muted small">
            Saving here updates the public <strong>Why MH</strong> page immediately. All changes are cached and served instantaneously.
          </p>
          <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-check-lg me-1"></i> Update Why MH Page
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
