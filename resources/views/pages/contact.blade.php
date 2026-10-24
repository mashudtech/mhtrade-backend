@extends('layouts.public')

@section('title', 'Contact Us | Dubai Operational Desk — MH Trade Capital Solutions')
@section('meta_desc', 'Get in touch with MH Trade Capital Solutions in Dubai, UAE. Contact our capital desk for trade finance, banking setup, project funding, and commodity sourcing requirements.')
@section('page_hero')
<section class="page-hero-section" style="background-image: linear-gradient(180deg, rgba(7, 15, 30, 0.40) 0%, rgba(10, 25, 47, 0.40) 100%), url('{{ asset('images/hero/contact-page-banner.jpg') }}');">
  <div class="container">
    <div class="hero-tag" style="margin: 0 0 16px; display: inline-flex;">
      <i class="fas fa-headset"></i> Dubai Commercial Desk &amp; Global Inquiries
    </div>
    <h1 class="page-hero-title">Get in Touch with Our<br><span style="color: var(--gold-primary);">Capital Desk Team</span></h1>
    <p class="page-hero-desc">
      Direct communication channels for international buyers, sellers, corporate entities, and institutional project sponsors. Submit your requirement to receive a tracking reference ID.
    </p>
    <div style="display: flex; gap: 16px; justify-content: flex-start; flex-wrap: wrap;">
      <button class="btn-gold open-inquiry-modal" data-vertical="general">
        <i class="fas fa-paper-plane"></i> Submit Trade Requirement
      </button>
      @if(!empty($contact['whatsapp_link']))
        <a href="{{ $contact['whatsapp_link'] }}" target="_blank" rel="noopener noreferrer" class="btn-outline-gold" style="border-color: #25D366; color: #25D366;">
          <i class="fab fa-whatsapp"></i> WhatsApp Direct
        </a>
      @elseif(!empty($contact['whatsapp']))
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact['whatsapp']) }}" target="_blank" rel="noopener noreferrer" class="btn-outline-gold" style="border-color: #25D366; color: #25D366;">
          <i class="fab fa-whatsapp"></i> WhatsApp Direct
        </a>
      @endif
    </div>
  </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
  .leaflet-control-attribution, .leaflet-control-scale { display: none !important; }
  .leaflet-popup-content-wrapper { background: #0F172A; color: #FFFFFF; border: 1px solid var(--border-gold); border-radius: 12px; }
  .leaflet-popup-tip { background: #0F172A; }
  #dubai-map .leaflet-tile-container img { filter: brightness(0.6) invert(1) contrast(2.2) hue-rotate(180deg) saturate(0.3); }
  .contact-grid-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 36px; align-items: stretch; margin-bottom: 70px; }
  .contact-left-card, .contact-right-card { background: linear-gradient(135deg, rgba(15,23,42,.95) 0%, rgba(7,15,30,.98) 100%); border: 1px solid var(--border-gold); border-radius: 20px; padding: 38px 32px; backdrop-filter: blur(16px); box-shadow: var(--shadow-dark); display: flex; flex-direction: column; }
  @media (max-width: 992px) { .contact-grid-wrapper { grid-template-columns: 1fr; gap: 32px; } }
</style>
@endpush

@section('content')
<main class="container" style="padding: 70px 24px;">

  <div class="contact-grid-wrapper">

    <!-- Left: Contact Info Card -->
    <div class="contact-left-card">
      <div>
        <div class="section-header text-left" style="margin-bottom: 24px;">
          <div class="section-subtitle">Operational Headquarters</div>
          <h2 class="section-title" style="font-size: 30px;">Dubai Contact Desk</h2>
          <p class="section-desc">Our team responds directly to structured trade requirements and commercial inquiries.</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
          <div class="advantage-card" style="display: flex; gap: 16px; align-items: flex-start; padding: 16px 18px;">
            <div class="advantage-icon" style="flex-shrink: 0; width: 42px; height: 42px; font-size: 18px; margin-bottom: 0;"><i class="fas fa-location-dot"></i></div>
            <div>
              <h3 style="font-size: 16px; margin-bottom: 4px;">Location</h3>
              <p style="font-size: 13.5px; margin: 0;">Dubai, United Arab Emirates</p>
              <span style="font-size: 11.5px; color: var(--gold-primary); font-weight: 600;">Global Trade &amp; Financial Hub</span>
            </div>
          </div>

          @if(!empty($contact['whatsapp']))
          <div class="advantage-card" style="display: flex; gap: 16px; align-items: flex-start; padding: 16px 18px;">
            <div class="advantage-icon" style="flex-shrink: 0; width: 42px; height: 42px; font-size: 18px; margin-bottom: 0; background: rgba(37,211,102,.1); border-color: rgba(37,211,102,.3); color: #25D366;">
              <i class="fab fa-whatsapp"></i>
            </div>
            <div>
              <h3 style="font-size: 16px; margin-bottom: 4px;">WhatsApp Support</h3>
              <p style="font-size: 13.5px; margin-bottom: 2px;">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact['whatsapp']) }}" target="_blank" rel="noopener noreferrer" style="color: #FFFFFF; text-decoration: none; font-weight: 600;">{{ $contact['whatsapp'] }}</a>
              </p>
              <span style="font-size: 11.5px; color: #25D366; font-weight: 600;">Instant Commercial Messaging</span>
            </div>
          </div>
          @endif

          @if(!empty($contact['email']))
          <div class="advantage-card" style="display: flex; gap: 16px; align-items: flex-start; padding: 16px 18px;">
            <div class="advantage-icon" style="flex-shrink: 0; width: 42px; height: 42px; font-size: 18px; margin-bottom: 0;"><i class="fas fa-envelope"></i></div>
            <div>
              <h3 style="font-size: 16px; margin-bottom: 4px;">Email Inquiry</h3>
              <p style="font-size: 13.5px; margin-bottom: 2px;">
                <a href="mailto:{{ $contact['email'] }}" style="color: #FFFFFF; text-decoration: none; font-weight: 600;">{{ $contact['email'] }}</a>
              </p>
              <span style="font-size: 11.5px; color: var(--gold-primary); font-weight: 600;">Formal Documentation &amp; Proposals</span>
            </div>
          </div>
          @endif

          @if(!empty($social['linkedin']))
          <div class="advantage-card" style="display: flex; gap: 16px; align-items: flex-start; padding: 16px 18px;">
            <div class="advantage-icon" style="flex-shrink: 0; width: 42px; height: 42px; font-size: 18px; margin-bottom: 0; background: rgba(10,102,194,.1); border-color: rgba(10,102,194,.3); color: #0A66C2;">
              <i class="fab fa-linkedin-in"></i>
            </div>
            <div>
              <h3 style="font-size: 16px; margin-bottom: 4px;">Executive LinkedIn</h3>
              <p style="font-size: 13.5px; margin-bottom: 2px;">
                <a href="{{ $social['linkedin'] }}" target="_blank" rel="noopener noreferrer" style="color: #FFFFFF; text-decoration: none; font-weight: 600;">Connect on LinkedIn</a>
              </p>
              <span style="font-size: 11.5px; color: #0A66C2; font-weight: 600;">Professional Network &amp; Advisory</span>
            </div>
          </div>
          @endif

          <div class="advantage-card" style="display: flex; gap: 16px; align-items: flex-start; padding: 16px 18px;">
            <div class="advantage-icon" style="flex-shrink: 0; width: 42px; height: 42px; font-size: 18px; margin-bottom: 0;"><i class="fas fa-clock"></i></div>
            <div>
              <h3 style="font-size: 16px; margin-bottom: 4px;">Desk Hours</h3>
              <p style="font-size: 13.5px; margin: 0;">Monday – Friday: 9:00 AM – 6:00 PM (GST)</p>
              <span style="font-size: 11.5px; color: var(--text-muted);">Gulf Standard Time (UTC+4)</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Requirement Form -->
    <div class="contact-right-card">
      <div>
        <h3 style="font-size: 24px; color: #FFFFFF; margin-bottom: 8px;">Submit Trade <span style="color: var(--gold-primary);">Requirement</span></h3>
        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Fill out the form below to receive your tracking reference ID directly from our Dubai desk.</p>

        <form id="contact-page-form" enctype="multipart/form-data">
          @csrf
          <div style="margin-bottom: 18px;">
            <label class="form-label" for="contact-vertical">Requirement Category <span class="req-star">*</span></label>
            <select class="form-control" name="vertical" id="contact-vertical" required>
              <option value="lc">Trade Finance &amp; Banking Instruments</option>
              <option value="uae-banking">UAE Business Setup &amp; Corporate Banking</option>
              <option value="project">Project Finance</option>
              <option value="commodity">Commodity Trade Solutions</option>
              <option value="general">General Business Inquiry</option>
            </select>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px;">
            <div>
              <label class="form-label" for="contact-name">Full Name <span class="req-star">*</span></label>
              <input type="text" class="form-control" name="name" id="contact-name" placeholder="John Doe" required>
            </div>
            <div>
              <label class="form-label" for="contact-company">Company Name <span class="req-star">*</span></label>
              <input type="text" class="form-control" name="company" id="contact-company" placeholder="Global Trade Corp" required>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px;">
            <div>
              <label class="form-label" for="contact-email">Email Address <span class="req-star">*</span></label>
              <input type="email" class="form-control" name="email" id="contact-email" placeholder="john@company.com" required>
            </div>
            <div>
              <label class="form-label" for="contact-phone">WhatsApp / Phone</label>
              <input type="tel" class="form-control" name="phone" id="contact-phone" placeholder="+971 50 000 0000">
            </div>
          </div>

          <div style="margin-bottom: 18px;">
            <label class="form-label" for="contact-country">Country</label>
            <input type="text" class="form-control" name="country" id="contact-country" placeholder="UAE, UK, India...">
          </div>

          <div style="margin-bottom: 22px;">
            <label class="form-label" for="contact-details">Requirement Specifications <span class="req-star">*</span></label>
            <textarea class="form-control" name="details" id="contact-details" rows="3" placeholder="Describe the transaction, instrument amount, commodity tonnage, origin/destination..." required></textarea>
          </div>

          <div id="contact-error-msg" style="display:none; color:#e74c3c; font-size:13px; margin-bottom:12px;"></div>

          <button type="submit" class="btn-gold" id="contact-submit-btn" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
            <i class="fas fa-paper-plane"></i> Submit Requirement &amp; Get Reference ID
          </button>
        </form>

        <div id="contact-success-msg" style="display: none; margin-top: 18px; background: rgba(37,211,102,.12); border: 1px solid rgba(37,211,102,.4); padding: 16px; border-radius: 12px; color: #25D366; font-size: 14px; text-align: center;">
          <i class="fas fa-circle-check fa-lg" style="margin-bottom: 6px; display: block;"></i>
          <strong>Requirement Submitted Successfully!</strong><br>
          Your Reference ID is: <span id="contact-req-id" style="font-family: monospace; font-weight: 700; color: #FFFFFF;"></span>.<br>
          Our Dubai desk will review your submission shortly.
        </div>
      </div>
    </div>

  </div>

</main>

<!-- Dubai Map Section -->
<section style="position: relative; width: 100%;">
  <div class="container" style="margin-bottom: 20px;">
    <div class="section-header text-left">
      <div class="section-subtitle">Operational Hub</div>
      <h2 class="section-title">Dubai Strategic Hub Map</h2>
      <p class="section-desc">Positioned in Dubai connecting commercial trade corridors between East and West.</p>
    </div>
  </div>
  <div id="dubai-map" style="width: 100%; height: 480px; border-top: 1px solid var(--border-gold); border-bottom: 1px solid var(--border-gold); background: #070F1E; z-index: 1;"></div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Map
  const dubaiCoords = [25.2048, 55.2708];
  const map = L.map('dubai-map', { center: dubaiCoords, zoom: 13, scrollWheelZoom: false, attributionControl: false });
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
  const goldIcon = L.divIcon({
    className: 'custom-map-pin',
    html: `<div style="background:#D4AF37;width:26px;height:26px;border-radius:50%;border:3px solid #070F1E;box-shadow:0 0 15px rgba(212,175,55,.9);display:flex;align-items:center;justify-content:center;"><i class="fas fa-landmark" style="font-size:11px;color:#070F1E;"></i></div>`,
    iconSize: [26, 26], iconAnchor: [13, 13]
  });
  L.marker(dubaiCoords, { icon: goldIcon }).addTo(map).bindPopup(`<div style="padding:6px 4px;text-align:center;"><strong style="color:#D4AF37;font-size:14px;">MH Trade Capital Solutions</strong><br><span style="font-size:12px;color:#94A3B8;">Dubai Operational Desk, UAE</span></div>`).openPopup();

  // Contact form AJAX
  const form = document.getElementById('contact-page-form');
  const btn = document.getElementById('contact-submit-btn');
  const errEl = document.getElementById('contact-error-msg');
  const successEl = document.getElementById('contact-success-msg');
  const reqIdEl = document.getElementById('contact-req-id');

  form?.addEventListener('submit', async function (e) {
    e.preventDefault();
    errEl.style.display = 'none';
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
    try {
      const data = new FormData(form);
      const res = await fetch('{{ route("inquiry.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: data
      });
      const json = await res.json();
      if (json.success) {
        reqIdEl.textContent = json.request_id;
        form.style.display = 'none';
        successEl.style.display = 'block';
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
      btn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Requirement &amp; Get Reference ID';
    }
  });
});
</script>
@endpush
