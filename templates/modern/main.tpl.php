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
        <script nonce="<?php echo $this->nonce; ?>">(function () {
            try {
                var theme = localStorage.getItem('icms_theme');
                if (theme !== 'light' && theme !== 'dark') {
                    theme = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
                }
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {}
        })();</script>
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
        $this->addHead('<link rel="preconnect" href="https://fonts.googleapis.com">');
        $this->addHead('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>');
        $this->addHead('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">');
        $this->addMainTplCSSName(['theme']);

if(!empty($this->options['font_type']) && $this->options['font_type'] === 'gfont') {
            $this->addHead('<link rel="dns-prefetch" href="https://fonts.googleapis.com">');
            $this->addHead('<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>');
            $this->addHead('<link rel="dns-prefetch" href="https://fonts.gstatic.com">');
            $this->addHead('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>');
            $this->addCSS('https://fonts.googleapis.com/css?family='.$this->options['gfont'].':400,400i,700,700i&display=swap&subset=cyrillic-ext', false);
        }
        $this->addMainTplJSName('jquery', true);
        $this->addMainTplJSName(['vendors/popper.js/js/popper.min', 'vendors/bootstrap/bootstrap.min']);
        $this->onDemandTplJSName(['vendors/photoswipe/photoswipe.min']);
        $this->onDemandTplCSSName(['photoswipe']);
        $this->addMainTplJSName(['core', 'modal', 'site']);
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
        <button type="button" id="theme-switcher" class="position-fixed" title="<?php echo LANG_MODERN_THEME_SWITCH; ?>" aria-label="<?php echo LANG_MODERN_THEME_SWITCH; ?>">
            <?php html_svg_icon('solid', 'sun', 16, true); ?>
            <?php html_svg_icon('solid', 'moon', 16, true); ?>
        </button>
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
        <div class="modal fade r-welcome-modal" id="r-welcome-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content r-welcome-modal__content">
                    <button type="button" class="close r-welcome-modal__close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-body r-welcome-modal__body">
                        <div class="r-welcome-modal__icon">
                            <?php html_svg_icon('solid', 'fire', 28); ?>
                        </div>
                        <h4 class="r-welcome-modal__title">Выгодные предложения разбирают очень быстро</h4>
                        <p class="r-welcome-modal__text">Лучшие скидки и промокоды на Radaru часто исчезают уже через несколько часов после публикации. Чтобы не упустить выгоду, подпишитесь на наши каналы — там мы публикуем новые предложения первыми.</p>
                        <div class="r-welcome-modal__links">
                            <a href="https://max.ru/join/yL0vwgQCfCJWNol5OQtyI6AolA0d165ZXk61GW1e22w" class="r-promo-link r-promo-link--max r-promo-link--lg" target="_blank" rel="nofollow noopener">
                                <?php html_svg_icon('my', 'max', 16); ?>
                                <span>Подписаться в MAX</span>
                            </a>
                            <a href="https://t.me/radarupub" class="r-promo-link r-promo-link--tg r-promo-link--lg" target="_blank" rel="nofollow noopener">
                                <?php html_svg_icon('brands', 'telegram-plane', 16); ?>
                                <span>Подписаться в Telegram</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
