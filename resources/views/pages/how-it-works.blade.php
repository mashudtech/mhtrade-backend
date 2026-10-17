@extends('layouts.public')

@section('title', 'How Our Requirement Engine Works | MH Trade Capital Solutions Dubai')
@section('meta_desc', 'Discover how MH Trade Capital Solutions processes B2B trade finance, LC/SBLC issuance, commodity sourcing, and Dubai corporate banking through our frictionless execution engine.')
@section('page_hero')
<section class="page-hero-section" style="background-image: linear-gradient(180deg, rgba(7, 15, 30, 0.40) 0%, rgba(10, 25, 47, 0.40) 100%), url('{{ asset('images/hero/dubai_hero_bg_2k.webp') }}');">
  <div class="container">
    <div class="hero-tag" style="margin: 0 0 16px; display: inline-flex;">
      <i class="fas fa-gears"></i> Non-Date Tracking Requirement Architecture
    </div>
    <h1 class="page-hero-title">Frictionless Requirement Engine</h1>
    <p class="page-hero-desc">
      How MH Trade Capital Solutions ingests, evaluates, matches, and executes high-value B2B trade requirements with institutional precision from Dubai.
    </p>
    <div style="display: flex; gap: 16px; justify-content: flex-start; flex-wrap: wrap;">
      <button class="btn-gold open-inquiry-modal" data-vertical="general">
        <i class="fas fa-paper-plane"></i> Initiate Trade Requirement
      </button>
      <a href="{{ route('home') }}#requirement-ingestion" class="btn-outline-gold">
        <i class="fas fa-sliders"></i> Select Requirement on Home
      </a>
    </div>
  </div>
</section>
@endsection

@section('content')
<main class="container" style="padding: 60px 24px;">

  <!-- 4-Step Engine -->
  <div class="section-header text-center">
    <div class="section-subtitle">Execution Blueprint</div>
    <h2 class="section-title">The 4-Step Trade Ingestion Engine</h2>
    <p class="section-desc">Designed to protect client anonymity, reduce processing latency, and enforce strict bank compliance standards.</p>
  </div>

  <div class="engine-detail-grid">
    <div class="engine-card">
      <div class="engine-card-number">STEP 01</div>
      <h3 class="engine-card-title">Structured Requirement Ingestion</h3>
      <p class="engine-card-desc">Submit your trade target via our online engine or inquiry desk. Choose your exact financial instrument (LC, SBLC, UPAS) or commodity specs (Grade, Metric Tonnage, Incoterms).</p>
      <ul class="engine-checklist">
        <li><i class="fas fa-check-circle"></i> Target Instrument &amp; Amount Selection</li>
        <li><i class="fas fa-check-circle"></i> Issuing / Advising Bank Parameters</li>
        <li><i class="fas fa-check-circle"></i> Preliminary Term Sheet Data Intake</li>
      </ul>
    </div>

    <div class="engine-card">
      <div class="engine-card-number">STEP 02</div>
      <h3 class="engine-card-title">Non-Date Reference ID Assignment</h3>
      <p class="engine-card-desc">To prevent transaction tracking leakage and safeguard confidentiality, our system automatically generates a unique non-date tracking ID (e.g. <code>MH-LC-00842</code>).</p>
      <ul class="engine-checklist">
        <li><i class="fas fa-check-circle"></i> 100% Confidentiality &amp; Data Encryption</li>
        <li><i class="fas fa-check-circle"></i> Real-time Reference Tracking ID</li>
        <li><i class="fas fa-check-circle"></i> Automated Dubai Desk Route Tagging</li>
      </ul>
    </div>

    <div class="engine-card">
      <div class="engine-card-number">STEP 03</div>
      <h3 class="engine-card-title">Dubai Desk Review &amp; Matching</h3>
      <p class="engine-card-desc">Our trade specialists analyze your requirement against top-tier international banking rules (UCP 600 / URDG 758), allocation availability, and compliance parameters.</p>
      <ul class="engine-checklist">
        <li><i class="fas fa-check-circle"></i> SWIFT Capability &amp; Verification</li>
        <li><i class="fas fa-check-circle"></i> Allocation &amp; Supplier Due Diligence</li>
        <li><i class="fas fa-check-circle"></i> Non-Circumvention Protection (NCNDA)</li>
      </ul>
    </div>

    <div class="engine-card">
      <div class="engine-card-number">STEP 04</div>
      <h3 class="engine-card-title">Direct Bank &amp; Deal Facilitation</h3>
      <p class="engine-card-desc">Upon approval, direct communication is established for bank-to-bank SWIFT transmission (MT799/MT760), allocation contract signing, or UAE corporate account issuance.</p>
      <ul class="engine-checklist">
        <li><i class="fas fa-check-circle"></i> Direct Bank-to-Bank Transmission</li>
        <li><i class="fas fa-check-circle"></i> Contract Execution &amp; Escrow Setup</li>
        <li><i class="fas fa-check-circle"></i> Final Settlement &amp; Delivery Audit</li>
      </ul>
    </div>
  </div>

  <!-- Live Simulator -->
  <div style="background: rgba(15,23,42,.85); border: 1px solid var(--border-gold); border-radius: 20px; padding: 40px; margin: 60px 0; text-align: center; backdrop-filter: blur(16px);">
    <div class="section-subtitle">Interactive Engine Preview</div>
    <h3 style="font-size: 26px; color: #FFFFFF; margin-bottom: 12px;">Test Unique Reference ID Generation</h3>
    <p style="color: var(--text-muted); font-size: 15px; max-width: 640px; margin: 0 auto 24px;">
      Select a vertical below to simulate how our engine formats your confidential non-date tracking reference ID in real time.
    </p>
    <div style="display: flex; gap: 16px; justify-content: center; align-items: center; max-width: 540px; margin: 0 auto; flex-wrap: wrap;">
      <select id="sim-vertical-select" class="ingestion-select" style="max-width: 360px;">
        <option value="LC">Trade Finance &amp; Banking Instruments</option>
        <option value="BANK">UAE Business Setup &amp; Corporate Banking</option>
        <option value="PROJ">Project Finance</option>
        <option value="COM">Commodity Trade Solutions</option>
        <option value="REQ">General Business Inquiry</option>
      </select>
      <div id="sim-id-display" class="sample-id-tag" style="font-size: 18px; padding: 12px 24px;">MH-LC-00842</div>
    </div>
  </div>

  <!-- SLA Timelines -->
  <div class="timelines-table-wrapper">
    <div class="section-header text-left" style="margin-bottom: 20px;">
      <div class="section-subtitle">Performance Benchmarks</div>
      <h2 class="section-title">Turnaround Timelines by Vertical</h2>
      <p class="section-desc">Average operational review and execution speed managed from our Dubai desk.</p>
    </div>
    <div class="timelines-grid">
      <div class="timeline-box"><div class="timeline-value">24-48 Hours</div><div class="timeline-label">Initial Compliance Review</div></div>
      <div class="timeline-box"><div class="timeline-value">2-5 Banking Days</div><div class="timeline-label">LC / SBLC Instrument Pre-Advice</div></div>
      <div class="timeline-box"><div class="timeline-value">3-7 Business Days</div><div class="timeline-label">UAE Corporate Banking Setup</div></div>
      <div class="timeline-box"><div class="timeline-value">48 Hours</div><div class="timeline-label">Commodity Allocation Verification</div></div>
    </div>
  </div>

  <!-- Bottom CTA -->
  <div style="text-align: center; padding: 60px 0 20px;">
    <h2 style="font-size: 30px; color: #FFFFFF; margin-bottom: 16px;">Ready to Submit Your Requirement?</h2>
    <p style="color: var(--text-muted); font-size: 16px; margin-bottom: 28px;">Initiate your requirement through our confidential engine in under 60 seconds.</p>
    <button class="btn-gold open-inquiry-modal" data-vertical="general" style="font-size: 16px; padding: 16px 36px;">
      <i class="fas fa-paper-plane"></i> Submit Requirement Now
    </button>
  </div>

</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const simSelect = document.getElementById('sim-vertical-select');
  const simDisplay = document.getElementById('sim-id-display');
  simSelect?.addEventListener('change', () => {
    const randNum = String(Math.floor(10000 + Math.random() * 90000)).substring(0, 5).padStart(5, '0');
    simDisplay.textContent = `MH-${simSelect.value}-${randNum}`;
  });
});
</script>
@endpush
