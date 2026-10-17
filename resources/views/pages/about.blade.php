@extends('layouts.public')

@section('title', 'About Us | MH Trade Capital Solutions Dubai')
@section('meta_desc', 'Learn about MH Trade Capital Solutions — Dubai-based trade and capital solutions firm supporting international businesses with trade finance, banking solutions, commodity trade assistance and structured financing requirements.')

@section('page_hero')
<section class="page-hero-section" style="background-image: linear-gradient(180deg, rgba(7, 15, 30, 0.40) 0%, rgba(10, 25, 47, 0.40) 100%), url('{{ content_image_url($content['about_image'] ?? null, 'images/about_us_dubai.webp') }}');">
  <div class="container">
    <div class="hero-tag" style="margin: 0 0 16px; display: inline-flex;">
      <i class="fas fa-building-columns"></i> {{ $content['about_hero_tag'] ?? 'Corporate Profile & Company Overview' }}
    </div>
    <h1 class="page-hero-title">{!! format_title($content['about_hero_title'] ?? 'Built Around Relationships.', $content['about_hero_title_accent'] ?? null) !!}</h1>
    <p class="page-hero-desc">
      {{ $content['about_hero_desc'] ?? 'MH Trade Capital Solutions is a Dubai-based trade and capital solutions firm supporting international businesses with trade finance, banking solutions, commodity trade assistance and structured financing requirements.' }}
    </p>
    <div style="display: flex; gap: 16px; justify-content: flex-start; flex-wrap: wrap;">
      <button class="btn-gold open-inquiry-modal" data-vertical="general">
        <i class="fas fa-paper-plane"></i> Submit Requirement
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

  <!-- Corporate Introduction Section -->
  <section class="about-section" style="border: none; background: transparent; padding: 0 0 60px;">
    <div class="about-grid">
      <div class="about-content-box">
        <div class="section-subtitle">{{ $content['about_intro_subtitle'] ?? 'Company Introduction' }}</div>
        <h2 class="section-title">{{ $content['about_intro_title'] ?? 'Built Around Relationships. Driven by Transactions.' }}</h2>

        <div class="about-desc-text" style="margin-bottom: 16px;">
          {!! $content['about_intro_p1'] ?? 'MH Trade Capital Solutions is a Dubai-based trade and capital solutions firm supporting international businesses with trade finance, banking solutions, commodity trade assistance and structured financing requirements.' !!}
        </div>

        <div class="about-desc-text" style="margin-bottom: 16px;">
          {!! $content['about_intro_p2'] ?? 'With more than 11 years of professional experience and 40+ banking relationships worldwide, we take a transaction-first approach—understanding the underlying commercial activity, counterparties, documentation and requirements before identifying the appropriate financial or banking pathway.' !!}
        </div>

        <!-- Focus Statement Quote -->
        <div style="background: rgba(212, 175, 55, 0.08); border-left: 4px solid var(--gold-primary); padding: 18px 24px; border-radius: 0 12px 12px 0; margin: 24px 0 32px;">
          <div style="font-size: 16px; font-weight: 600; color: #FFFFFF; margin: 0; line-height: 1.5; font-style: italic;">
            {!! $content['about_focus_quote'] ?? '"Our focus is simple: understand the transaction, structure the requirement, and coordinate the appropriate solution."' !!}
          </div>
        </div>

        <div class="about-highlights-grid">
          <div class="about-highlight-card">
            <div class="about-highlight-icon"><i class="fas fa-award"></i></div>
            <div class="about-highlight-info">
              <h4>{{ $content['about_stat_years'] ?? '11+ Years of Experience' }}</h4>
              <p>{{ $content['about_stat_years_desc'] ?? 'Professional experience across trade finance and financial solutions.' }}</p>
            </div>
          </div>
          <div class="about-highlight-card">
            <div class="about-highlight-icon"><i class="fas fa-building-columns"></i></div>
            <div class="about-highlight-info">
              <h4>{{ $content['about_stat_banking'] ?? '40+ Banking Relationships' }}</h4>
              <p>{{ $content['about_stat_banking_desc'] ?? 'A broad network of banking relationships across international markets.*' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Image -->
      <div class="about-img-container">
        <img src="{{ content_image_url($content['about_image'] ?? null, 'images/about_us_dubai.webp') }}" alt="MH Trade Capital Solutions Boardroom" class="about-img" loading="lazy" decoding="async">
        <div class="about-experience-badge">
          <div class="about-badge-icon"><i class="fas fa-landmark"></i></div>
          <div class="about-badge-text">
            <h4>{{ $content['about_badge_years'] ?? '11+ Years Experience' }}</h4>
            <p>{{ $content['about_badge_desc'] ?? '40+ Global Banking Relationships' }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Core Philosophy -->
  <div style="margin: 30px 0 60px;">
    <div class="section-header text-center" style="margin-bottom: 36px;">
      <div class="section-subtitle" style="letter-spacing: 2px;">{{ $content['about_philosophy_subtitle'] ?? 'Core Philosophy' }}</div>
      <h2 class="section-title core-philosophy-title">{{ $content['about_philosophy_title'] ?? 'CONNECTING MARKETS. CREATING VALUE. BUILDING FUTURES.' }}</h2>
      <p class="section-desc">{{ $content['about_philosophy_desc'] ?? 'Strategic financial facilitation connecting international commercial hubs from Dubai, United Arab Emirates.' }}</p>
    </div>

    <div class="core-philosophy-grid">
      <div class="advantage-card">
        <div class="advantage-icon"><i class="fas fa-globe"></i></div>
        <h3 style="font-size: 20px;">{{ $content['about_philosophy_card1_title'] ?? 'Global Market Reach' }}</h3>
        <p style="font-size: 14.5px; line-height: 1.65;">{{ $content['about_philosophy_card1_desc'] ?? 'Supporting cross-border business and commercial activity across international markets.' }}</p>
      </div>
      <div class="advantage-card">
        <div class="advantage-icon"><i class="fas fa-location-dot"></i></div>
        <h3 style="font-size: 20px;">{{ $content['about_philosophy_card2_title'] ?? 'Dubai-Based' }}</h3>
        <p style="font-size: 14.5px; line-height: 1.65;">{{ $content['about_philosophy_card2_desc'] ?? 'Strategically positioned in Dubai, a global hub connecting Asia, Africa, Europe and the Middle East.' }}</p>
      </div>
    </div>
  </div>

  <!-- SLA Benchmarks -->
  <div class="timelines-table-wrapper" style="margin-bottom: 60px;">
    <div class="section-header text-left" style="margin-bottom: 24px;">
      <div class="section-subtitle">{{ $content['about_sla_subtitle'] ?? 'Execution Benchmark' }}</div>
      <h2 class="section-title">{{ $content['about_sla_title'] ?? 'Standard Service Level Benchmarks' }}</h2>
      <p class="section-desc">{{ $content['about_sla_desc'] ?? 'Average timeline benchmarks maintained across our core business divisions.' }}</p>
    </div>
    <div class="timelines-grid">
      <div class="timeline-box">
        <div class="timeline-value">{{ $content['about_sla_1_val'] ?? '24-48 Hours' }}</div>
        <div class="timeline-label">{{ $content['about_sla_1_label'] ?? 'Initial Desk Evaluation' }}</div>
      </div>
      <div class="timeline-box">
        <div class="timeline-value">{{ $content['about_sla_2_val'] ?? '2-5 Banking Days' }}</div>
        <div class="timeline-label">{{ $content['about_sla_2_label'] ?? 'LC / SBLC Instrument Pre-Advice' }}</div>
      </div>
      <div class="timeline-box">
        <div class="timeline-value">{{ $content['about_sla_3_val'] ?? '3-7 Business Days' }}</div>
        <div class="timeline-label">{{ $content['about_sla_3_label'] ?? 'UAE Corporate Bank Setup' }}</div>
      </div>
      <div class="timeline-box">
        <div class="timeline-value">{{ $content['about_sla_4_val'] ?? '48 Hours' }}</div>
        <div class="timeline-label">{{ $content['about_sla_4_label'] ?? 'Commodity Allocation Review' }}</div>
      </div>
    </div>
  </div>

  <!-- Disclaimer -->
  <div style="background: rgba(15, 23, 42, 0.85); border: 1px solid var(--border-gold); border-radius: 18px; padding: 32px 36px; margin-bottom: 60px; backdrop-filter: blur(14px); box-shadow: var(--shadow-dark);">
    <h4 style="font-size: 17px; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
      <i class="fas fa-shield-halved"></i> Disclaimer
    </h4>
    <div style="font-size: 14px; color: var(--text-muted); line-height: 1.65; margin-bottom: 12px;">
      {!! $content['about_disclaimer'] ?? "All financial, banking and trade finance solutions are subject to transaction assessment, KYC/AML and sanctions screening, due diligence, applicable laws and regulations, and the final approval of the relevant bank, financial institution or funding party.<br><br>MH Trade Capital Solutions does not guarantee the issuance, acceptance or approval of any financial instrument, financing facility or banking solution." !!}
    </div>
    <p style="font-size: 12.5px; color: rgba(255, 255, 255, 0.55); border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 12px; margin-top: 12px; line-height: 1.5;">
      * Banking relationships are subject to the nature of the transaction, applicable compliance requirements and the policies of the relevant institution.
    </p>
  </div>

  <!-- Bottom CTA -->
  <div style="text-align: center; padding: 20px 0 20px;">
    <h2 style="font-size: 30px; color: #FFFFFF; margin-bottom: 14px;">{{ $content['about_cta_title'] ?? 'Initiate Your Trade Requirement' }}</h2>
    <p style="color: var(--text-muted); font-size: 16px; margin-bottom: 24px;">{{ $content['about_cta_desc'] ?? 'Connect directly with our Dubai desk specialists to structure your financial requirement.' }}</p>
    <button class="btn-gold open-inquiry-modal" data-vertical="general" style="font-size: 15px; padding: 16px 36px;">
      <i class="fas fa-paper-plane"></i> Submit Requirement Now
    </button>
  </div>

</main>
@endsection
