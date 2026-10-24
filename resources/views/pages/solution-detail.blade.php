@extends('layouts.public')

@section('title', $solution->title . ' | MH Trade Capital Solutions Dubai')
@section('meta_desc', $solution->short_desc)

@section('page_hero')
<section class="page-hero-section service-detail-hero" style="background-image: linear-gradient(180deg, rgba(7, 15, 30, 0.55) 0%, rgba(10, 25, 47, 0.65) 100%), url('{{ $solution->image_url }}');">
  <div class="container">
    <div class="hero-tag">
      <i class="fas fa-layer-group"></i> Solution {{ $solution->num }} — {{ $solution->title }}
    </div>
    
    <h1 class="page-hero-title">
      {!! format_title($solution->hero_headline ?: $solution->title) !!}
    </h1>

    @if($solution->badge)
    <div class="service-hero-badge">
      <i class="fas fa-tags"></i> {{ $solution->badge }}
    </div>
    @endif

    @if(filled(trim(strip_tags((string)($solution->overview ?: $solution->short_desc), '<img>'))))
    <p class="page-hero-desc">
      {{ $solution->overview ?: $solution->short_desc }}
    </p>
    @endif

    <div class="hero-btn-group">
      <button class="btn-gold open-inquiry-modal" data-vertical="{{ $solution->slug }}">
        <i class="fas fa-paper-plane"></i> Submit Requirement
      </button>
      <a href="{{ route('solutions') }}" class="btn-outline-gold">
        <i class="fas fa-list"></i> Browse All Solutions
      </a>
    </div>
  </div>
</section>
@endsection

@section('content')
<!-- Main Detail Content -->
<main class="container" style="padding: 70px 24px;">

  <!-- Executive Overview Section -->
  <section style="margin-bottom: 60px;">
    <div class="section-subtitle">Overview &amp; Framework</div>
    <h2 style="font-size: 32px; color: #FFFFFF; font-weight: 800; margin-bottom: 20px;">{{ $solution->title }}</h2>

    @if($solution->hasMeaningfulContent('overview'))
    <div style="font-size: 17px; color: #E2E8F0; line-height: 1.8; margin-bottom: 24px;">{!! $solution->overview !!}</div>
    @endif

    @if($solution->hasMeaningfulContent('process_text'))
    <div style="border-left: 3px solid var(--gold-primary); padding-left: 20px; margin: 28px 0;">
      <div style="font-size: 16px; color: #FFFFFF; line-height: 1.75; font-style: italic; margin: 0;">{!! $solution->process_text !!}</div>
    </div>
    @endif

    @if($solution->hasMeaningfulContent('highlight_banner'))
    <div style="border-left: 3px solid var(--gold-primary); padding-left: 20px; margin: 28px 0;">
      <h3 style="font-size: 20px; color: var(--gold-primary); font-weight: 700; margin: 0; line-height: 1.4;">
        <i class="fas fa-check-circle"></i> {{ $solution->highlight_banner }}
      </h3>
    </div>
    @endif
  </section>

  <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 50px 0;">

  <!-- Simplified Solution Items Breakdown (Card: Image -> Title -> Description only) -->
  @if($solution->items->count())
  <section style="margin-bottom: 70px;">
    <div class="section-subtitle">Detailed Capabilities</div>
    <h2 class="section-title" style="font-size: 30px; margin-bottom: 35px;">Key Services &amp; Frameworks</h2>

    <div class="solution-simple-grid">
      @foreach($solution->items as $item)
      <article class="solution-simple-card">
        <div class="simple-card-img-wrapper">
          <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="simple-card-img" loading="lazy">
          <div class="simple-card-overlay"></div>
        </div>
        <div class="simple-card-body">
          <h3 class="simple-card-title">{{ $item->title }}</h3>
          @if(filled(trim(strip_tags((string)$item->desc, '<img>'))))
          <p class="simple-card-desc">{{ $item->desc }}</p>
          @endif
        </div>
      </article>
      @endforeach
    </div>
  </section>

  <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 50px 0;">
  @endif

  <!-- Regulatory Compliance & Disclaimer Text Block -->
  <section style="margin-bottom: 60px;">
    <h4 style="font-size: 16px; color: var(--gold-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
      <i class="fas fa-shield-halved"></i> Transaction Compliance &amp; Disclaimer
    </h4>
    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.7; margin-bottom: 12px;">
      All financial, banking and trade finance solutions are subject to transaction assessment, KYC/AML and sanctions screening, due diligence, applicable laws and regulations, and the final approval of the relevant bank, financial institution or funding party.
    </p>
    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.7; margin: 0;">
      MH Trade Capital Solutions does not guarantee the issuance, acceptance or approval of any financial instrument, financing facility or banking solution.
    </p>
  </section>

  <!-- Bottom Action CTA -->
  <div style="text-align: center; padding: 40px 0 20px;">
    <h2 style="font-size: 28px; color: #FFFFFF; margin-bottom: 14px;">Structure Your {{ $solution->title }} Requirement</h2>
    <p style="color: var(--text-muted); font-size: 16px; margin-bottom: 24px;">Submit your requirement parameters directly to our Dubai operational desk to receive your tracking Request ID.</p>
    <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
      <button class="btn-gold open-inquiry-modal" data-vertical="{{ $solution->slug }}" style="font-size: 15px; padding: 16px 36px;">
        <i class="fas fa-paper-plane"></i> Submit Requirement Desk
      </button>
      <a href="{{ route('solutions') }}" class="btn-outline-gold">
        <i class="fas fa-list"></i> Browse All Solutions
      </a>
    </div>
  </div>

  <!-- Other Solutions -->
  @if($allSolutions->count() > 1)
  <div style="margin-top: 70px; padding-top: 50px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="section-subtitle" style="margin-bottom: 8px;">Explore Other Verticals</div>
    <h3 style="font-size: 24px; color: #FFFFFF; margin-bottom: 30px;">Related Capabilities</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
      @foreach($allSolutions->where('id', '!=', $solution->id)->take(3) as $other)
      <a href="{{ route('solutions.show', $other->slug) }}" class="vertical-card" style="text-decoration: none;">
        <div class="v-card-body">
          <h4 style="font-size: 17px; color: #FFFFFF; margin-bottom: 8px;">{{ $other->title }}</h4>
          <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 12px;">{{ Str::limit($other->short_desc, 100) }}</p>
          <span style="color: var(--gold-primary); font-weight: 700; font-size: 13px;">Explore <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif

</main>
@endsection
