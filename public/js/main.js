/**
 * MH Trade Capital Solutions — Main Interactive Script
 * - Animated Node Network Canvas
 * - Sticky Header Scroll Effects
 * - Dynamic Verticals & Inquiry Modal Management
 * - Client-Side Request ID Preview Generation
 */

document.addEventListener('DOMContentLoaded', () => {

  // Initialize Animated Background Canvas
  initBackgroundCanvas();

  // Header Scroll Effect & Back-to-Top Button Toggle (Throttled 60fps)
  const header = document.querySelector('.main-header');
  const backToTopBtn = document.getElementById('back-to-top');
  let scrollTicking = false;

  window.addEventListener('scroll', () => {
    if (!scrollTicking) {
      window.requestAnimationFrame(() => {
        const scrollY = window.scrollY;
        if (scrollY > 40) {
          header?.classList.add('scrolled');
        } else {
          header?.classList.remove('scrolled');
        }

        if (scrollY > 300) {
          backToTopBtn?.classList.add('visible');
        } else {
          backToTopBtn?.classList.remove('visible');
        }
        scrollTicking = false;
      });
      scrollTicking = true;
    }
  }, { passive: true });

  backToTopBtn?.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId && targetId !== '#') {
        const targetElem = document.querySelector(targetId);
        if (targetElem) {
          e.preventDefault();
          targetElem.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });

  // Global Mobile Navigation Toggle Function
  const navLinks = document.querySelector('.nav-links');
  const mobileNavToggle = document.getElementById('mobile-nav-toggle');

  window.toggleMobileMenu = function(forceState) {
    if (!navLinks) return;
    
    const shouldOpen = (typeof forceState === 'boolean')
      ? forceState
      : !navLinks.classList.contains('mobile-active');

    if (shouldOpen) {
      navLinks.classList.add('mobile-active');
    } else {
      navLinks.classList.remove('mobile-active');
    }

    if (mobileNavToggle) {
      mobileNavToggle.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
      const icon = mobileNavToggle.querySelector('i');
      if (icon) {
        icon.className = shouldOpen ? 'fas fa-xmark' : 'fas fa-bars';
      }
    }
  };

  // Mobile Navigation Menu Toggle Event Listener
  mobileNavToggle?.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    window.toggleMobileMenu();
  });

  // Close mobile navigation when clicking outside
  document.addEventListener('click', (e) => {
    if (navLinks && navLinks.classList.contains('mobile-active')) {
      if (!navLinks.contains(e.target) && !mobileNavToggle?.contains(e.target)) {
        window.toggleMobileMenu(false);
      }
    }
  });

  // Mobile Dropdown Toggle Handler (e.g. Solutions)
  const dropdownNavItems = document.querySelectorAll('.nav-item');
  dropdownNavItems.forEach(item => {
    const link = item.querySelector('.nav-link');
    const dropdown = item.querySelector('.dropdown-menu');
    if (dropdown && link) {
      link.addEventListener('click', (e) => {
        if (window.innerWidth <= 992) {
          e.preventDefault();
          e.stopPropagation();
          dropdown.classList.toggle('mobile-open');
        }
      });
    }
  });

  // Verticals Slider Controls Handler (Unlimited Infinite Loop + Auto-Play)
  const verticalsGridWrapper = document.querySelector('.verticals-grid-wrapper');
  const verticalsPrevBtn = document.getElementById('verticals-prev');
  const verticalsNextBtn = document.getElementById('verticals-next');

  function slideNext() {
    if (!verticalsGridWrapper) return;
    const card = verticalsGridWrapper.querySelector('.vertical-card');
    const scrollAmount = (card?.offsetWidth || 300) + 24;
    const maxScroll = verticalsGridWrapper.scrollWidth - verticalsGridWrapper.clientWidth;

    if (verticalsGridWrapper.scrollLeft >= maxScroll - 15) {
      verticalsGridWrapper.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      verticalsGridWrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
  }

  function slidePrev() {
    if (!verticalsGridWrapper) return;
    const card = verticalsGridWrapper.querySelector('.vertical-card');
    const scrollAmount = (card?.offsetWidth || 300) + 24;
    const maxScroll = verticalsGridWrapper.scrollWidth - verticalsGridWrapper.clientWidth;

    if (verticalsGridWrapper.scrollLeft <= 15) {
      verticalsGridWrapper.scrollTo({ left: maxScroll, behavior: 'smooth' });
    } else {
      verticalsGridWrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
  }

  verticalsNextBtn?.addEventListener('click', () => {
    slideNext();
    resetAutoSlide();
  });

  verticalsPrevBtn?.addEventListener('click', () => {
    slidePrev();
    resetAutoSlide();
  });

  // Verticals auto-slide (runs only when in viewport)
  let autoSlideTimer = null;

  function startAutoSlide() {
    if (autoSlideTimer) return;
    autoSlideTimer = setInterval(slideNext, 4500);
  }

  function stopAutoSlide() {
    if (autoSlideTimer) {
      clearInterval(autoSlideTimer);
      autoSlideTimer = null;
    }
  }

  function resetAutoSlide() {
    stopAutoSlide();
    startAutoSlide();
  }

  if (verticalsGridWrapper && 'IntersectionObserver' in window) {
    const verticalsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          startAutoSlide();
        } else {
          stopAutoSlide();
        }
      });
    }, { threshold: 0.15 });
    verticalsObserver.observe(verticalsGridWrapper);
  } else {
    startAutoSlide();
  }

  // Pause auto-slide when interacting with slider
  verticalsGridWrapper?.addEventListener('mouseenter', stopAutoSlide);
  verticalsGridWrapper?.addEventListener('mouseleave', startAutoSlide);
  verticalsGridWrapper?.addEventListener('touchstart', stopAutoSlide, { passive: true });
  verticalsGridWrapper?.addEventListener('touchend', startAutoSlide);

  // Testimonials Single-Item Slider Handler (Infinite Loop + Viewport-Aware Auto-Play)
  const testimonialTrack = document.getElementById('testimonials-track');
  const testimonialPrevBtn = document.getElementById('testimonial-prev');
  const testimonialNextBtn = document.getElementById('testimonial-next');
  const testimonialDots = document.querySelectorAll('#testimonial-dots .dot');
  let currentTestimonialIndex = 0;

  function updateTestimonialSlide(index) {
    if (!testimonialTrack) return;
    const slides = testimonialTrack.querySelectorAll('.testimonial-slide');
    if (slides.length === 0) return;
    currentTestimonialIndex = (index + slides.length) % slides.length;
    testimonialTrack.style.transform = `translateX(-${currentTestimonialIndex * 100}%)`;

    testimonialDots.forEach((dot, idx) => {
      if (idx === currentTestimonialIndex) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }

  testimonialNextBtn?.addEventListener('click', () => {
    updateTestimonialSlide(currentTestimonialIndex + 1);
    resetTestimonialAutoSlide();
  });

  testimonialPrevBtn?.addEventListener('click', () => {
    updateTestimonialSlide(currentTestimonialIndex - 1);
    resetTestimonialAutoSlide();
  });

  testimonialDots.forEach((dot, idx) => {
    dot.addEventListener('click', () => {
      updateTestimonialSlide(idx);
      resetTestimonialAutoSlide();
    });
  });

  // Testimonials auto-play (runs only when in viewport)
  let testimonialTimer = null;

  function startTestimonialAutoSlide() {
    if (testimonialTimer) return;
    testimonialTimer = setInterval(() => {
      updateTestimonialSlide(currentTestimonialIndex + 1);
    }, 5500);
  }

  function stopTestimonialAutoSlide() {
    if (testimonialTimer) {
      clearInterval(testimonialTimer);
      testimonialTimer = null;
    }
  }

  function resetTestimonialAutoSlide() {
    stopTestimonialAutoSlide();
    startTestimonialAutoSlide();
  }

  const testimonialWrapper = document.querySelector('.testimonials-slider-wrapper');
  if (testimonialWrapper && 'IntersectionObserver' in window) {
    const testimonialObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          startTestimonialAutoSlide();
        } else {
          stopTestimonialAutoSlide();
        }
      });
    }, { threshold: 0.15 });
    testimonialObserver.observe(testimonialWrapper);
  } else {
    startTestimonialAutoSlide();
  }

  testimonialWrapper?.addEventListener('mouseenter', stopTestimonialAutoSlide);
  testimonialWrapper?.addEventListener('mouseleave', startTestimonialAutoSlide);
  testimonialWrapper?.addEventListener('touchstart', stopTestimonialAutoSlide, { passive: true });
  testimonialWrapper?.addEventListener('touchend', startTestimonialAutoSlide);

  // Modal Drawer Elements
  const modalOverlay = document.getElementById('inquiry-modal');
  const closeModalBtns = document.querySelectorAll('.close-modal');
  const openModalBtns = document.querySelectorAll('.open-inquiry-modal');
  const verticalSelect = document.getElementById('req-vertical');
  const inquiryForm = document.getElementById('inquiry-form');
  const modalFormContainer = document.getElementById('modal-form-container');
  const modalSuccessContainer = document.getElementById('modal-success-container');
  const assignedIdDisplay = document.getElementById('assigned-request-id');

  // Open Modal Handler
  openModalBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const targetVertical = btn.getAttribute('data-vertical') || 'general';
      if (verticalSelect) {
        verticalSelect.value = targetVertical;
      }
      resetFormState();
      modalOverlay?.classList.add('active');
    });
  });

  // Close Modal Handler
  closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      modalOverlay?.classList.remove('active');
    });
  });

  // Light dismiss on backdrop click
  modalOverlay?.addEventListener('click', (e) => {
    if (e.target === modalOverlay) {
      modalOverlay.classList.remove('active');
    }
  });

  // Quick Hero Ingestion Form Handler
  const heroIngestionForm = document.getElementById('hero-ingestion-form');
  heroIngestionForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const selectedVertical = document.getElementById('hero-vertical-select')?.value || 'general';
    if (verticalSelect) {
      verticalSelect.value = selectedVertical;
    }
    resetFormState();
    modalOverlay?.classList.add('active');
  });

  // Inquiry Form Submission (Interactive Preview Response)
  inquiryForm?.addEventListener('submit', (e) => {
    e.preventDefault();

    const selectedVertical = verticalSelect ? verticalSelect.value : 'general';
    const generatedId = generateRequestId(selectedVertical);

    // Show Assigned Request ID
    if (assignedIdDisplay) {
      assignedIdDisplay.textContent = generatedId;
    }

    // Toggle Form to Success Screen
    if (modalFormContainer && modalSuccessContainer) {
      modalFormContainer.style.display = 'none';
      modalSuccessContainer.style.display = 'block';
    }
  });

  function resetFormState() {
    if (modalFormContainer && modalSuccessContainer) {
      modalFormContainer.style.display = 'block';
      modalSuccessContainer.style.display = 'none';
    }
    inquiryForm?.reset();
  }

  // Sequential Non-Date Request ID Generator Preview
  function generateRequestId(vertical) {
    const prefixes = {
      'lc': 'MH-LC',
      'sblc': 'MH-SBLC',
      'commodity': 'MH-COM',
      'project': 'MH-PROJ',
      'uae-banking': 'MH-BANK',
      'general': 'MH-REQ'
    };
    const prefix = prefixes[vertical] || 'MH-REQ';
    const randomSeq = String(Math.floor(Math.random() * 900) + 100).padStart(5, '0');
    return `${prefix}-${randomSeq}`;
  }

  // Dynamic Background Canvas — High-Performance Financial Constellation Network
  function initBackgroundCanvas() {
    const canvas = document.getElementById('bg-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = canvas.width = window.innerWidth;
    let height = canvas.height = window.innerHeight;

    let mouse = { x: null, y: null, radius: 170 };
    let resizeTimer;

    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
      }, 150);
    }, { passive: true });

    window.addEventListener('mousemove', (e) => {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    }, { passive: true });

    window.addEventListener('mouseleave', () => {
      mouse.x = null;
      mouse.y = null;
    }, { passive: true });

    // Adaptive node count based on screen size for optimal 60fps performance
    const isMobile = width < 768;
    const numNodes = isMobile ? 22 : Math.min(Math.floor(width / 32), 40);
    const nodes = [];

    for (let i = 0; i < numNodes; i++) {
      const isMajorHub = Math.random() < 0.25;
      nodes.push({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * 0.45,
        vy: (Math.random() - 0.5) * 0.45,
        radius: isMajorHub ? Math.random() * 2 + 2.5 : Math.random() * 1.5 + 1.2,
        isMajorHub: isMajorHub,
        pulseAngle: Math.random() * Math.PI * 2
      });
    }

    const maxDist = 160;
    const maxDistSq = maxDist * maxDist;
    let isPaused = false;

    document.addEventListener('visibilitychange', () => {
      isPaused = document.hidden;
      if (!isPaused) {
        requestAnimationFrame(animate);
      }
    });

    function animate() {
      if (isPaused) return;

      ctx.clearRect(0, 0, width, height);

      // 1. Update node positions & draw nodes
      for (let i = 0; i < nodes.length; i++) {
        const n = nodes[i];
        n.x += n.vx;
        n.y += n.vy;
        n.pulseAngle += 0.025;

        if (n.x < 0 || n.x > width) n.vx *= -1;
        if (n.y < 0 || n.y > height) n.vy *= -1;

        let currentRadius = n.radius;
        if (n.isMajorHub) {
          currentRadius += Math.sin(n.pulseAngle) * 0.7;

          // Draw soft hardware-accelerated outer aura (no expensive shadowBlur)
          ctx.beginPath();
          ctx.arc(n.x, n.y, currentRadius * 2.2, 0, Math.PI * 2);
          ctx.fillStyle = 'rgba(245, 158, 11, 0.16)';
          ctx.fill();
        }

        // Draw core node
        ctx.beginPath();
        ctx.arc(n.x, n.y, Math.max(0.5, currentRadius), 0, Math.PI * 2);
        ctx.fillStyle = n.isMajorHub ? 'rgba(245, 158, 11, 0.9)' : 'rgba(212, 175, 55, 0.65)';
        ctx.fill();

        // Connect node to mouse if within distance
        if (mouse.x !== null && mouse.y !== null) {
          const dx = n.x - mouse.x;
          const dy = n.y - mouse.y;
          const distSq = dx * dx + dy * dy;
          if (distSq < mouse.radius * mouse.radius) {
            const mDist = Math.sqrt(distSq);
            const mAlpha = 0.45 * (1 - mDist / mouse.radius);
            ctx.beginPath();
            ctx.moveTo(n.x, n.y);
            ctx.lineTo(mouse.x, mouse.y);
            ctx.strokeStyle = `rgba(245, 158, 11, ${mAlpha})`;
            ctx.lineWidth = 1;
            ctx.stroke();
          }
        }
      }

      // 2. Batch-draw all constellation connection lines in a single path
      ctx.beginPath();
      for (let i = 0; i < nodes.length; i++) {
        const n = nodes[i];
        for (let j = i + 1; j < nodes.length; j++) {
          const n2 = nodes[j];
          const dx = n.x - n2.x;
          const dy = n.y - n2.y;
          const distSq = dx * dx + dy * dy;

          if (distSq < maxDistSq) {
            ctx.moveTo(n.x, n.y);
            ctx.lineTo(n2.x, n2.y);
          }
        }
      }
      ctx.strokeStyle = 'rgba(212, 175, 55, 0.22)';
      ctx.lineWidth = 0.85;
      ctx.stroke();

      requestAnimationFrame(animate);
    }

    animate();
  }

});
