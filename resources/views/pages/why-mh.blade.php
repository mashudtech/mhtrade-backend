@extends('layouts.public')

@section('title', 'Why MH | Transaction First. Structure Second. Banking Third — MH Trade Capital Solutions')
@section('meta_desc', 'Discover why international businesses choose MH Trade Capital Solutions — Transaction-focused trade finance, global banking relationships, structured execution, and the strategic Dubai advantage.')

@section('page_hero')
<section class="page-hero-section" style="background-image: linear-gradient(180deg, rgba(7, 15, 30, 0.40) 0%, rgba(10, 25, 47, 0.40) 100%), url('{{ content_image_url($content['why_image'] ?? null, 'images/hero/dubai_hero_bg.webp') }}');">
  <div class="container">
    <div class="hero-tag" style="margin: 0 0 16px; display: inline-flex;">
      <i class="fas fa-shield-halved"></i> {{ $content['why_hero_tag'] ?? 'Transaction-First Approach' }}
    </div>
    <h1 class="page-hero-title">{!! format_title($content['why_hero_title'] ?? 'Transaction First.', $content['why_hero_title_accent'] ?? null) !!}</h1>
    <p class="page-hero-desc">
      {{ $content['why_hero_desc'] ?? 'We do not start with a financial instrument. We start by understanding the transaction.' }}
    </p>
    <div style="display: flex; gap: 16px; justify-content: flex-start; flex-wrap: wrap;">
      <button class="btn-gold open-inquiry-modal" data-vertical="general">
        <i class="fas fa-paper-plane"></i> Submit Requirement
      </button>
      <a href="{{ route('solutions') }}" class="btn-outline-gold">
        <i class="fas fa-layer-group"></i> Explore Our Solutions
      </a>
    </div>
  </div>
</section>
@endsection

@section('content')
<main class="container" style="padding: 70px 24px;">

  <!-- 4 Pillars -->
  <section style="margin-bottom: 80px;">
    <div class="section-header text-center" style="max-width: 900px; margin: 0 auto 40px;">
      <div class="section-subtitle">{{ $content['why_pillars_subtitle'] ?? 'Core Philosophy' }}</div>
      <h2 class="section-title">{{ $content['why_pillars_title'] ?? 'Understanding the Commercial Activity First' }}</h2>
      <div class="section-desc" style="font-size: 16px; line-height: 1.8; color: rgba(255,255,255,.9);">
        {!! $content['why_pillars_desc'] ?? 'Our approach begins with the underlying commercial activity, counterparties, contracts, payment structure, banking requirements, documentation and compliance considerations before determining the appropriate financial solution.' !!}
      </div>
    </div>

    <div class="advantage-cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 24px;">
      <div class="advantage-card" style="position: relative; overflow: hidden;">
        <div style="font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 800; color: var(--gold-primary); margin-bottom: 12px; letter-spacing: 1px;">01 — PILLAR</div>
        <div class="advantage-icon"><i class="fas fa-diagram-project"></i></div>
        <h3 style="font-size: 20px; margin-bottom: 10px;">{{ $content['why_p1_title'] ?? 'Transaction-Focused Approach' }}</h3>
        <div style="font-size: 14px; line-height: 1.65; color: var(--text-muted);">{!! $content['why_p1_desc'] ?? 'We assess the underlying commercial transaction before considering an appropriate financial structure or banking solution.' !!}</div>
      </div>
      <div class="advantage-card" style="position: relative; overflow: hidden;">
        <div style="font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 800; color: var(--gold-primary); margin-bottom: 12px; letter-spacing: 1px;">02 — PILLAR</div>
        <div class="advantage-icon"><i class="fas fa-building-columns"></i></div>
        <h3 style="font-size: 20px; margin-bottom: 10px;">{{ $content['why_p2_title'] ?? 'Global Banking Relationships' }}</h3>
        <div style="font-size: 14px; line-height: 1.65; color: var(--text-muted);">{!! $content['why_p2_desc'] ?? 'We work through a broad network of international banking relationships to support eligible trade and financing requirements.' !!}</div>
      </div>
      <div class="advantage-card" style="position: relative; overflow: hidden;">
        <div style="font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 800; color: var(--gold-primary); margin-bottom: 12px; letter-spacing: 1px;">03 — PILLAR</div>
        <div class="advantage-icon"><i class="fas fa-list-check"></i></div>
        <h3 style="font-size: 20px; margin-bottom: 10px;">{{ $content['why_p3_title'] ?? 'Structured & Transparent Process' }}</h3>
        <div style="font-size: 14px; line-height: 1.65; color: var(--text-muted);">{!! $content['why_p3_desc'] ?? 'Clear requirements, defined steps and coordinated documentation from initial assessment through the relevant banking or financing stage.' !!}</div>
      </div>
      <div class="advantage-card" style="position: relative; overflow: hidden;">
        <div style="font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 800; color: var(--gold-primary); margin-bottom: 12px; letter-spacing: 1px;">04 — PILLAR</div>
        <div class="advantage-icon"><i class="fas fa-shield-halved"></i></div>
        <h3 style="font-size: 20px; margin-bottom: 10px;">{{ $content['why_p4_title'] ?? 'Compliance-Driven' }}</h3>
        <div style="font-size: 14px; line-height: 1.65; color: var(--text-muted);">{!! $content['why_p4_desc'] ?? 'Every transaction is subject to appropriate due diligence, KYC/AML and sanctions screening, risk assessment, applicable requirements and the final approval of the relevant bank or financial institution.' !!}</div>
      </div>
    </div>
  </section>

  <!-- Dubai Advantage -->
  <section style="margin-bottom: 70px;">
    <div class="section-header text-center" style="max-width: 900px; margin: 0 auto 40px;">
      <div class="section-subtitle">{{ $content['why_dubai_subtitle'] ?? 'Dubai Advantage' }}</div>
      <h2 class="section-title" style="font-size: 34px;">{{ $content['why_dubai_title'] ?? 'Why Dubai' }}</h2>
      <div class="section-desc" style="font-size: 16px; line-height: 1.8; color: rgba(255,255,255,.9);">
        {!! $content['why_dubai_desc'] ?? 'Dubai serves as a strategic hub connecting Asia, Africa, Europe and the Middle East—supporting international trade, cross-border business and financial activity.' !!}
      </div>
    </div>

    <div class="advantage-cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 24px;">
      <div class="advantage-card">
        <div class="advantage-icon"><i class="fas fa-globe"></i></div>
        <h3 style="font-size: 20px;">{{ $content['why_adv1_title'] ?? 'Global Connectivity' }}</h3>
        <div style="font-size: 14px; line-height: 1.65;">{!! $content['why_adv1_desc'] ?? 'Access to major international trade routes and markets across East and West.' !!}</div>
      </div>
      <div class="advantage-card">
        <div class="advantage-icon"><i class="fas fa-city"></i></div>
        <h3 style="font-size: 20px;">{{ $content['why_adv2_title'] ?? 'Business Infrastructure' }}</h3>
        <div style="font-size: 14px; line-height: 1.65;">{!! $content['why_adv2_desc'] ?? 'A well-developed ecosystem supporting international commerce, corporate activity and financial services.' !!}</div>
      </div>
      <div class="advantage-card">
        <div class="advantage-icon"><i class="fas fa-location-dot"></i></div>
        <h3 style="font-size: 20px;">{{ $content['why_adv3_title'] ?? 'Strategic Location' }}</h3>
        <div style="font-size: 14px; line-height: 1.65;">{!! $content['why_adv3_desc'] ?? 'A central gateway between key markets across Asia, Africa, Europe and the Middle East.' !!}</div>
      </div>
      <div class="advantage-card">
        <div class="advantage-icon"><i class="fas fa-handshake"></i></div>
        <h3 style="font-size: 20px;">{{ $content['why_adv4_title'] ?? 'International Business Environment' }}</h3>
        <div style="font-size: 14px; line-height: 1.65;">{!! $content['why_adv4_desc'] ?? 'A globally connected business environment designed to support cross-border commercial activity and international companies.' !!}</div>
      </div>
    </div>
  </section>

  <!-- CTA Banner -->
  <div style="background: linear-gradient(135deg, rgba(15,23,42,.95) 0%, rgba(7,15,30,.98) 100%); border: 1px solid var(--border-gold); padding: 48px 36px; border-radius: 20px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,.4);">
    <h3 style="font-size: 26px; color: #FFFFFF; margin-bottom: 10px;">{{ $content['why_cta_title'] ?? 'Ready to Discuss Your Trade Requirement?' }}</h3>
    <p style="color: var(--text-muted); font-size: 15px; max-width: 680px; margin: 0 auto 24px;">
      {{ $content['why_cta_desc'] ?? 'Connect directly with our Dubai operational desk to evaluate your commercial transaction and determine the appropriate financial or banking pathway.' }}
    </p>
    <button class="btn-gold open-inquiry-modal" data-vertical="general">
      <i class="fas fa-paper-plane"></i> Submit Requirement
    </button>
  </div>

</main>
@endsection
