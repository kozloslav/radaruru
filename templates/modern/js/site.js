(function () {
    'use strict';

    /* ---- Card click navigation ---- */
    function initCardClick() {
        document.querySelectorAll('.r-content_list_item').forEach(function (el) {
            el.addEventListener('click', function (e) {
                if (!e.target.closest('a, .r-dist-btn, .arrow')) {
                    window.location.href = el.dataset.link;
                }
            });
        });
    }

    /* ---- Menu nav scroll ---- */
    function initMenuNav() {
        document.querySelectorAll('#js-menu-nav').forEach(function (nav) {
            var track = nav.querySelector('.r-menu-track');
            var prev  = nav.querySelector('.r-menu-prev');
            var next  = nav.querySelector('.r-menu-next');
            if (!track) return;

            function updateArrows() {
                var overflows = track.scrollWidth > track.clientWidth + 2;
                if (prev) prev.classList.toggle('r-menu-arrow--visible', overflows && track.scrollLeft > 4);
                if (next) next.classList.toggle('r-menu-arrow--visible', overflows && track.scrollLeft < track.scrollWidth - track.clientWidth - 4);
            }

            if (prev) prev.addEventListener('click', function () { track.scrollBy({ left: -180, behavior: 'smooth' }); });
            if (next) next.addEventListener('click', function () { track.scrollBy({ left: 180, behavior: 'smooth' }); });

            track.addEventListener('scroll', updateArrows, { passive: true });
            window.addEventListener('resize', updateArrows);
            updateArrows();
        });
    }

    /* ---- Copy promo code ---- */
    window.copyToClipboard = function (itemId) {
        var el = document.getElementById('promokod-' + itemId);
        if (!el) return;
        var text = el.innerText.trim();
        var done = function () { showCopyToast(); };
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(done).catch(done);
        } else {
            var tmp = document.createElement('input');
            tmp.value = text;
            document.body.appendChild(tmp);
            tmp.select();
            document.execCommand('copy');
            document.body.removeChild(tmp);
            done();
        }
    };

    function showCopyToast() {
        var msg = document.getElementById('copy-message');
        if (!msg) return;
        msg.style.display = 'block';
        msg.style.opacity = '1';
        setTimeout(function () {
            msg.style.opacity = '0';
            setTimeout(function () { msg.style.display = 'none'; }, 500);
        }, 1500);
    }

    /* ---- Share modal ---- */
    function initShareButtons() {
        document.querySelectorAll('.r-dist-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var rawUrl = decodeURIComponent(this.dataset.url || '');
                var url    = encodeURIComponent(rawUrl);
                var title  = this.dataset.title || '';

                var html = '<div class="share-options">'
                    + '<button class="copy-link-btn" data-url="' + rawUrl + '">Копировать ссылку</button>'
                    + '<hr class="share-separator">'
                    + '<a href="https://vk.com/share.php?url=' + url + '&title=' + title + '" class="share-btn vk" target="_blank" rel="noopener">ВКонтакте</a>'
                    + '<a href="https://connect.ok.ru/offer?url=' + url + '&title=' + title + '" class="share-btn ok" target="_blank" rel="noopener">Одноклассники</a>'
                    + '<a href="https://t.me/share/url?url=' + url + '&text=' + title + '" class="share-btn telegram" target="_blank" rel="noopener">Telegram</a>'
                    + '<a href="https://api.whatsapp.com/send?text=' + title + '%20' + url + '" class="share-btn whatsapp" target="_blank" rel="noopener">WhatsApp</a>'
                    + '</div>';

                icms.modal.openHtml(html, 'Поделиться', this.dataset.style || 'sm');

                setTimeout(function () {
                    document.querySelectorAll('.copy-link-btn').forEach(function (copyBtn) {
                        copyBtn.addEventListener('click', function () {
                            var b = this;
                            navigator.clipboard.writeText(b.dataset.url).then(function () {
                                var orig = b.textContent;
                                b.textContent = 'Ссылка скопирована!';
                                b.style.background = '#d1fae5';
                                setTimeout(function () {
                                    b.textContent = orig;
                                    b.style.background = '';
                                }, 2000);
                            });
                        });
                    });
                }, 100);
            });
        });
    }

    /* ---- "Не актуально" button ---- */
    function initNotActualButtons() {
        document.querySelectorAll('.r-not-actual-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (btn.classList.contains('is-busy') || btn.disabled) {
                    return;
                }

                btn.classList.add('is-busy');

                fetch(btn.dataset.url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(function (response) { return response.json(); })
                    .then(function (result) {
                        btn.classList.remove('is-busy');
                        btn.disabled = true;
                        btn.classList.add('r-not-actual-btn--done');
                        var span = btn.querySelector('span');
                        if (span) {
                            span.textContent = result.message || btn.dataset.sentText;
                        }
                    })
                    .catch(function () {
                        btn.classList.remove('is-busy');
                    });
            });
        });
    }

    /* ---- Light/dark theme switcher ---- */
    function initThemeSwitcher() {
        var btn = document.getElementById('theme-switcher');
        if (!btn) return;

        btn.addEventListener('click', function () {
            var current = document.documentElement.getAttribute('data-theme') || 'light';
            var next = current === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', next);

            try {
                localStorage.setItem('icms_theme', next);
            } catch (e) {}
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initCardClick();
        initShareButtons();
        initMenuNav();
        initNotActualButtons();
        initThemeSwitcher();
    });
})();
