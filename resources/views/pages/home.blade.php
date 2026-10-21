@extends('layouts.public')

@section('title', 'MH Trade Capital Solutions — B2B Trade Finance, Commodity Sourcing & UAE Banking')
@section('meta_desc', 'Dubai-based B2B Trade Finance (LC / SBLC), Commodity Sourcing, Project Finance, and UAE Corporate Banking. High-converting global financial infrastructure platform.')
@section('hero_bg', 'images/hero/dubai_hero_bg_2k.webp')

@section('hero')
<div class="hero-slider-container" id="hero-slider-container">
  @forelse($heroSlides as $slide)
    <div class="hero-slide-item {{ $loop->first ? 'active' : '' }}" data-slide-index="{{ $loop->index }}">
      <div class="hero-slide-bg" style="background-image: url('{{ $slide->image_url }}');"></div>
      <div class="hero-slide-overlay"></div>

      <section class="hero-section">
        <div class="container hero-content">
          <div class="hero-glass-card">
            @if($slide->tag)
              <div class="hero-tag">
                <i class="fas fa-shield-halved"></i> {{ $slide->tag }}
              </div>
            @endif

            <h1 class="hero-title" data-title="{{ $slide->title }}" data-accent="{{ $slide->title_accent }}">{!! format_title($slide->title, $slide->title_accent) !!}</h1>

            @if($slide->subtitle)
              <p class="hero-subtitle">{!! nl2br(e($slide->subtitle)) !!}</p>
            @endif

            <div class="hero-actions">
              @if(empty($slide->button_link) || $slide->button_link === '#')
                <button class="btn-gold open-inquiry-modal" data-vertical="{{ $slide->button_vertical ?: 'general' }}"
                  style="padding: 14px 32px; font-size: 15px; border-radius: 10px;">
                  <i class="fas fa-paper-plane"></i> {{ $slide->button_text ?: 'Submit Requirement' }}
                </button>
              @else
                <a href="{{ $slide->button_link }}" class="btn-gold"
                  style="padding: 14px 32px; font-size: 15px; border-radius: 10px; text-decoration: none;">
                  <i class="fas fa-arrow-right"></i> {{ $slide->button_text ?: 'Submit Requirement' }}
                </a>
              @endif
            </div>
          </div>
        </div>
      </section>
    </div>
  @empty
    <div class="hero-slide-item active" data-slide-index="0">
      <div class="hero-slide-bg" style="background-image: url('{{ asset('images/hero/dubai_hero_bg_2k.webp') }}');"></div>
      <div class="hero-slide-overlay"></div>
      <section class="hero-section">
        <div class="container hero-content">
          <div class="hero-glass-card">
            <div class="hero-tag">
              <i class="fas fa-shield-halved"></i> Trade Finance • Banking Instruments • Project Finance • Commodity Trade
            </div>
            <h1 class="hero-title" data-title="Structured Trade Finance &amp;" data-accent="Capital Solutions">Structured Trade Finance &amp; <br>
              <span>Capital Solutions</span>
            </h1>
            <p class="hero-subtitle">Connecting Real Transactions with the Right Financial Solutions
              <br>Dubai-Based | 40+ Banking Relationships Worldwide | 11+ Years of Experience
            </p>
            <div class="hero-actions">
              <button class="btn-gold open-inquiry-modal" data-vertical="general"
                style="padding: 14px 32px; font-size: 15px; border-radius: 10px;">
                <i class="fas fa-paper-plane"></i> Submit Requirement
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>
  @endforelse

  <!-- Outside Container: Left and Right Navigation Controls -->
  @if($heroSlides->count() > 1)
    <button class="hero-slider-nav hero-slider-prev" id="hero-slider-prev" aria-label="Previous Slide">
      <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-slider-nav hero-slider-next" id="hero-slider-next" aria-label="Next Slide">
      <i class="fas fa-chevron-right"></i>
    </button>
  @endif

  <!-- Inside Container: Bottom-Right Notification Dots -->
  @if($heroSlides->count() > 1)
    <div class="hero-slider-dots-wrapper">
      <div class="container">
        <div class="hero-slider-dots" id="hero-slider-dots">
          @foreach($heroSlides as $slide)
            <button class="hero-slider-dot {{ $loop->first ? 'active' : '' }}" data-slide-to="{{ $loop->index }}" aria-label="Slide {{ $loop->iteration }}"></button>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  <a href="#requirement-ingestion" class="hero-scroll-hint">
    <span>Explore</span>
    <i class="fas fa-chevron-down"></i>
  </a>
</div>
@endsection

@section('content')

  <!-- Core Business Verticals Showcase Section -->
  <section class="container verticals-section" id="verticals">
    <div class="section-header-wrapper">
      <div class="section-header text-left">
        <div class="section-subtitle">Our Core Capabilities</div>
        <h2 class="section-title">Select Your Business Requirement</h2>
        <p class="section-desc">Choose the service area that best matches your business, financing, trade or banking requirement.</p>
      </div>
      <div class="slider-controls">
        <button class="slider-btn" id="verticals-prev" aria-label="Previous vertical"><i class="fas fa-chevron-left"></i></button>
        <button class="slider-btn" id="verticals-next" aria-label="Next vertical"><i class="fas fa-chevron-right"></i></button>
      </div>
    </div>

    <div class="verticals-grid-wrapper">
      <div class="verticals-grid" id="verticals-slider">
        @foreach($solutions as $solution)
          <a href="{{ route('solutions.show', $solution->slug) }}" class="vertical-card"
            style="text-decoration: none; display: flex; flex-direction: column; cursor: pointer;">
            <div class="v-card-img-wrapper">
              <img src="{{ $solution->image_url }}"
                alt="{{ $solution->title }}" class="v-card-img" loading="lazy" decoding="async">
            </div>
            <div class="v-card-body" style="display: flex; flex-direction: column; flex: 1;">
              <h3 class="v-title" style="font-size: 20px; color: #FFFFFF; margin-bottom: 10px;">
                {{ $solution->title }}
              </h3>
              <p class="v-desc" style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin: 0;">
                {{ $solution->short_desc }}
              </p>
            </div>
          </a>
        @endforeach
      </div>
    </div>

    <!-- Bottom Action -->
    <div class="verticals-bottom-action">
      <a href="{{ route('solutions') }}" class="btn-gold" style="display: inline-flex; text-decoration: none;">
        <i class="fas fa-layer-group"></i> Browse All Capabilities
      </a>
    </div>
  </section>

  <!-- Trade Requirement Ingestion Section -->
  <section class="trade-requirement-section" id="requirement-ingestion">
    <div class="container">
      <div class="ingestion-section-card">
        <div class="ingestion-header-text">
          <h3>Select Trade Requirement</h3>
          <p>Choose your target financial vertical or sourcing requirement to get started</p>
        </div>
        <div class="hero-ingestion-widget">
          <form id="hero-ingestion-form">
            <div class="ingestion-form-row">
              <div class="ingestion-select-group">
                <label class="ingestion-label" for="hero-vertical-select">Select Trade Requirement</label>
                <select class="ingestion-select" id="hero-vertical-select">
                  <option value="lc">Trade Finance &amp; Banking Instruments</option>
                  <option value="uae-banking">UAE Business Setup &amp; Corporate Banking</option>
                  <option value="project">Project Finance</option>
                  <option value="commodity">Commodity Trade Solutions</option>
                  <option value="general">General Business Inquiry</option>
                </select>
              </div>
              <button type="submit" class="btn-gold btn-ingestion-submit">
                <i class="fas fa-arrow-right"></i> Get Started
              </button>
            </div>
          </form>
        </div>
        <div class="ingestion-footer-link">
          <span>Unsure how our execution pipeline works?</span>
          <a href="{{ route('how-it-works') }}" class="engine-learn-link">
            Learn How Our Engine Works <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Showcase Section -->
  <section class="about-section" id="about-us">
    <div class="container">
      <div class="about-grid">
        <div class="about-content-box">
          <div class="section-subtitle">Company Introduction</div>
          <h2 class="section-title">Built Around Relationships. Driven by Transactions.</h2>
          <p class="about-desc-text">
            MH Trade Capital Solutions is a Dubai-based trade and capital solutions firm supporting international businesses with trade finance, banking solutions, commodity trade assistance and structured financing requirements.
          </p>
          <p class="about-desc-text">
            With more than 11 years of professional experience and 40+ banking relationships worldwide, we take a transaction-first approach—understanding the underlying commercial activity, counterparties, documentation and requirements before identifying the appropriate financial or banking pathway.
          </p>
          <p class="about-desc-text" style="font-weight: 600; color: #FFFFFF;">
            Our focus is simple: understand the transaction, structure the requirement, and coordinate the appropriate solution.
          </p>

          <div class="about-highlights-grid">
            <div class="about-highlight-card">
              <div class="about-highlight-icon"><i class="fas fa-award"></i></div>
              <div class="about-highlight-info">
                <h4>11+ Years of Experience</h4>
                <p>Professional experience across trade finance and financial solutions.</p>
              </div>
            </div>
            <div class="about-highlight-card">
              <div class="about-highlight-icon"><i class="fas fa-building-columns"></i></div>
              <div class="about-highlight-info">
                <h4>40+ Banking Relationships</h4>
                <p>A broad network of banking relationships across international markets.*</p>
              </div>
            </div>
            <div class="about-highlight-card">
              <div class="about-highlight-icon"><i class="fas fa-globe"></i></div>
              <div class="about-highlight-info">
                <h4>Global Market Reach</h4>
                <p>Supporting cross-border business and commercial activity across international markets.</p>
              </div>
            </div>
            <div class="about-highlight-card">
              <div class="about-highlight-icon"><i class="fas fa-landmark"></i></div>
              <div class="about-highlight-info">
                <h4>Dubai-Based</h4>
                <p>Strategically positioned in Dubai, a global hub connecting Asia, Africa, Europe and the Middle East.</p>
              </div>
            </div>
          </div>

          <a href="{{ route('about') }}" class="btn-gold" style="display: inline-flex; margin-top: 10px;">
            <i class="fas fa-building"></i> Read Full Corporate Profile <i class="fas fa-arrow-right"></i>
          </a>
        </div>

        <div class="about-img-container">
          <img src="{{ asset('images/about_us_dubai.webp') }}" alt="MH Trade Capital Solutions Boardroom Dubai" class="about-img" loading="lazy" decoding="async">
          <div class="about-experience-badge">
            <div class="about-badge-icon"><i class="fas fa-award"></i></div>
            <div class="about-badge-text">
              <h4>11+ Years Experience</h4>
              <p>40+ Global Banking Relationships</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Client Testimonials Section -->
  <section class="testimonials-section" id="testimonials">
    <div class="container">
      <div class="section-header-wrapper">
        <div class="section-header text-left">
          <div class="section-subtitle">Client Endorsements &amp; Proof of Trust</div>
          <h2 class="section-title">Global Capital &amp; Trade Success Stories</h2>
          <p class="section-desc">Read how institutional buyers, sellers, energy developers, and corporate entities execute high-value transactions through MH Trade Capital Solutions.</p>
        </div>
        <div class="slider-controls">
          <button class="slider-btn" id="testimonial-prev" aria-label="Previous testimonial"><i class="fas fa-chevron-left"></i></button>
          <button class="slider-btn" id="testimonial-next" aria-label="Next testimonial"><i class="fas fa-chevron-right"></i></button>
        </div>
      </div>

      <div class="testimonials-slider-wrapper">
        <div class="testimonials-slider" id="testimonials-track">
          @forelse($testimonials as $testimonial)
          <div class="testimonial-slide">
            <div class="testimonial-card single-testimonial">
              <i class="fas fa-quote-right quote-watermark"></i>
              <div class="testimonial-grid-body">
                <div class="testimonial-author-left">
                  <div class="author-avatar-initials">{{ $testimonial->initials }}</div>
                  <div class="author-info">
                    <h4>{{ $testimonial->name }}</h4>
                    <p>{{ $testimonial->position }}, {{ $testimonial->company }}</p>
                    @if($testimonial->deal_size)
                    <div class="author-deal-size"><i class="fas fa-circle-check"></i> {{ $testimonial->deal_size }}</div>
                    @endif
                  </div>
                </div>
                <div class="testimonial-content-middle">
                  <div class="testimonial-top">
                    <div class="testimonial-stars">
                      <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    @if($testimonial->badge)
                    <div class="testimonial-badge"><i class="fas fa-shield-halved"></i> {{ $testimonial->badge }}</div>
                    @endif
                  </div>
                  <div class="testimonial-quote">"{!! $testimonial->quote !!}"</div>
                </div>
              </div>
            </div>
          </div>
          @empty
          {{-- Static fallback testimonials --}}
          <div class="testimonial-slide">
            <div class="testimonial-card single-testimonial">
              <i class="fas fa-quote-right quote-watermark"></i>
              <div class="testimonial-grid-body">
                <div class="testimonial-author-left">
                  <div class="author-avatar-initials">MV</div>
                  <div class="author-info">
                    <h4>Marcus Vance</h4>
                    <p>Managing Director, Global Energy Logistics Ltd</p>
                    <div class="author-deal-size"><i class="fas fa-circle-check"></i> $45,000,000 DLC Instrument</div>
                  </div>
                </div>
                <div class="testimonial-content-middle">
                  <div class="testimonial-top">
                    <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <div class="testimonial-badge"><i class="fas fa-shield-halved"></i> Verified LC Facility</div>
                  </div>
                  <p class="testimonial-quote">"MH Trade Capital structured our $45M Letter of Credit facility within 4 banking days when conventional lenders dragged for weeks. Their non-date reference tracking gave us complete confidentiality and flawless counterparty acceptance."</p>
                </div>
              </div>
            </div>
          </div>
          @endforelse
        </div>
      </div>

      <!-- Slide Dots Indicator -->
      <div class="testimonial-dots" id="testimonial-dots">
        @forelse($testimonials as $i => $t)
          <span class="dot {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}"></span>
        @empty
          <span class="dot active" data-slide="0"></span>
        @endforelse
      </div>

      <!-- Trust Standards Strip -->
      <div class="testimonial-trust-strip">
        <div class="trust-pill"><i class="fas fa-lock"></i> Confidential Non-Date Reference Tracking</div>
        <div class="trust-pill"><i class="fas fa-building-columns"></i> 40+ Banking Partners Worldwide</div>
        <div class="trust-pill"><i class="fas fa-bolt"></i> Fast Transaction Structuring</div>
        <div class="trust-pill"><i class="fas fa-file-contract"></i> Institutional Compliance Standards</div>
      </div>
    </div>
  </section>

  <!-- Trust Metrics Section -->
  <section class="trust-metrics-section" id="trust-metrics">
    <div class="container">
      <div class="section-header text-center">
        <div class="section-subtitle">Institutional Track Record</div>
        <h2 class="section-title">Proven Global Execution &amp; Metrics</h2>
        <p class="section-desc">Key performance benchmarks and trade facilitation volume executed directly through our Dubai operational desk.</p>
      </div>
      <div class="trust-metrics-grid">
        <div class="trust-metric-item">
          <div class="trust-metric-icon"><i class="fas fa-chart-line"></i></div>
          <h3>$1.8B+</h3>
          <p>Trade Volume Facilitated</p>
        </div>
        <div class="trust-metric-item">
          <div class="trust-metric-icon"><i class="fas fa-globe"></i></div>
          <h3>45+</h3>
          <p>Global Trade Destinations</p>
        </div>
        <div class="trust-metric-item">
          <div class="trust-metric-icon"><i class="fas fa-shield-halved"></i></div>
          <h3>99.4%</h3>
          <p>Compliance Execution Rate</p>
        </div>
        <div class="trust-metric-item">
          <div class="trust-metric-icon"><i class="fas fa-clock"></i></div>
          <h3>24 Hours</h3>
          <p>Dubai Desk SLA Response</p>
        </div>
      </div>
    </div>
  </section>

@endsection
