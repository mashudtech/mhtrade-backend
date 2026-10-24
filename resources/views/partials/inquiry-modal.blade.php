<!-- Floating WhatsApp Button -->
@php
  $floatingWaLink = \App\Models\CmsSetting::getValue('whatsapp_link');
  if (empty($floatingWaLink)) {
    $rawWa = \App\Models\CmsSetting::getValue('whatsapp', '+971565837969');
    $floatingWaLink = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $rawWa);
  }
@endphp
<a href="{{ $floatingWaLink }}" target="_blank" rel="noopener noreferrer" id="floating-whatsapp" class="floating-whatsapp-btn" aria-label="Chat with us on WhatsApp" title="Chat on WhatsApp">
  <i class="fab fa-whatsapp"></i>
</a>

<!-- Floating Back to Top Button -->
<button id="back-to-top" class="back-to-top-btn" aria-label="Back to top">
  <i class="fas fa-chevron-up"></i>
</button>

<!-- Interactive Requirement Ingestion Modal Drawer -->
<div class="modal-overlay" id="inquiry-modal">
  <div class="modal-card">
    <button class="modal-close close-modal">&times;</button>

    <!-- Modal Form Container -->
    <div id="modal-form-container">
      <h2 style="font-size: 26px; margin-bottom: 6px;">Submit Trade <span style="color: var(--gold-primary);">Requirement</span></h2>
      <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Submit your requirement directly to our Dubai operational desk to receive your tracking Request ID.</p>

      <form id="inquiry-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_token" id="inquiry-csrf-token" value="{{ csrf_token() }}">

        <div class="form-group">
          <label class="form-label" for="req-vertical">Requirement Category <span class="req-star">*</span></label>
          <select class="form-control" name="vertical" id="req-vertical" required>
            @php
              $modalSolutions = \App\Models\Solution::published()->get();
            @endphp
            @foreach($modalSolutions as $mSol)
              <option value="{{ $mSol->slug }}">{{ $mSol->title }}</option>
            @endforeach
            <option value="general">General Business Inquiry</option>
          </select>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="req-name">Full Name <span class="req-star">*</span></label>
            <input type="text" class="form-control" name="name" id="req-name" placeholder="John Doe" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="req-company">Company Name <span class="req-star">*</span></label>
            <input type="text" class="form-control" name="company" id="req-company" placeholder="Global Trade Corp" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="req-email">Work Email <span class="req-star">*</span></label>
            <input type="email" class="form-control" name="email" id="req-email" placeholder="john@company.com" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="req-phone">Phone / WhatsApp</label>
            <input type="tel" class="form-control" name="phone" id="req-phone" placeholder="+971 56 583 7969">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="req-country">Country</label>
          <input type="text" class="form-control" name="country" id="req-country" placeholder="UAE, UK, India...">
        </div>

        <div class="form-group">
          <label class="form-label" for="req-details">Requirement Specifications <span class="req-star">*</span></label>
          <textarea class="form-control" name="details" id="req-details" rows="3"
            placeholder="Target instrument amount, commodity tonnage, origin/destination preferences..." required></textarea>
        </div>

        <div class="form-group">
          <label class="form-label" for="req-doc">Attach Specification PDF / Document (Optional)</label>
          <input type="file" class="form-control" name="doc" id="req-doc" accept=".pdf,.doc,.docx,.png,.jpg">
        </div>

        <div id="inquiry-error-msg" style="display:none; color:#e74c3c; font-size:13px; margin-bottom:12px;"></div>

        <button type="submit" class="btn-gold" id="inquiry-submit-btn"
          style="width: 100%; justify-content: center; height: 50px; margin-top: 10px;">
          <i class="fas fa-paper-plane"></i> Submit Requirement &amp; Receive Request ID
        </button>
      </form>
    </div>

    <!-- Modal Success Screen Container -->
    <div id="modal-success-container" style="display: none;">
      <div class="success-card">
        <div class="success-icon">
          <i class="fas fa-check"></i>
        </div>
        <h2 style="font-size: 26px; margin-bottom: 8px;">Requirement Submitted!</h2>
        <p style="color: var(--text-muted); font-size: 14px;">Your trade requirement has been assigned a unique sequential tracking ID:</p>

        <div class="id-badge-big" id="assigned-request-id">MH-LC-00001</div>

        <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 24px;">Our Dubai operational desk will review your specifications and contact you via email/WhatsApp shortly.</p>

        <button type="button" class="btn-gold close-modal" style="justify-content: center; width: 100%;">
          <i class="fas fa-check"></i> Done
        </button>
      </div>
    </div>

  </div>
</div>

<script>
// Inquiry form AJAX submission
(function () {
  const form = document.getElementById('inquiry-form');
  if (!form) return;

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const btn = document.getElementById('inquiry-submit-btn');
    const errEl = document.getElementById('inquiry-error-msg');
    errEl.style.display = 'none';
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

    try {
      const data = new FormData(form);
      const res = await fetch('{{ route("inquiry.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.getElementById('inquiry-csrf-token').value },
        body: data,
      });
      const json = await res.json();
      if (json.success) {
        document.getElementById('assigned-request-id').textContent = json.request_id;
        document.getElementById('modal-form-container').style.display = 'none';
        document.getElementById('modal-success-container').style.display = 'block';
        form.reset();
      } else {
        const msgs = json.errors ? Object.values(json.errors).flat().join(' ') : (json.message || 'Submission failed.');
        errEl.textContent = msgs;
        errEl.style.display = 'block';
      }
    } catch (err) {
      errEl.textContent = 'Network error. Please try again.';
      errEl.style.display = 'block';
    } finally {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Requirement &amp; Receive Request ID';
    }
  });
})();
</script>
