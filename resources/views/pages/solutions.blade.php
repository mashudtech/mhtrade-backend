@extends('layouts.public')

@section('title', 'Our Core Capabilities & Solutions | MH Trade Capital Solutions Dubai')
@section('meta_desc', 'Explore all 5 core business capabilities of MH Trade Capital Solutions — Trade Finance, UAE Corporate Banking, Project Finance, Commodity Sourcing, and General Business Procurement.')
@section('page_hero')
<section class="page-hero-section" style="background-image: linear-gradient(180deg, rgba(7, 15, 30, 0.40) 0%, rgba(10, 25, 47, 0.40) 100%), url('{{ asset('images/hero/dubai_hero_bg.webp') }}');">
  <div class="container">
    <div class="hero-tag" style="margin: 0 0 16px; display: inline-flex;">
      <i class="fas fa-layer-group"></i> Institutional Financial Capabilities
    </div>
    <h1 class="page-hero-title">Core Business Verticals &amp;<br><span style="color: var(--gold-primary);">Capital Solutions</span></h1>
    <p class="page-hero-desc">
      Specialized business divisions tailored for global buyers, sellers, corporations, and institutional projects from Dubai, United Arab Emirates.
    </p>
    <div style="display: flex; gap: 16px; justify-content: flex-start; flex-wrap: wrap;">
      <button class="btn-gold open-inquiry-modal" data-vertical="general">
        <i class="fas fa-paper-plane"></i> Submit Requirement Desk
      </button>
      <a href="{{ route('how-it-works') }}" class="btn-outline-gold">
        <i class="fas fa-gears"></i> Explore Execution Pipeline
      </a>
    </div>
  </div>
</section>
@endsection

@section('content')
<main class="container" style="padding: 70px 24px;">

  <div class="section-header text-center" style="margin-bottom: 50px;">
    <div class="section-subtitle">Capability Directory</div>
    <h2 class="section-title">5 Core Financial &amp; Sourcing Verticals</h2>
    <p class="section-desc">Select any capability below to view its complete instrument specifications, commercial frameworks, and execution terms.</p>
  </div>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 32px; margin-bottom: 70px;">
    @foreach($solutions as $solution)
      <a href="{{ route('solutions.show', $solution->slug) }}" class="vertical-card"
         style="text-decoration: none; display: flex; flex-direction: column; cursor: pointer;">
        <div class="v-card-img-wrapper">
          <img src="{{ $solution->image_url }}"
               alt="{{ $solution->title }}" class="v-card-img" loading="lazy" decoding="async">
        </div>
        <div class="v-card-body" style="display: flex; flex-direction: column; flex: 1; justify-content: space-between;">
          <div>
            <h3 class="v-title" style="font-size: 22px; margin-bottom: 12px; color: #FFFFFF;">{{ $solution->title }}</h3>

            @if($solution->badge)
            <div style="margin-bottom: 14px; display: flex; flex-wrap: wrap; gap: 6px;">
              @foreach(explode(',', $solution->badge) as $tag)
                <span style="font-size: 11px; background: rgba(212,175,55,.1); border: 1px solid rgba(212,175,55,.25); color: var(--gold-primary); padding: 3px 10px; border-radius: 12px; font-weight: 600;">
                  {{ trim($tag) }}
                </span>
              @endforeach
            </div>
            @endif

            <p class="v-desc" style="font-size: 14.5px; color: var(--text-muted); line-height: 1.65; margin-bottom: 20px;">
              {{ $solution->short_desc }}
            </p>
          </div>

          <div style="display: flex; align-items: center; gap: 8px; color: var(--gold-primary); font-weight: 700; font-size: 14px; border-top: 1px solid rgba(255,255,255,.08); padding-top: 16px;">
            <span>Explore Full Capability Specs</span>
            <i class="fas fa-arrow-right"></i>
          </div>
        </div>
      </a>
    @endforeach
  </div>

  <!-- Disclaimer -->
  <div style="background: rgba(15,23,42,.85); border: 1px solid var(--border-gold); border-radius: 18px; padding: 32px 36px; margin-bottom: 60px; backdrop-filter: blur(14px); box-shadow: var(--shadow-dark);">
    <h4 style="font-size: 17px; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
      <i class="fas fa-shield-halved"></i> Disclaimer &amp; Assessment Criteria
    </h4>
    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.65; margin-bottom: 0;">
      All financial, banking and trade finance solutions are subject to transaction assessment, KYC/AML and sanctions screening, due diligence, applicable laws and regulations, and the final approval of the relevant bank, financial institution or funding party.
    </p>
  </div>

  <!-- Bottom CTA -->
  <div style="text-align: center; padding: 20px 0 20px;">
    <h2 style="font-size: 30px; color: #FFFFFF; margin-bottom: 14px;">Ready to Structure Your Requirement?</h2>
    <p style="color: var(--text-muted); font-size: 16px; margin-bottom: 24px;">Connect directly with our Dubai desk specialists to submit your financial parameters.</p>
    <button class="btn-gold open-inquiry-modal" data-vertical="general" style="font-size: 15px; padding: 16px 36px;">
      <i class="fas fa-paper-plane"></i> Submit Requirement Desk
    </button>
  </div>

</main>
@endsection
