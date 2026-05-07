<div class="r-item-block r-item">

    <div class="r-content_list">

        <div class="icms-content-left-column">
            <div class="r-img">
                <?php if (isset($item['fields']['photo'])) { ?>
                    <?php echo $item['fields']['photo']['html']; ?>
                <?php } ?>
            </div>
        </div>

        <div class="icms-content-right-column">

            <div class="bar-info">
                <div class="bar">
                    <div class="r-date">
                        <?php if (!empty($item['info_bar']['date_pub']['icon'])){ html_svg_icon('solid', $item['info_bar']['date_pub']['icon']); } ?>
                        <?php echo $item['info_bar']['date_pub']['html']; ?>
                    </div>
                    <div class="r-user">
                        <?php if (!empty($item['info_bar']['user']['href'])){ ?>
                            <a class="r-content_link" href="<?php echo $item['info_bar']['user']['href']; ?>">
                                <?php if (!empty($item['info_bar']['user']['icon'])){ html_svg_icon('solid', $item['info_bar']['user']['icon']); } ?>
                                <?php echo $item['info_bar']['user']['html']; ?>
                            </a>
                        <?php } else { ?>
                            <?php echo $item['info_bar']['user']['html']; ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="r-rating-item">
                    <?php echo $item['info_bar']['rating']['html']; ?>
                </div>
            </div>

            <?php if (!empty($fields['title']['is_in_item']) && in_array('page', $fields['title']['options']['is_in_item_pos'])){ ?>
                <h1>
                    <?php html($item['title']); ?>
                    <?php if ($item['is_private']) { ?>
                        <span class="is_private text-secondary" title="<?php html(LANG_PRIVACY_HINT); ?>">
                            <?php html_svg_icon('solid', 'lock'); ?>
                        </span>
                    <?php } ?>
                </h1>
            <?php } ?>

            <div class="price_market">
                <?php if (isset($item['fields']['price'])) { ?>
                    <span class="r-price"><?php echo $item['fields']['price']['html']; ?>₽</span>
                <?php } ?>
                <?php if ($item['parent_type'] == 'group') { ?>
                    <a href="<?php echo $item['parent_url']; ?>" class="r-content_link r-parent-title">
                        · <?php echo $item['parent_title']; ?>
                    </a>
                <?php } ?>
            </div>

            <div class="r-item-btn-row">
                <?php if (isset($item['sale_url'])) { ?>
                    <a href="<?php echo $item['sale_url']; ?>" class="r-content_link r-sale-url">К скидке</a>
                <?php } ?>
                <?php if (isset($item['promokod'])) { ?>
                    <a href="#" class="copy-link it-promokod" onclick="copyToClipboard(<?php echo $item['id']; ?>); return false;">
                        <span id="promokod-<?php echo $item['id']; ?>"><?php html_svg_icon('solid', 'copy'); ?><?php echo $item['promokod']; ?></span>
                    </a>
                <?php } ?>
                <div class="r-dist-btn r-list-btn ajax-modal"
                    data-url="<?php echo urlencode('https://radaru.ru' . href_to($item['ctype_name'], $item['slug'].'.html')); ?>"
                    data-title="<?php echo urlencode($item['title']); ?>"
                    data-style="sm"
                    data-item-id="<?php echo $item['id']; ?>">
                    <span class="r-list-icon"><?php html_svg_icon('solid', 'share'); ?></span>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="r-item-block r-item-desc">
    <h2>Описание</h2>
    <?php echo $item['content']; ?>
</div>
