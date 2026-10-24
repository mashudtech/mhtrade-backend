@extends('adminlte::page')

@section('title', 'Create New Solution')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Create New Solution</h1>
    <a href="{{ route('admin.solutions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
  </div>
@endsection

@section('content')

@if($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('admin.solutions.store') }}" enctype="multipart/form-data">
  @csrf

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card shadow-sm mb-3">
        <div class="card-header"><h3 class="card-title">Solution Overview</h3></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Supply Chain & Trade Financing" required>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="row g-2 mb-3 p-3 bg-light rounded border">
            <div class="col-12 mb-1">
              <strong class="text-dark"><i class="bi bi-hash me-1 text-primary"></i>Inquiry Reference Configuration</strong>
              <div class="text-muted small">Configure how inquiry IDs are formatted and numbered for this specific solution.</div>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Inquiry ID Prefix</label>
              <input type="text" name="inquiry_prefix" class="form-control text-uppercase @error('inquiry_prefix') is-invalid @enderror" value="{{ old('inquiry_prefix') }}" placeholder="e.g. MH-LC or MH-BANK">
              <small class="text-muted">Unique prefix (e.g. MH-LC). Leave blank to auto-generate from title.</small>
              @error('inquiry_prefix')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Starting Sequence Number <span class="text-danger">*</span></label>
              <input type="number" name="inquiry_start_number" class="form-control @error('inquiry_start_number') is-invalid @enderror" min="1" step="1" value="{{ old('inquiry_start_number', 1000) }}" required>
              <small class="text-muted">Initial sequence number for inquiries (e.g. 1000, 3000, 5000). Starts from at least this number.</small>
              @error('inquiry_start_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Page Hero Headline (Line 1)</label>
              <input type="text" name="hero_headline" class="form-control @error('hero_headline') is-invalid @enderror" value="{{ old('hero_headline') }}" placeholder="e.g. Global Supply Chain &amp;">
              @error('hero_headline')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-warning-emphasis"><i class="bi bi-stars me-1 text-warning"></i>Gold Highlight Accent (Line 2)</label>
              <input type="text" name="hero_headline_accent" class="form-control border-warning @error('hero_headline_accent') is-invalid @enderror" value="{{ old('hero_headline_accent') }}" placeholder="e.g. Trade Financing">
              @error('hero_headline_accent')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <small class="text-muted"><i class="bi bi-info-circle me-1"></i>No HTML required. Line 1 displays in white, and Line 2 automatically displays below it in the signature gold accent color.</small>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Badge / Instrument Tags <small class="text-muted">(comma-separated)</small></label>
            <input type="text" name="badge" class="form-control @error('badge') is-invalid @enderror" value="{{ old('badge') }}" placeholder="e.g. Trade Credit, Factoring, Receivables">
            @error('badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Short Description <span class="text-danger">*</span></label>
            <textarea name="short_desc" class="form-control @error('short_desc') is-invalid @enderror" rows="2" placeholder="Brief summary of this vertical shown on home cards..." required>{{ old('short_desc') }}</textarea>
            @error('short_desc')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Overview <span class="text-danger">*</span></label>
            <textarea name="overview" class="form-control rich-editor @error('overview') is-invalid @enderror" data-height="240" rows="5" placeholder="Detailed framework and operational breakdown..." required>{{ old('overview') }}</textarea>
            @error('overview')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Process Text <small class="text-muted">(italic quote block)</small></label>
            <textarea name="process_text" class="form-control rich-editor" data-height="150" rows="2" placeholder="e.g. Transaction assessment is conducted under international ICC standards...">{{ old('process_text') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Highlight Banner <small class="text-muted">(gold callout)</small></label>
            <input type="text" name="highlight_banner" class="form-control" value="{{ old('highlight_banner') }}" placeholder="e.g. Swift MT700 / MT760 banking allocation available">
          </div>
        </div>
      </div>

      <!-- Simplified Solution Items: Image + Title + Description -->
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <h3 class="card-title fw-bold mb-0">Solution Items / Breakdown Cards</h3>
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary" id="add-solution-item">
            <i class="bi bi-plus-lg"></i> Add Item
          </button>
        </div>
        <div class="card-body">
          <input type="hidden" name="items_form_submitted" value="1">
          <p class="text-muted small">Add individual capability breakdown items. Each card displays an <strong>Image</strong>, <strong>Title</strong>, and <strong>Description</strong>.</p>
          <div id="solution-items">
            <!-- Items will be populated by clicking 'Add Item' or old input -->
          </div>

          <template id="solution-item-template">
            <div class="solution-item-row border rounded p-3 mb-3 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <strong class="item-position text-primary"></strong>
                <div class="d-flex gap-1">
                  <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" data-item-action="up" aria-label="Move item up" title="Move up">
                    <i class="bi bi-arrow-up"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" data-item-action="down" aria-label="Move item down" title="Move down">
                    <i class="bi bi-arrow-down"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" data-item-action="remove" title="Remove item">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>
              <div class="row g-2 align-items-start">
                <div class="col-md-3">
                  <label class="form-label fw-semibold small mb-1">Item Image</label>
                  <div class="d-flex flex-column align-items-center border rounded p-2 bg-white">
                    <img class="item-img-preview rounded mb-2 border" src="{{ asset('images/hero/dubai_hero_bg.webp') }}" style="width: 100%; height: 80px; object-fit: cover;">
                    <input type="file" data-item-field="image_file" class="form-control form-control-sm item-file-input" accept="image/*">
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="mb-2">
                    <label class="form-label fw-semibold small mb-1">Title <span class="text-danger">*</span></label>
                    <input type="text" data-item-field="title" class="form-control form-control-sm" placeholder="Item title" required>
                  </div>
                  <div>
                    <label class="form-label fw-semibold small mb-1">Description <span class="text-danger">*</span></label>
                    <textarea data-item-field="desc" class="form-control form-control-sm" rows="3" placeholder="Brief description of this capability/instrument item..." required></textarea>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Featured Image Card -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-image me-2 text-primary"></i>Featured Banner Image</h3>
        </div>
        <div class="card-body">
          <div class="mb-3 text-center">
            <img id="solution-image-preview" src="{{ asset('images/hero/dubai_hero_bg.webp') }}" alt="Preview" class="img-fluid rounded border shadow-sm" style="max-height: 180px; width: 100%; object-fit: cover;">
          </div>
          <div class="mb-2">
            <label class="form-label small fw-semibold">Upload Banner Image</label>
            <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*" onchange="if(this.files && this.files[0]){var r=new FileReader();r.onload=function(e){document.getElementById('solution-image-preview').src=e.target.result;};r.readAsDataURL(this.files[0]);}">
            <small class="text-muted">JPG, PNG, WebP up to 10MB</small>
          </div>
        </div>
      </div>

      <!-- Optional Custom URL Slug -->
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-light"><h3 class="card-title fw-bold text-dark">URL Slug</h3></div>
        <div class="card-body">
          <label class="form-label small fw-semibold">Custom Slug (Optional)</label>
          <input type="text" name="slug" class="form-control form-control-sm" value="{{ old('slug') }}" placeholder="Auto-generated if left blank">
          <small class="text-muted">e.g. <code>supply-chain-finance</code></small>
        </div>
      </div>

      <div class="card shadow-sm sticky-top" style="top: 70px;">
        <div class="card-header"><h3 class="card-title">Save &amp; Publish</h3></div>
        <div class="card-body">
          <p class="text-muted small mb-3">The solution will be published immediately upon saving and appear on the homepage and solutions directory.</p>
          <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle me-1"></i> Create Solution</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  (() => {
    const itemList = document.getElementById('solution-items');
    const itemTemplate = document.getElementById('solution-item-template');

    function updateItemRows() {
      const rows = [...itemList.querySelectorAll('.solution-item-row')];

      rows.forEach((row, index) => {
        row.querySelector('.item-position').textContent = `Item ${index + 1}`;
        row.querySelectorAll('[data-item-field]').forEach((field) => {
          field.name = `items[${index}][${field.dataset.itemField}]`;
        });
        row.querySelector('[data-item-action="up"]').disabled = index === 0;
        row.querySelector('[data-item-action="down"]').disabled = index === rows.length - 1;
      });
    }

    document.getElementById('add-solution-item').addEventListener('click', () => {
      itemList.append(itemTemplate.content.cloneNode(true));
      updateItemRows();
      itemList.lastElementChild.querySelector('[data-item-field="title"]').focus();
    });

    itemList.addEventListener('click', (event) => {
      const button = event.target.closest('[data-item-action]');
      if (!button) return;

      const row = button.closest('.solution-item-row');
      if (button.dataset.itemAction === 'remove') {
        row.remove();
      } else if (button.dataset.itemAction === 'up' && row.previousElementSibling) {
        itemList.insertBefore(row, row.previousElementSibling);
      } else if (button.dataset.itemAction === 'down' && row.nextElementSibling) {
        itemList.insertBefore(row.nextElementSibling, row);
      }

      updateItemRows();
    });

    itemList.addEventListener('change', (event) => {
      const input = event.target.closest('.item-file-input');
      if (input && input.files && input.files[0]) {
        const preview = input.closest('.solution-item-row').querySelector('.item-img-preview');
        if (preview) {
          const reader = new FileReader();
          reader.onload = (e) => { preview.src = e.target.result; };
          reader.readAsDataURL(input.files[0]);
        }
      }
    });

    // Add 1 default empty item row initially
    itemList.append(itemTemplate.content.cloneNode(true));
    updateItemRows();
  })();
</script>
@endsection
