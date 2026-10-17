@extends('adminlte::page')

@section('title', 'Manage About Us Page Content')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">About Us Page Content</h1>
    <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
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

<form method="POST" action="{{ route('admin.pages.about.update') }}" enctype="multipart/form-data">
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
            <input type="text" name="settings[about_hero_tag]" class="form-control" value="{{ old('settings.about_hero_tag', $settings['about_hero_tag'] ?? '') }}">
          </div>

          @php
            $rawHeroTitle = $settings['about_hero_title'] ?? '';
            $currentAccent = $settings['about_hero_title_accent'] ?? '';
            $currentMain = $rawHeroTitle;
            // Extract clean title and accent if stored with legacy HTML
            if (empty($currentAccent) && preg_match('/^(.*?)(?:<br\s*\/?>|\n)?<span[^>]*>(.*?)<\/span>/is', $rawHeroTitle, $m)) {
                $currentMain = trim(strip_tags($m[1]));
                $currentAccent = trim(strip_tags($m[2]));
            }
          @endphp

          <div class="row g-2 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Hero Main Title (Line 1)</label>
              <input type="text" name="settings[about_hero_title]" class="form-control" value="{{ old('settings.about_hero_title', $currentMain) }}" placeholder="e.g. Built Around Relationships.">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-warning-emphasis"><i class="bi bi-stars me-1 text-warning"></i>Gold Highlight Accent (Line 2)</label>
              <input type="text" name="settings[about_hero_title_accent]" class="form-control border-warning" value="{{ old('settings.about_hero_title_accent', $currentAccent) }}" placeholder="e.g. Driven by Transactions.">
            </div>
            <div class="col-12">
              <small class="text-muted"><i class="bi bi-info-circle me-1"></i>No HTML code required! The gold highlight will automatically be formatted with signature styling below Line 1.</small>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Hero Description</label>
            <textarea name="settings[about_hero_desc]" rows="3" class="form-control">{{ old('settings.about_hero_desc', $settings['about_hero_desc'] ?? '') }}</textarea>
          </div>
        </div>
      </div>

      <!-- 2. Company Introduction -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-building me-2 text-primary"></i>2. Company Introduction</h3>
        </div>
        <div class="card-body">
          <div class="row g-2 mb-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Section Subtitle</label>
              <input type="text" name="settings[about_intro_subtitle]" class="form-control" value="{{ old('settings.about_intro_subtitle', $settings['about_intro_subtitle'] ?? '') }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-semibold">Section Heading</label>
              <input type="text" name="settings[about_intro_title]" class="form-control" value="{{ old('settings.about_intro_title', $settings['about_intro_title'] ?? '') }}">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Introduction Paragraph 1</label>
            <textarea name="settings[about_intro_p1]" rows="3" class="form-control rich-editor" data-height="160">{{ old('settings.about_intro_p1', $settings['about_intro_p1'] ?? '') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Introduction Paragraph 2</label>
            <textarea name="settings[about_intro_p2]" rows="3" class="form-control rich-editor" data-height="160">{{ old('settings.about_intro_p2', $settings['about_intro_p2'] ?? '') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Focus Statement Quote</label>
            <textarea name="settings[about_focus_quote]" rows="2" class="form-control rich-editor" data-height="130">{{ old('settings.about_focus_quote', $settings['about_focus_quote'] ?? '') }}</textarea>
          </div>
        </div>
      </div>

      <!-- 3. Key Credentials & Badges -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-award me-2 text-primary"></i>3. Experience & Credentials</h3>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6 border-end">
              <h6 class="fw-bold text-secondary">Card 1 (Experience)</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[about_stat_years]" class="form-control" value="{{ old('settings.about_stat_years', $settings['about_stat_years'] ?? '') }}">
              </div>
              <div>
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[about_stat_years_desc]" rows="2" class="form-control">{{ old('settings.about_stat_years_desc', $settings['about_stat_years_desc'] ?? '') }}</textarea>
              </div>
            </div>

            <div class="col-md-6">
              <h6 class="fw-bold text-secondary">Card 2 (Banking Network)</h6>
              <div class="mb-2">
                <label class="form-label small fw-semibold">Title</label>
                <input type="text" name="settings[about_stat_banking]" class="form-control" value="{{ old('settings.about_stat_banking', $settings['about_stat_banking'] ?? '') }}">
              </div>
              <div>
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="settings[about_stat_banking_desc]" rows="2" class="form-control">{{ old('settings.about_stat_banking_desc', $settings['about_stat_banking_desc'] ?? '') }}</textarea>
              </div>
            </div>
          </div>

          <hr>

          <h6 class="fw-bold text-secondary">Floating Image Badge</h6>
          <div class="row g-2">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Line 1</label>
              <input type="text" name="settings[about_badge_years]" class="form-control" value="{{ old('settings.about_badge_years', $settings['about_badge_years'] ?? '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Line 2</label>
              <input type="text" name="settings[about_badge_desc]" class="form-control" value="{{ old('settings.about_badge_desc', $settings['about_badge_desc'] ?? '') }}">
            </div>
          </div>
        </div>
      </div>

      <!-- 4. Core Philosophy -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-compass me-2 text-primary"></i>4. Core Philosophy</h3>
        </div>
        <div class="card-body">
          <div class="row g-2 mb-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Subtitle</label>
              <input type="text" name="settings[about_philosophy_subtitle]" class="form-control" value="{{ old('settings.about_philosophy_subtitle', $settings['about_philosophy_subtitle'] ?? '') }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-semibold">Headline</label>
              <input type="text" name="settings[about_philosophy_title]" class="form-control" value="{{ old('settings.about_philosophy_title', $settings['about_philosophy_title'] ?? '') }}">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Section Description</label>
            <textarea name="settings[about_philosophy_desc]" rows="2" class="form-control">{{ old('settings.about_philosophy_desc', $settings['about_philosophy_desc'] ?? '') }}</textarea>
          </div>

          <div class="row g-3">
            <div class="col-md-6 border-end">
              <label class="form-label small fw-semibold">Philosophy Card 1 Title</label>
              <input type="text" name="settings[about_philosophy_card1_title]" class="form-control mb-2" value="{{ old('settings.about_philosophy_card1_title', $settings['about_philosophy_card1_title'] ?? '') }}">
              <label class="form-label small fw-semibold">Philosophy Card 1 Description</label>
              <textarea name="settings[about_philosophy_card1_desc]" rows="2" class="form-control">{{ old('settings.about_philosophy_card1_desc', $settings['about_philosophy_card1_desc'] ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Philosophy Card 2 Title</label>
              <input type="text" name="settings[about_philosophy_card2_title]" class="form-control mb-2" value="{{ old('settings.about_philosophy_card2_title', $settings['about_philosophy_card2_title'] ?? '') }}">
              <label class="form-label small fw-semibold">Philosophy Card 2 Description</label>
              <textarea name="settings[about_philosophy_card2_desc]" rows="2" class="form-control">{{ old('settings.about_philosophy_card2_desc', $settings['about_philosophy_card2_desc'] ?? '') }}</textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- 5. SLA Benchmarks -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-stopwatch me-2 text-primary"></i>5. Service Level Benchmarks (SLA)</h3>
        </div>
        <div class="card-body">
          <div class="row g-2 mb-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Subtitle</label>
              <input type="text" name="settings[about_sla_subtitle]" class="form-control" value="{{ old('settings.about_sla_subtitle', $settings['about_sla_subtitle'] ?? '') }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-semibold">Title</label>
              <input type="text" name="settings[about_sla_title]" class="form-control" value="{{ old('settings.about_sla_title', $settings['about_sla_title'] ?? '') }}">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <input type="text" name="settings[about_sla_desc]" class="form-control" value="{{ old('settings.about_sla_desc', $settings['about_sla_desc'] ?? '') }}">
          </div>

          <div class="row g-3">
            <div class="col-md-6 col-lg-3">
              <div class="p-2 border rounded bg-light">
                <label class="form-label small fw-bold">Box 1 Value</label>
                <input type="text" name="settings[about_sla_1_val]" class="form-control form-control-sm mb-2" value="{{ old('settings.about_sla_1_val', $settings['about_sla_1_val'] ?? '') }}">
                <label class="form-label small fw-semibold">Label</label>
                <input type="text" name="settings[about_sla_1_label]" class="form-control form-control-sm" value="{{ old('settings.about_sla_1_label', $settings['about_sla_1_label'] ?? '') }}">
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="p-2 border rounded bg-light">
                <label class="form-label small fw-bold">Box 2 Value</label>
                <input type="text" name="settings[about_sla_2_val]" class="form-control form-control-sm mb-2" value="{{ old('settings.about_sla_2_val', $settings['about_sla_2_val'] ?? '') }}">
                <label class="form-label small fw-semibold">Label</label>
                <input type="text" name="settings[about_sla_2_label]" class="form-control form-control-sm" value="{{ old('settings.about_sla_2_label', $settings['about_sla_2_label'] ?? '') }}">
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="p-2 border rounded bg-light">
                <label class="form-label small fw-bold">Box 3 Value</label>
                <input type="text" name="settings[about_sla_3_val]" class="form-control form-control-sm mb-2" value="{{ old('settings.about_sla_3_val', $settings['about_sla_3_val'] ?? '') }}">
                <label class="form-label small fw-semibold">Label</label>
                <input type="text" name="settings[about_sla_3_label]" class="form-control form-control-sm" value="{{ old('settings.about_sla_3_label', $settings['about_sla_3_label'] ?? '') }}">
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="p-2 border rounded bg-light">
                <label class="form-label small fw-bold">Box 4 Value</label>
                <input type="text" name="settings[about_sla_4_val]" class="form-control form-control-sm mb-2" value="{{ old('settings.about_sla_4_val', $settings['about_sla_4_val'] ?? '') }}">
                <label class="form-label small fw-semibold">Label</label>
                <input type="text" name="settings[about_sla_4_label]" class="form-control form-control-sm" value="{{ old('settings.about_sla_4_label', $settings['about_sla_4_label'] ?? '') }}">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 6. Disclaimer & Bottom CTA -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-shield-exclamation me-2 text-primary"></i>6. Disclaimer &amp; Bottom Action</h3>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Regulatory Disclaimer Text</label>
            <textarea name="settings[about_disclaimer]" rows="3" class="form-control rich-editor" data-height="160">{{ old('settings.about_disclaimer', $settings['about_disclaimer'] ?? '') }}</textarea>
          </div>
          <div class="row g-2">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Bottom CTA Title</label>
              <input type="text" name="settings[about_cta_title]" class="form-control" value="{{ old('settings.about_cta_title', $settings['about_cta_title'] ?? '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Bottom CTA Description</label>
              <input type="text" name="settings[about_cta_desc]" class="form-control" value="{{ old('settings.about_cta_desc', $settings['about_cta_desc'] ?? '') }}">
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Right Column: Sticky Action Box -->
    <div class="col-lg-4">

      <!-- Company Image Upload Card -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-image me-2 text-primary"></i>Company Office Image</h3>
        </div>
        <div class="card-body">
          <div class="mb-3 text-center">
            <img id="about-image-preview" src="{{ content_image_url($settings['about_image'] ?? null, 'images/about_us_dubai.webp') }}" alt="About Office Image" class="img-fluid rounded border shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
          </div>
          <div class="mb-2">
            <label class="form-label small fw-semibold">Upload New Image</label>
            <input type="file" name="about_image_file" class="form-control form-control-sm" accept="image/*" onchange="if(this.files && this.files[0]){var r=new FileReader();r.onload=function(e){document.getElementById('about-image-preview').src=e.target.result;};r.readAsDataURL(this.files[0]);}">
            <small class="text-muted">JPG, PNG, WebP up to 10MB</small>
          </div>
          <small class="text-muted d-block mt-2">Active path: <code>{{ $settings['about_image'] ?? 'images/about_us_dubai.webp' }}</code></small>
        </div>
      </div>

      <div class="card shadow-sm sticky-top" style="top: 20px;">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title fw-bold"><i class="bi bi-floppy me-1"></i> Save Changes</h3>
        </div>
        <div class="card-body">
          <p class="text-muted small">
            Saving here updates the public <strong>About Us</strong> page immediately. All changes are cached and served instantaneously.
          </p>
          <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-check-lg me-1"></i> Update About Us Page
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
