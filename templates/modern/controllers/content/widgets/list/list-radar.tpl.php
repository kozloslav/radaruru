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
               <!-- <a href="https://max.ru/radaru" class="r-promo-link r-promo-link--max" target="_blank" rel="nofollow noopener">
                <svg class="icms-svg-icon w-16" fill="currentColor"><use href="/templates/modern/images/icons/my.svg?1762180292#max"></use></svg>
                <span>MAX</span> -->
                </a>
            </div>
        </div>
    </div>

<div class="icms-widget__content_list content_list">
    <?php foreach($items as $item) { ?>

    <div class="content_list_item <?php echo $ctype['name']; ?>_list_item r-content_list_item clearfix<?php if (isset($item['is_pub']) && $item['is_pub'] < 1) { ?> item--inactive<?php } ?>" data-link="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
        <div class="bar-info r-mobile">

            <div class="bar">
                <div class="r-date">
                    <?php if (!empty($item['info_bar']['date_pub']['icon'])){ ?>
                        <?php html_svg_icon('solid', $item['info_bar']['date_pub']['icon']); ?>
                    <?php } ?>

                    <?php echo $item['info_bar']['date_pub']['html']; ?>
                </div>
                <div class="r-user">

                    <?php if (!empty($item['info_bar']['user']['icon'])){ ?>
                        <?php html_svg_icon('solid', $item['info_bar']['user']['icon']); ?>
                    <?php } ?>
                    <?php if (!empty($item['info_bar']['user']['href'])){ ?>
                        <a class="r-content_link" href="<?php echo $item['info_bar']['user']['href']; ?>">
                            <?php echo $item['info_bar']['user']['html']; ?>
                        </a>
                    <?php } else { ?>
                        <?php echo $item['info_bar']['user']['html']; ?>
                    <?php } ?>
                </div>
            </div>
            <div class="r-rating">
                <?php print_r($item['info_bar']['rating']['html']); ?>
            </div>
        </div>



        <div class="r-content_list">
            <div class="icms-content-left-column">

        
                 <div class="r-img">
                    <?php if (isset($item['fields']['photo'])) { ?>
                    <?php echo $item['fields']['photo']['html']; ?>
                    <?php } ?>
                    <?php if (isset($item['is_pub']) && $item['is_pub'] < 1) { ?>
                    <div class="r-img__inactive-overlay">не активно</div>
                    <?php } ?>
                </div>

             </div>
            <div class="icms-content-right-column">
                <div class="bar-info r-nmobile">

                    <div class="bar">
                        <div class="r-date">
                            <?php if (!empty($item['info_bar']['date_pub']['icon'])){ ?>
                                <?php html_svg_icon('solid', $item['info_bar']['date_pub']['icon']); ?>
                            <?php } ?>
                            <?php echo $item['info_bar']['date_pub']['html']; ?>
                        </div>

                        <div class="r-user">
                            <?php if (!empty($item['info_bar']['user']['href'])){ ?>
                                <a class="r-content_link" href="<?php echo $item['info_bar']['user']['href']; ?>">
                                    <?php if (!empty($item['info_bar']['user']['icon'])){ ?>
                                        <?php html_svg_icon('solid', $item['info_bar']['user']['icon']); ?>
                                    <?php } ?>
                                    <?php echo $item['info_bar']['user']['html']; ?>
                                </a>
                            <?php } else { ?>
                                <?php echo $item['info_bar']['user']['html']; ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="r-rating">
                        <?php 
                        $desktop_rating_html = $item['info_bar']['rating']['html'];
                        // Добавляем уникальный ID для десктопной версии
                        $desktop_rating_html = str_replace('id="rating-'.$item['ctype_name'].'-'.$item['id'].'"', 'id="rating-'.$item['ctype_name'].'-'.$item['id'].'-desktop"', $desktop_rating_html);
                        echo $desktop_rating_html;
                        ?>
                    </div>
                </div>

                <div class="r-nmobile">
                    <?php if (isset($item['fields']['title'])) { ?>


                        <?php $desktop_title = mb_substr($item['fields']['title']['html'], 0, 80, 'UTF-8');
                        if (mb_strlen($item['fields']['title']['html'], 'UTF-8') > 80) {
                            $desktop_title .= '...';
                        }?>

                        <a class="r-content_title" href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
                            <?php echo $desktop_title; ?>
                        </a>
                    <?php } ?>
                </div>


                <div class="r-mobile">
                    <?php if (isset($item['fields']['title'])) { ?>


                        <?php $desktop_title = mb_substr($item['fields']['title']['html'], 0, 40, 'UTF-8');
                        if (mb_strlen($item['fields']['title']['html'], 'UTF-8') > 40) {
                            $desktop_title .= '...';
                        }?>

                        <a class="r-content_title" href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>">
                            <?php echo $desktop_title; ?>
                        </a>
                    <?php } ?>
                </div>
                <div class="r-nmobile">
                    <?php echo $item['fields']['content']['html'];?>
    
                </div>

                 
                <div class="price_market">
                    <?php if (isset($item['fields']['price'])) { ?>

                        <div class="r-price">
                        <?php echo $item['fields']['price']['html']; ?>₽
                        </div>
                    <?php } ?>
                    <?php if (isset($item['old_price'])) { ?>
                        <div class="r-old_price">
                            <?php echo $item['old_price']; ?>₽
                        </div>
                    <?php } ?>


                    <div class="r-market">
                        <?php if ($item['parent_type'] == 'group') { ?>
                            <a href="<?php echo $item['parent_url']; ?>" class="r-content_link r-parent-title"><?php if ($item['ctype']['name'] == 'discounts') { echo '·'; } ?> <?php echo $item['parent_title']; ?></a>

                        <?php } ?>
                    </div>

                </div>
                            
                <div class="r-list-button r-nmobile">
                    <div class="r-list-button-left">
                            <div class="r-dist-btn r-list-btn ajax-modal"
                                data-url="<?php echo urlencode('https://radaru.ru' . href_to($ctype['name'], $item['slug'].'.html')); ?>"
                                data-title="<?php echo urlencode($item['title']); ?>"
                                data-style="sm"
                                data-item-id="<?php echo $item['id']; ?>">
                                    <span class="r-list-icon"><?php html_svg_icon('solid', 'share'); ?></span>
                            </div>
                            <div class="r-list-btn r-list-btn-comm"> <span class="r-list-icon"><?php html_svg_icon('solid', 'comments'); ?></span><?php echo $item['info_bar']['comments']['html']; ?></div>
                            <?php if (isset($item['promokod'])) { ?>

                            <a href="#" class="copy-link r-promokod" onclick="copyToClipboard(<?php echo $item['id']; ?>); return false;">

                                    <span id="promokod-<?php echo $item['id']; ?>"><?php html_svg_icon('solid', 'copy'); ?><?php echo $item['promokod']; ?></span>
                                        
                            </a>
                            <?php } ?>

                            </div>

                            <div class="r-list-button-right">
                            <?php if ($item['ctype']['name'] == 'promocodes') { ?>
                                    <?php if (!empty($item['parent_url_market'])) { ?>
                                        <a href="<?php echo $item['parent_url_market']; ?>" class="r-content_link r-sale-url">Перейти в магазин</a>

                                    <?php } ?>

                            <?php }else{ ?>
                            <?php if (isset($item['sale_url'])) { ?>
                                <a href="<?php echo $item['sale_url']; ?>" class="r-content_link r-sale-url">К скидке</a>
                            <?php } ?>
                            <?php } ?>
                            </div>
                    </div>
                </div>
        </div>

         <div class="r-mobile mobile_p">
 
            <?php if (isset($item['coupon_period'])) { ?>
                <?php echo $item['coupon_period']; ?>
            <?php } ?>
            <?php if (isset($item['promokod'])) { ?>

                <a href="#" class="copy-link r-promokod" onclick="copyToClipboard(<?php echo $item['id']; ?>); return false;">

                    <span id="promokod-<?php echo $item['id']; ?>"> <?php html_svg_icon('solid', 'copy'); ?>Промокод: <?php echo $item['promokod']; ?></span>
                   
                </a>
            <?php } ?>
        </div>
                <div class="r-list-button r-mobile">

            <div class="r-list-button-left">
                <div class="r-dist-btn r-list-btn ajax-modal"
                     data-url="<?php echo urlencode('https://radaru.ru' . href_to($ctype['name'], $item['slug'].'.html')); ?>"
                     data-title="<?php echo urlencode($item['title']); ?>"
                     data-style="sm"
                     data-item-id="<?php echo $item['id']; ?>">
                    <span class="r-list-icon"><?php html_svg_icon('solid', 'share'); ?></span>
                </div>
                <div class="r-list-btn r-list-btn-comm"> <span class="r-list-icon"><?php html_svg_icon('solid', 'comments'); ?></span><?php echo $item['info_bar']['comments']['html']; ?></div>

            </div>
            <div class="r-list-button-right">

                <?php if (isset($item['sale_url'])) { ?>
                    <a href="<?php echo $item['sale_url']; ?>" class="r-content_link r-sale-url">К скидке</a>
                <?php }else {?>
                    <a  href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>" class="r-content_link r-sale-url">Подробнее</a>

                <?php } ?>
            </div>
        </div>

    </div>


























    <?php } ?>
</div>