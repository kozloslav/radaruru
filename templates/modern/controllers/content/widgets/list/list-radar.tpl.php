<?php
/**
 * Template Name: LANG_WD_CONTENT_LIST_STYLE_BASIC
 * Template Type: widget
 */
?>
    <div class="r-promo-banner">
        <div class="r-promo-banner__content">
            <div class="r-promo-banner__title">Подпишитесь, чтобы не упустить выгоду</div>
            <div class="r-promo-banner__links">
                <a href="https://vk.com/radarupub" class="r-promo-link r-promo-link--vk" target="_blank" rel="nofollow noopener">
                    <svg class="icms-svg-icon w-16" fill="currentColor"><use href="/templates/modern/images/icons/brands.svg?1762180292#vk"></use></svg>
                    <span>ВКонтакте</span>
                </a>
                <a href="https://t.me/radarupub" class="r-promo-link r-promo-link--tg" target="_blank" rel="nofollow noopener">
                    <svg class="icms-svg-icon w-16" fill="currentColor"><use href="/templates/modern/images/icons/brands.svg?1762180292#telegram-plane"></use></svg>
                    <span>Telegram</span>
                </a>
            </div>
        </div>
    </div>

<div class="icms-widget__content_list content_list">
    <?php foreach($items as $item) { ?>

    <div class="card-item r-content_list_item <?php echo $ctype['name']; ?>_list_item<?php if (isset($item['is_pub']) && $item['is_pub'] < 1) { ?> item--inactive<?php } ?>" data-link="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">

        <div class="card-media">
            <div class="r-img">
                <?php if (isset($item['fields']['photo'])) { echo $item['fields']['photo']['html']; } ?>
                <?php if (isset($item['is_pub']) && $item['is_pub'] < 1) { ?>
                    <div class="r-img__inactive-overlay">не активно</div>
                <?php } ?>
            </div>
        </div>

        <div class="card-body">

            <div class="card-meta">
                <span class="card-date">
                    <?php if (!empty($item['info_bar']['date_pub']['icon'])){ html_svg_icon('solid', $item['info_bar']['date_pub']['icon']); } ?>
                    <?php echo $item['info_bar']['date_pub']['html']; ?>
                </span>
                <?php if (!empty($item['info_bar']['user']['href'])){ ?>
                    <a class="card-user" href="<?php echo $item['info_bar']['user']['href']; ?>">
                        <?php echo $item['info_bar']['user']['html']; ?>
                    </a>
                <?php } elseif (!empty($item['info_bar']['user']['html'])) { ?>
                    <span class="card-user"><?php echo $item['info_bar']['user']['html']; ?></span>
                <?php } ?>
                <div class="card-rating"><?php echo $item['info_bar']['rating']['html']; ?></div>
            </div>

            <?php if (isset($item['fields']['title'])) {
                $raw_title = html_entity_decode(strip_tags($item['fields']['title']['html']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $mob_title = mb_strlen($raw_title, 'UTF-8') > 56
                    ? mb_substr($raw_title, 0, 53, 'UTF-8') . '…'
                    : $raw_title;
            ?>
                <a class="card-title" href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
                    <span class="ct-d"><?php echo $item['fields']['title']['html']; ?></span><span class="ct-m"><?php echo htmlspecialchars($mob_title); ?></span>
                </a>
            <?php } ?>

            <?php
            $desc_text = trim(strip_tags($item['fields']['content']['html'] ?? ''));
            if ($desc_text) {
                $trimmed = mb_substr($desc_text, 0, 120, 'UTF-8');
                if (mb_strlen($desc_text, 'UTF-8') > 120) {
                    $last = mb_strrpos($trimmed, ' ', 0, 'UTF-8');
                    $trimmed = ($last ? mb_substr($trimmed, 0, $last, 'UTF-8') : $trimmed) . '…';
                }
                echo '<p class="card-desc">' . htmlspecialchars($trimmed) . '</p>';
            }
            ?>

            <div class="card-price-row">
                <?php if (isset($item['fields']['price'])) { ?>
                    <span class="r-price"><?php echo $item['fields']['price']['html']; ?>₽</span>
                <?php } ?>
                <?php if (isset($item['old_price'])) { ?>
                    <span class="r-old_price"><?php echo $item['old_price']; ?>₽</span>
                <?php } ?>
                <?php if ($item['parent_type'] == 'group') { ?>
                    <a href="<?php echo $item['parent_url']; ?>" class="card-market">
                        <?php if ($item['ctype']['name'] == 'discounts') echo '· '; ?><?php echo $item['parent_title']; ?>
                    </a>
                <?php } ?>
            </div>

            <div class="card-actions">
                <div class="card-actions-left">
                    <div class="r-dist-btn r-list-btn ajax-modal"
                        data-url="<?php echo urlencode('https://radaru.ru' . href_to($ctype['name'], $item['slug'].'.html')); ?>"
                        data-title="<?php echo urlencode($item['title']); ?>"
                        data-style="sm"
                        data-item-id="<?php echo $item['id']; ?>">
                        <span class="r-list-icon"><?php html_svg_icon('solid', 'share'); ?></span>
                    </div>
                    <div class="r-list-btn r-list-btn-comm">
                        <span class="r-list-icon"><?php html_svg_icon('solid', 'comments'); ?></span><?php echo $item['info_bar']['comments']['html']; ?>
                    </div>
                    <?php if (isset($item['promokod'])) { ?>
                        <a href="#" class="r-promokod" onclick="copyToClipboard(<?php echo $item['id']; ?>); return false;">
                            <span id="promokod-<?php echo $item['id']; ?>"><?php html_svg_icon('solid', 'copy'); ?><?php echo $item['promokod']; ?></span>
                        </a>
                    <?php } ?>
                </div>
                <div class="card-actions-right">
                    <?php if ($item['ctype']['name'] == 'promocodes') { ?>
                        <?php if (!empty($item['parent_url_market'])) { ?>
                            <a href="<?php echo $item['parent_url_market']; ?>" class="r-sale-url">Перейти в магазин</a>
                        <?php } else { ?>
                            <a href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>" class="r-sale-url">Подробнее</a>
                        <?php } ?>
                    <?php } elseif (isset($item['sale_url'])) { ?>
                        <a href="<?php echo $item['sale_url']; ?>" class="r-sale-url">К скидке</a>
                    <?php } else { ?>
                        <a href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>" class="r-sale-url">Подробнее</a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

    <?php } ?>
</div>
