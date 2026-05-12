/* ═══════════════════════════════════════════════════════════════
   Val POS — Shared JavaScript (v8)
   Language switcher · Mobile menu · Scroll reveal · FAQ
   ═══════════════════════════════════════════════════════════════ */

(function() {
  'use strict';

  const html = document.documentElement;

  // ═══ Language Switcher ═══
  function setLang(lang) {
    if (lang === 'ar') {
      html.setAttribute('lang', 'ar');
      html.setAttribute('dir', 'rtl');
      html.setAttribute('data-lang', 'ar');
    } else {
      html.setAttribute('lang', 'en');
      html.setAttribute('dir', 'ltr');
      html.setAttribute('data-lang', 'en');
    }
    document.querySelectorAll('[data-lang-btn="ar"]').forEach(b => b.classList.toggle('active', lang === 'ar'));
    document.querySelectorAll('[data-lang-btn="en"]').forEach(b => b.classList.toggle('active', lang === 'en'));
    try { localStorage.setItem('valpos-lang', lang); } catch(e) {}
  }

  // Init lang
  document.addEventListener('DOMContentLoaded', () => {
    let saved = 'ar';
    try { saved = localStorage.getItem('valpos-lang') || 'ar'; } catch(e) {}
    if (saved === 'en') setLang('en');

    // bind buttons
    document.querySelectorAll('[data-lang-btn="ar"]').forEach(b => b.addEventListener('click', () => setLang('ar')));
    document.querySelectorAll('[data-lang-btn="en"]').forEach(b => b.addEventListener('click', () => setLang('en')));
  });

  // ═══ Mobile Menu ═══
  document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('menuToggle');
    const menu = document.getElementById('mobileMenu');
    if (toggle && menu) {
      toggle.addEventListener('click', () => {
        menu.classList.toggle('open');
        document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
      });
      menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
          menu.classList.remove('open');
          document.body.style.overflow = '';
        });
      });
    }
  });

  // ═══ Nav scroll effect ═══
  document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('.nav');
    if (!nav) return;
    const onScroll = () => {
      if (window.scrollY > 20) nav.classList.add('scrolled');
      else nav.classList.remove('scrolled');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  });

  // ═══ Scroll Reveal ═══
  document.addEventListener('DOMContentLoaded', () => {
    if (!('IntersectionObserver' in window)) {
      document.querySelectorAll('.reveal').forEach(el => el.classList.add('in'));
      return;
    }
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
  });

  // ═══ FAQ Accordion ═══
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.faq-q').forEach(btn => {
      btn.addEventListener('click', () => {
        const item = btn.parentElement;
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
      });
    });
  });

  // ═══ Smooth scroll without # ═══
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
      link.addEventListener('click', function(e) {
        const id = this.getAttribute('href').replace('#', '');
        if (!id) return;
        const target = document.getElementById(id);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          history.replaceState(null, '', window.location.pathname);
        }
      });
    });
  });

  // ═══ Pricing toggle ═══
  document.addEventListener('DOMContentLoaded', () => {
    const monthlyBtn = document.getElementById('monthlyBtn');
    const yearlyBtn = document.getElementById('yearlyBtn');
    if (!monthlyBtn || !yearlyBtn) return;
    const amounts = document.querySelectorAll('[data-monthly]');
    const periodLabels = document.querySelectorAll('.period-label');
    const arabicNum = (n) => n.toString().replace(/\d/g, d => '٠١٢٣٤٥٦٧٨٩'[d]);
    const update = (period) => {
      amounts.forEach(el => {
        const val = el.dataset[period];
        const lang = html.getAttribute('data-lang') || 'ar';
        el.textContent = lang === 'ar' ? arabicNum(val) : val;
      });
      const lang = html.getAttribute('data-lang') || 'ar';
      const monthLabel = lang === 'ar' ? 'شهر' : 'month';
      const yearLabel = lang === 'ar' ? 'سنة' : 'year';
      periodLabels.forEach(el => el.textContent = period === 'monthly' ? monthLabel : yearLabel);
    };
    monthlyBtn.addEventListener('click', () => {
      monthlyBtn.classList.add('active'); yearlyBtn.classList.remove('active');
      update('monthly');
    });
    yearlyBtn.addEventListener('click', () => {
      yearlyBtn.classList.add('active'); monthlyBtn.classList.remove('active');
      update('yearly');
    });
    update('monthly');
  });

  // ═══ Auto-replace image placeholders ═══
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.img-placeholder[data-src]').forEach(ph => {
      const src = ph.getAttribute('data-src');
      const img = new Image();
      img.onload = () => {
        ph.innerHTML = '';
        ph.classList.add('loaded');
        img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:inherit;';
        ph.appendChild(img);
      };
      img.src = src;
    });
  });

})();
