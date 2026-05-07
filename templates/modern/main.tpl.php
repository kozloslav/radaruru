<?php
/**
 * Основной макет шаблона
 * https://docs.instantcms.ru/dev/templates/layouts
 */
/** @var cmsTemplate $this */
?>
<!DOCTYPE html>
<html <?php echo html_attr_str(($this->layout_params['attr'] ?? []), false); ?>>
    <head>
        <title><?php $this->title(); ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="<?php echo cmsForm::getCSRFToken(); ?>">
<?php if (!$config->disable_copyright) { ?>
        <meta name="generator" content="InstantCMS">

<?php } ?>
    <?php if(!empty($this->options['head_html_top'])) { ?>
        <?php echo $this->options['head_html_top']."\n"; ?>
    <?php } ?>
<?php
        $this->addMainTplCSSName(['theme']);
        $this->addMainTplCSSName(['owl.carousel.min']);

if(!empty($this->options['font_type']) && $this->options['font_type'] === 'gfont') {
            $this->addHead('<link rel="dns-prefetch" href="https://fonts.googleapis.com">');
            $this->addHead('<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>');
            $this->addHead('<link rel="dns-prefetch" href="https://fonts.gstatic.com">');
            $this->addHead('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>');
            $this->addCSS('https://fonts.googleapis.com/css?family='.$this->options['gfont'].':400,400i,700,700i&display=swap&subset=cyrillic-ext', false);
        }
        $this->addMainTplJSName('jquery', true);
        $this->addMainTplJSName(['vendors/popper.js/js/popper.min', 'vendors/bootstrap/bootstrap.min', 'vendors/owl/owl.carousel.min']);
        $this->onDemandTplJSName(['vendors/photoswipe/photoswipe.min']);
        $this->onDemandTplCSSName(['photoswipe']);
        $this->addMainTplJSName(['core', 'modal']);
?>
        <?php $this->head(true, !empty($this->options['js_print_head']), true); ?>
    <?php if(!empty($this->options['favicon_head_html'])) { ?>
        <?php echo $this->options['favicon_head_html']."\n"; ?>
    <?php } ?>
    <?php if(!empty($this->options['favicon']['path'])) { ?>
        <link rel="icon" href="<?php echo $config->upload_root . $this->options['favicon']['path']; ?>" type="<?php echo pathinfo($this->options['favicon']['path'], PATHINFO_EXTENSION) === 'svg' ? 'image/svg+xml' : 'image/x-icon'; ?>">
    <?php } else { ?>
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <?php } ?>
    </head>
    <body id="<?php echo $device_type; ?>_device_type" data-device="<?php echo $device_type; ?>" class="d-flex flex-column min-vh-100<?php if(!empty($body_classes)) { ?> <?php html(implode(' ', $body_classes)); ?><?php } ?> <?php html($this->options['body_classes'] ?? ''); ?>">
        <?php $this->renderLayoutChild('scheme', ['rows' => $rows]); ?>
        <?php if (!empty($this->options['show_top_btn'])){ ?>
            <a class="btn btn-secondary btn-lg" href="#<?php echo $device_type; ?>_device_type" id="scroll-top">
                <?php html_svg_icon('solid', 'chevron-up'); ?>
            </a>
        <?php } ?>
        <?php if (!empty($this->options['show_cookiealert'])){ ?>
            <div class="alert text-center py-3 border-0 rounded-0 m-0 position-fixed fixed-bottom icms-cookiealert" id="icms-cookiealert">
                <div class="container">
                    <?php echo $this->options['cookiealert_text']; ?>
                    <button type="button" class="ml-2 btn btn-primary btn-sm acceptcookies">
                        <?php echo LANG_MODERN_THEME_COOKIEALERT_AGREE; ?>
                    </button>
                </div>
            </div>
        <?php } ?>
        <div id="copy-message">Промокод скопирован в буфер обмена!</div>

        <?php if ($config->debug && cmsUser::isAdmin()){ ?>
            <?php $this->renderAsset('ui/debug', ['core' => $core]); ?>
        <?php } ?>
        <script nonce="<?php echo $this->nonce; ?>"><?php echo $this->getLangJS('LANG_LOADING', 'LANG_ALL', 'LANG_COLLAPSE', 'LANG_EXPAND'); ?></script>
        <?php if(empty($this->options['js_print_head'])) { ?>
            <?php $this->printJavascriptTags(); ?>
        <?php } ?>
        <?php $this->bottom(); ?>
        <?php $this->onDemandPrint(); ?>
        <script>
            $('#js-carousel').each(function () {

                // Создаем карусель
                var owl = $(this).find('.owl-carousel').owlCarousel();

                // При клике по кнопке Влево
                $(this).find('.js-prev').on('click', function () {
                    // Перематываем карусель назад
                    owl.trigger('prev.owl.carousel');
                });

                // При клике по кнопке Вправо
                $(this).find('.js-next').on('click', function () {
                    // Перематываем карусель вперед
                    owl.trigger('next.owl.carousel');
                });
            });</script>
        <script>
            $(document).ready(function () {
                updateContainer();
                $(window).resize(function() {
                    updateContainer();
                });
            });
            function updateContainer() {
                $width = $('.owl-stage').width();
                $widthD = $(window).width();
                $perD = $('.owl-stage').width()/$(window).width();
                if($perD > 0.84 && $widthD > 767) {

                    $('.js-prev').css('display','inline-block');
                    $('.js-next').css('display','inline-block');
                }else{
                    $('.js-prev').css('display','none');
                    $('.js-next').css('display','none');
                }
            }


        </script>
    <script>
        $(document).ready(function() {
            $('.r-content_list_item').on('click', function(e) {
                // Проверяем, что клик не на ссылку, указанные элементы или их дочерние элементы
                if (!$(e.target).is('a, .arrow, .r-user use, .r-dist-btn') &&
                    !$(e.target).closest('a, .r-dist-btn, .arrow').length) {
                    window.location.href = $(this).data('link');
                }
            });
        });
    </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.r-dist-btn').forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var url = this.getAttribute('data-url');
                        var title = this.getAttribute('data-title');
                        var style = this.getAttribute('data-style') || 'primary';
                        var shareHtml = `
                <div class="share-options">
                    <button class="copy-link-btn" data-url="${url}">
                        Копировать ссылку <span class="k-icon"><?php html_svg_icon('solid', 'link'); ?></span>
                    </button>
                    <hr class="share-separator">
                    <a href="https://vk.com/share.php?url=${url}&title=${title}" class="share-btn vk" target="_blank" title="Поделиться во ВКонтакте">
                        <span class="k-icon"><?php html_svg_icon('solid', 'share'); ?></span> ВКонтакте
                    </a>
                    <a href="https://connect.ok.ru/offer?url=${url}&title=${title}" class="share-btn ok" target="_blank" title="Поделиться в Одноклассниках">
                        <span class="k-icon"><?php html_svg_icon('solid', 'share'); ?></span> Одноклассники
                    </a>
                    <a href="https://t.me/share/url?url=${url}&text=${title}" class="share-btn telegram" target="_blank" title="Поделиться в Telegram">
                        <span class="k-icon"><?php html_svg_icon('solid', 'paper-plane'); ?></span> Telegram
                    </a>
                    <a href="https://api.whatsapp.com/send?text=${title}%20${url}" class="share-btn whatsapp" target="_blank" title="Поделиться в WhatsApp">
                        <span class="k-icon"><?php html_svg_icon('solid', 'comment'); ?></span> WhatsApp
                    </a>
                </div>
            `;
                        icms.modal.openHtml(shareHtml, 'Поделиться', style);

                        // Attach event listener to the copy link button after modal is opened
                        document.querySelectorAll('.copy-link-btn').forEach(function(copyButton) {
                            copyButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                var copyUrl = this.getAttribute('data-url');

                                // Copy URL to clipboard
                                navigator.clipboard.writeText(decodeURIComponent(copyUrl)).then(() => {
                                    // Store original text and styles
                                    const originalText = this.innerHTML;
                                    const originalBgColor = this.style.backgroundColor;

                                    // Change button text and color
                                    this.innerHTML = 'Ссылка скопирована';
                                    this.style.backgroundColor = '#28a745'; // Green color

                                    // Revert to original state after 2 seconds
                                    setTimeout(() => {
                                        this.innerHTML = originalText;
                                        this.style.backgroundColor = originalBgColor;
                                    }, 2000);
                                }).catch(err => {
                                    console.error('Failed to copy: ', err);
                                });
                            });
                        });
                    });
                });
            });
        </script>

        <script>
            function copyToClipboard(itemId) {
                var textElement = document.getElementById('promokod-' + itemId);
                if (!textElement) return; // Если элемент не найден

                var text = textElement.innerText; // Получаем текст промокода

                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text)
                        .then(function() {
                            showCopyMessage(); // Показываем кастомное сообщение
                        })
                        .catch(function(err) {
                            console.error('Ошибка копирования: ', err);
                            alert('Не удалось скопировать промокод. Попробуйте вручную.');
                        });
                } else {
                    // Fallback для старых браузеров
                    var tempInput = document.createElement('input');
                    tempInput.value = text;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    showCopyMessage(); // Показываем сообщение
                }
            }

            function showCopyMessage() {
                var message = document.getElementById('copy-message');
                message.style.display = 'block';
                message.style.opacity = '1'; // Плавное появление

                // Скрываем через 2 секунды
                setTimeout(function() {
                    message.style.opacity = '0'; // Плавное исчезновение
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 500); // Ждём окончания transition
                }, 500);
            }
        </script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=106052218', 'ym');

    ym(106052218, 'init', {ssr:true, clickmap:true, referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/106052218" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->



    </body>
</html>
