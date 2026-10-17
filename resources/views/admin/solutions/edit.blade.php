@extends('adminlte::page')

@section('title', 'Edit Solution: ' . $solution->title)

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Edit: {{ $solution->title }}</h1>
    <a href="{{ route('admin.solutions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
  </div>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

@if($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('admin.solutions.update', $solution) }}" enctype="multipart/form-data">
  @csrf @method('PUT')

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card shadow-sm mb-3">
        <div class="card-header"><h3 class="card-title">Solution Overview</h3></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $solution->title) }}" required>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          @php
            $rawHeroHeadline = $solution->hero_headline ?? '';
            $currentMain = $rawHeroHeadline;
            $currentAccent = '';
            if (preg_match('/^(.*?)(?:<br\s*\/?>|\n)?<span[^>]*>(.*?)<\/span>/is', $rawHeroHeadline, $m)) {
                $currentMain = trim(strip_tags($m[1]));
                $currentAccent = trim(strip_tags($m[2]));
            }
          @endphp

          <div class="row g-2 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Page Hero Headline (Line 1)</label>
              <input type="text" name="hero_headline" class="form-control @error('hero_headline') is-invalid @enderror" value="{{ old('hero_headline', $currentMain) }}" placeholder="e.g. Structured Trade Finance &amp;">
              @error('hero_headline')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-warning-emphasis"><i class="bi bi-stars me-1 text-warning"></i>Gold Highlight Accent (Line 2)</label>
              <input type="text" name="hero_headline_accent" class="form-control border-warning @error('hero_headline_accent') is-invalid @enderror" value="{{ old('hero_headline_accent', $currentAccent) }}" placeholder="e.g. Banking Instruments">
              @error('hero_headline_accent')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <small class="text-muted"><i class="bi bi-info-circle me-1"></i>No HTML code required! Line 1 displays in white and Line 2 automatically displays below it in the signature gold accent color.</small>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Badge / Instrument Tags <span class="text-danger">*</span> <small class="text-muted">(comma-separated)</small></label>
            <input type="text" name="badge" class="form-control @error('badge') is-invalid @enderror" value="{{ old('badge', $solution->badge) }}" required>
            @error('badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Short Description <span class="text-danger">*</span></label>
            <textarea name="short_desc" class="form-control @error('short_desc') is-invalid @enderror" rows="2" required>{{ old('short_desc', $solution->short_desc) }}</textarea>
            @error('short_desc')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Overview <span class="text-danger">*</span></label>
            <textarea name="overview" class="form-control rich-editor @error('overview') is-invalid @enderror" data-height="240" rows="5" required>{{ old('overview', $solution->overview) }}</textarea>
            @error('overview')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Process Text <small class="text-muted">(italic quote block)</small></label>
            <textarea name="process_text" class="form-control rich-editor" data-height="150" rows="2">{{ old('process_text', $solution->process_text) }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Highlight Banner <small class="text-muted">(gold callout)</small></label>
            <input type="text" name="highlight_banner" class="form-control" value="{{ old('highlight_banner', $solution->highlight_banner) }}">
          </div>
        </div>
      </div>

      @php
        $solutionItems = old('items_form_submitted')
            ? old('items', [])
            : $solution->items->map(fn ($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'subtitle' => $item->subtitle,
                'desc' => $item->desc,
                'details' => $item->details,
                'summary' => $item->summary,
            ])->all();
        $solutionItems = is_array($solutionItems) ? array_values(array_filter($solutionItems, 'is_array')) : [];
        $solutionItems = array_map(fn ($item) => array_map(
            fn ($value) => is_scalar($value) ? $value : '',
            $item
        ), $solutionItems);
      @endphp

      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Solution Items / Instruments</h3>
          <button type="button" class="btn btn-sm btn-outline-primary" id="add-solution-item">
            <i class="bi bi-plus-lg"></i> Add Item
          </button>
        </div>
        <div class="card-body">
          <input type="hidden" name="items_form_submitted" value="1">
          <p class="text-muted small">Use the arrow controls to set the order items appear on the public solution page.</p>
          <div id="solution-items">
          @foreach($solutionItems as $i => $itemData)
          <div class="solution-item-row border rounded p-3 mb-3 bg-light">
            @if(!empty($itemData['id']))
              <input type="hidden" name="items[{{ $i }}][id]" value="{{ $itemData['id'] }}" data-item-field="id">
            @endif
            <div class="d-flex justify-content-between align-items-center mb-2">
              <strong class="item-position">Item {{ $i + 1 }}</strong>
              <div class="d-flex gap-1">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-item-action="up" aria-label="Move item up" title="Move up">
                  <i class="bi bi-arrow-up"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-item-action="down" aria-label="Move item down" title="Move down">
                  <i class="bi bi-arrow-down"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" data-item-action="remove">
                  <i class="bi bi-trash"></i> Remove
                </button>
              </div>
            </div>
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label fw-semibold small">Title *</label>
                <input type="text" name="items[{{ $i }}][title]" data-item-field="title" class="form-control form-control-sm" value="{{ $itemData['title'] ?? '' }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold small">Subtitle *</label>
                <input type="text" name="items[{{ $i }}][subtitle]" data-item-field="subtitle" class="form-control form-control-sm" value="{{ $itemData['subtitle'] ?? '' }}" required>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold small">Description *</label>
                <textarea name="items[{{ $i }}][desc]" data-item-field="desc" class="form-control form-control-sm" rows="2" required>{{ $itemData['desc'] ?? '' }}</textarea>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold small">Details</label>
                <textarea name="items[{{ $i }}][details]" data-item-field="details" class="form-control form-control-sm" rows="2">{{ $itemData['details'] ?? '' }}</textarea>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold small">Summary *</label>
                <textarea name="items[{{ $i }}][summary]" data-item-field="summary" class="form-control form-control-sm" rows="1" required>{{ $itemData['summary'] ?? '' }}</textarea>
              </div>
            </div>
          </div>
          @endforeach
          </div>

          <template id="solution-item-template">
            <div class="solution-item-row border rounded p-3 mb-3 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <strong class="item-position"></strong>
                <div class="d-flex gap-1">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-item-action="up" aria-label="Move item up" title="Move up">
                    <i class="bi bi-arrow-up"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-item-action="down" aria-label="Move item down" title="Move down">
                    <i class="bi bi-arrow-down"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-danger" data-item-action="remove">
                    <i class="bi bi-trash"></i> Remove
                  </button>
                </div>
              </div>
              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-label fw-semibold small">Title *</label>
                  <input type="text" data-item-field="title" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold small">Subtitle *</label>
                  <input type="text" data-item-field="subtitle" class="form-control form-control-sm" required>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold small">Description *</label>
                  <textarea data-item-field="desc" class="form-control form-control-sm" rows="2" required></textarea>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold small">Details</label>
                  <textarea data-item-field="details" class="form-control form-control-sm" rows="2"></textarea>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold small">Summary *</label>
                  <textarea data-item-field="summary" class="form-control form-control-sm" rows="1" required></textarea>
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
          <h3 class="card-title fw-bold text-dark"><i class="bi bi-image me-2 text-primary"></i>Featured Image</h3>
        </div>
        <div class="card-body">
          <div class="mb-3 text-center">
            <img id="solution-image-preview" src="{{ $solution->image_url }}" alt="{{ $solution->title }}" class="img-fluid rounded border shadow-sm" style="max-height: 180px; width: 100%; object-fit: cover;">
          </div>
          <div class="mb-2">
            <label class="form-label small fw-semibold">Upload New Image</label>
            <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*" onchange="if(this.files && this.files[0]){var r=new FileReader();r.onload=function(e){document.getElementById('solution-image-preview').src=e.target.result;};r.readAsDataURL(this.files[0]);}">
            <small class="text-muted">JPG, PNG, WebP up to 10MB</small>
          </div>
          <small class="text-muted d-block mt-2">Active path: <code>{{ $solution->image ?: 'Default' }}</code></small>
        </div>
      </div>

      <div class="card shadow-sm sticky-top" style="top: 70px;">
        <div class="card-header"><h3 class="card-title">Publication</h3></div>
        <div class="card-body">
          <p class="text-muted small mb-2">Slug: <code>{{ $solution->slug }}</code></p>
          <p class="text-muted small mb-3">Status: <span class="badge text-bg-{{ $solution->is_published ? 'success' : 'secondary' }}">{{ $solution->is_published ? 'Published' : 'Unpublished' }}</span></p>
          <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Save Changes</button>
          <a href="{{ route('solutions.show', $solution->slug) }}" target="_blank" class="btn btn-outline-secondary w-100 mt-2"><i class="bi bi-box-arrow-up-right"></i> Preview on Site</a>
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

    updateItemRows();
  })();
</script>
@endsection
