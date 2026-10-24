<!-- Footer -->
<footer class="main-footer" id="contact">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="{{ route('home') }}" class="brand-logo-link" style="margin-bottom: 16px;">
          <div class="brand-logo-img-box">
            <img src="{{ content_image_url(\App\Models\CmsSetting::getValue('site_logo'), 'images/logo/main-logo.png') }}" alt="MH Trade Capital Solutions Logo" class="brand-logo-img">
          </div>
        </a>
        <p>MH Trade Capital Solutions is a Dubai-based B2B trade finance, commodity sourcing, project funding, and UAE corporate banking facilitation platform.</p>
      </div>

      <div>
        <h4 class="footer-title">Financial Verticals</h4>
        <ul class="footer-links-list">
          @php
            $footerSolutions = \App\Models\Solution::published()->take(5)->get();
          @endphp
          @foreach($footerSolutions as $fSol)
            <li><a href="{{ route('solutions.show', $fSol->slug) }}">{{ $fSol->title }}</a></li>
          @endforeach
        </ul>
      </div>

      <div>
        <h4 class="footer-title">General Inquiries</h4>
        <ul class="footer-links-list">
          <li><a href="{{ route('why-mh') }}">Why MH — Dubai Advantage</a></li>
          <li><a href="{{ route('contact') }}">Contact Commercial Desk</a></li>
          <li><a href="{{ route('solutions.show', 'general-inquiry') }}">UAE Sourcing &amp; Procurement</a></li>
          <li><a href="{{ route('solutions') }}">Browse All Capabilities</a></li>
        </ul>
      </div>

      <div>
        <h4 class="footer-title">Dubai Headquarters</h4>
        <ul class="footer-contact-list">
          @php
            $footerContact = isset($contact) ? $contact : \App\Models\CmsSetting::getGroup('contact');
            $footerSocial  = \App\Models\CmsSetting::getGroup('social');
          @endphp
          @if(!empty($footerContact['whatsapp']))
          <li>
            <i class="fab fa-whatsapp" style="color: #25D366;"></i>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerContact['whatsapp']) }}" target="_blank" rel="noopener noreferrer">{{ $footerContact['whatsapp'] }}</a>
          </li>
          @endif
          @if(!empty($footerSocial['linkedin']))
          <li>
            <i class="fab fa-linkedin" style="color: #0A66C2;"></i>
            <a href="{{ $footerSocial['linkedin'] }}" target="_blank" rel="noopener noreferrer">LinkedIn Profile</a>
          </li>
          @endif
          @if(!empty($footerContact['email']))
          <li>
            <i class="fas fa-envelope" style="color: var(--gold-primary);"></i>
            <a href="mailto:{{ $footerContact['email'] }}">{{ $footerContact['email'] }}</a>
          </li>
          @endif
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <div>&copy; MH Trade Capital Solutions. All Rights Reserved.</div>
      <div>Designed and developed by <a style="color: var(--gold-primary); font-size: 15px; font-weight: 500;" href="javascript:void(0);">Mashud Rana</a></div>
    </div>
  </div>
</footer>
