'use strict';

document.addEventListener('DOMContentLoaded', function () {
    if (typeof AOS !== 'undefined') {
        AOS.init({ once: true, duration: 800, offset: 100 });
    }

    if (typeof GLightbox !== 'undefined') {
        GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true,
            draggable: true,
            closeButton: true,
            descPosition: 'bottom',
        });
    }

    var nav = document.querySelector('.navbar');
    if (nav) {
        window.addEventListener('scroll', function () {
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        var id = a.getAttribute('href');
        if (!id || id === '#' || id.length < 2) return;
        var target = document.querySelector(id);
        if (!target) return;
        a.addEventListener('click', function (e) {
            if (a.getAttribute('data-no-smooth') !== null) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            history.pushState(null, '', id);
        });
    });

    document.querySelectorAll('.wincon-video-card').forEach(function (card) {
        var wrap = card.querySelector('.video-thumb-wrap');
        var url = card.getAttribute('data-embed-url');
        if (!wrap || !url) return;

        function play() {
            var iframe = document.createElement('iframe');
            iframe.src = url;
            iframe.title = 'YouTube video';
            iframe.setAttribute('allowfullscreen', 'allowfullscreen');
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
            iframe.className = 'w-100 h-100 border-0';
            iframe.style.position = 'absolute';
            iframe.style.inset = '0';
            var holder = document.createElement('div');
            holder.className = 'ratio ratio-16x9 position-relative bg-dark';
            holder.appendChild(iframe);
            wrap.replaceWith(holder);
        }

        var overlay = wrap.querySelector('.video-play-overlay');
        if (overlay) {
            overlay.addEventListener('click', play);
            overlay.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    play();
                }
            });
        }
    });

    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            var msg = contactForm.querySelector('[name="message"]');
            var email = contactForm.querySelector('[name="email"]');
            var name = contactForm.querySelector('[name="full_name"]');
            var ok = true;
            if (name && name.value.trim().length < 2) ok = false;
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) ok = false;
            if (msg && msg.value.trim().length < 10) ok = false;
            if (!ok) {
                e.preventDefault();
                alert('Please fill in all fields. Your message should be at least 10 characters.');
            }
        });
    }

    (function vanillaLightbox() {
        var overlay = document.createElement('div');
        overlay.className = 'wincon-lb-overlay';
        overlay.innerHTML = '<button type="button" class="wincon-lb-close" aria-label="Close">&times;</button><img alt="">';
        overlay.style.cssText = 'display:none;position:fixed;inset:0;z-index:1080;background:rgba(0,0,0,.9);align-items:center;justify-content:center;padding:2rem;';
        var img = overlay.querySelector('img');
        img.style.cssText = 'max-width:100%;max-height:90vh;object-fit:contain;';
        var closeBtn = overlay.querySelector('.wincon-lb-close');
        closeBtn.style.cssText = 'position:absolute;top:1rem;right:1rem;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer;';
        document.body.appendChild(overlay);

        function close() {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
        closeBtn.addEventListener('click', close);
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) close();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay.style.display === 'flex') close();
        });

        document.querySelectorAll('a.wincon-lightbox-native').forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                img.src = a.getAttribute('href') || '';
                overlay.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });
    })();

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (en) {
                    if (en.isIntersecting) {
                        en.target.classList.add('io-visible');
                        io.unobserve(en.target);
                    }
                });
            },
            { rootMargin: '0px 0px -40px 0px', threshold: 0.08 }
        );
        document.querySelectorAll('.io-reveal').forEach(function (el) {
            io.observe(el);
        });
    }
});
