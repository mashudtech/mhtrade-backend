<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'MH Trade Capital Solutions — B2B Trade Finance, Commodity Sourcing & UAE Banking')</title>
  <meta name="description" content="@yield('meta_desc', 'Dubai-based B2B Trade Finance (LC / SBLC), Commodity Sourcing, Project Finance, and UAE Corporate Banking platform.')">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo/MH-logo-icon-512.png') }}">

  <!-- Font Awesome Icons (Self-Hosted) -->
  <link rel="preload" href="{{ asset('fonts/fontawesome/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="{{ asset('fonts/fontawesome/webfonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/all.min.css') }}">

  <!-- Main Stylesheet -->
  @php $cssV = file_exists(public_path('css/style.css')) ? filemtime(public_path('css/style.css')) : '1'; @endphp
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ $cssV }}">

  @stack('styles')
</head>
<body>

  <!-- Dynamic Canvas Background -->
  <canvas id="bg-canvas"></canvas>

  <div class="site-wrapper">

    @hasSection('hero')
    {{-- Full-viewport hero: header + hero share the 100vh wrapper --}}
    <div class="hero-viewport-wrapper" id="hero-viewport">
    @endif

      <!-- Main Navigation Header -->
      <div class="main-header-wrapper">
        <header class="main-header">
          <div class="container navbar">
            <a href="{{ route('home') }}" class="brand-logo-link">
              <div class="brand-logo-img-box">
                <img src="{{ content_image_url(\App\Models\CmsSetting::getValue('site_logo'), 'images/logo/main-logo.png') }}" alt="MH Trade Capital Solutions Logo" class="brand-logo-img">
              </div>
            </a>

            <ul class="nav-links">
              <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link nav-home-link" aria-label="Home" title="Home"><i class="fas fa-home"></i></a>
              </li>
              <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                <a href="{{ route('about') }}" class="nav-link">About Us</a>
              </li>
              <li class="nav-item {{ request()->routeIs('solutions*') ? 'active' : '' }}">
                <a href="{{ route('solutions') }}" class="nav-link">Solutions <i class="fas fa-chevron-down" style="font-size:10px;"></i></a>
                @php
                  $navSolutions = \App\Models\Solution::published()->get();
                @endphp
                @if($navSolutions->isNotEmpty())
                <ul class="dropdown-menu">
                  @foreach($navSolutions as $navSol)
                    <li class="dropdown-item"><a href="{{ route('solutions.show', $navSol->slug) }}">{{ $navSol->title }}</a></li>
                  @endforeach
                </ul>
                @endif
              </li>
              <li class="nav-item {{ request()->routeIs('why-mh') ? 'active' : '' }}">
                <a href="{{ route('why-mh') }}" class="nav-link">Why MH</a>
              </li>
              <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
              </li>
            </ul>

            <!-- Mobile Navigation Toggle -->
            <button class="mobile-nav-toggle" id="mobile-nav-toggle" aria-label="Toggle navigation menu">
              <i class="fas fa-bars"></i>
            </button>
          </div>
        </header>
      </div>

      @hasSection('hero')
      <!-- Hero Section (inside the 100vh wrapper) -->
      @yield('hero')
    </div>{{-- /hero-viewport-wrapper --}}
    @endif

    @unless(View::hasSection('hero'))
      @yield('page_hero')
    @endunless

    <!-- Main Page Content -->
    @yield('content')

    @include('partials.footer')

  </div>{{-- /site-wrapper --}}

  @include('partials.inquiry-modal')

  @php $jsV = file_exists(public_path('js/main.js')) ? filemtime(public_path('js/main.js')) : '1'; @endphp
  <script src="{{ asset('js/main.js') }}?v={{ $jsV }}"></script>

  @stack('scripts')
</body>
</html>
