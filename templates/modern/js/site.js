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

    /* ---- Owl Carousel navigation ---- */
    function initCarousels() {
        if (typeof $ === 'undefined' || !$.fn.owlCarousel) return;
        document.querySelectorAll('#js-carousel').forEach(function (el) {
            var $el = $(el);
            var owl = $el.find('.owl-carousel').owlCarousel();
            $el.find('.js-prev').on('click', function () { owl.trigger('prev.owl.carousel'); });
            $el.find('.js-next').on('click', function () { owl.trigger('next.owl.carousel'); });

            function updateNav() {
                var show = $el.find('.owl-stage').width() / $(window).width() > 0.84 && $(window).width() > 767;
                $el.find('.js-prev, .js-next').css('display', show ? 'inline-block' : 'none');
            }
            $(window).on('resize', updateNav);
            updateNav();
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

    document.addEventListener('DOMContentLoaded', function () {
        initCardClick();
        initShareButtons();
        initCarousels();
    });
})();
