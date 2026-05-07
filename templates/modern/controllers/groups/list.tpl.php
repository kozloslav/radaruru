<?php
    if (!empty($this->controller->options['is_filter'])) {
        $this->renderAsset('ui/filter-panel', [
            'css_prefix' => 'groups',
            'page_url'   => $page_url,
            'fields'     => $fields,
            'filters'    => $filters
        ]);
    }
?>

<?php if (!$groups){ ?>
    <p class="alert alert-info mt-4 alert-list-empty">
        <?php echo sprintf(LANG_TARGET_LIST_EMPTY, LANG_GROUPS10); ?>
    </p>
<?php return; } ?>

<div class="r-market-grid">

    <?php foreach($groups as $group){
        $group_url = href_to('groups', $group['slug']);

        $raw_market = trim($group['url_market'] ?? '');
        $market_href = '';
        $market_display = '';
        if ($raw_market) {
            $market_href = preg_match('#^https?://#i', $raw_market) ? $raw_market : 'https://' . $raw_market;
            $market_display = preg_replace('#^https?://(www\.)?#i', '', rtrim($market_href, '/'));
        }
    ?>

    <div class="r-market-card" onclick="location.href='<?php echo $group_url; ?>'">

        <a class="r-market-card__logo" href="<?php echo $group_url; ?>" onclick="event.stopPropagation()">
            <?php if (!empty($fields['logo']) && $fields['logo']['is_in_list'] && $group['logo']){ ?>
                <?php echo html_image($group['logo'], $fields['logo']['handler']->getOption('size_teaser'), $group['title']); ?>
            <?php } else { ?>
                <span class="r-market-card__initials"><?php echo mb_strtoupper(mb_substr($group['title'], 0, 2, 'UTF-8'), 'UTF-8'); ?></span>
            <?php } ?>
        </a>

        <div class="r-market-card__body">
            <a class="r-market-card__title" href="<?php echo $group_url; ?>" onclick="event.stopPropagation()">
                <?php echo htmlspecialchars($group['title']); ?>
                <?php if ($group['is_closed']){ ?><span class="r-market-lock"><?php html_svg_icon('solid', 'lock'); ?></span><?php } ?>
            </a>

            <div class="r-market-card__footer">
                <?php if ($market_display){ ?>
                    <a class="r-market-card__url" href="<?php echo htmlspecialchars($market_href); ?>" target="_blank" rel="nofollow noopener" onclick="event.stopPropagation()">
                        <?php html_svg_icon('solid', 'external-link-alt'); ?>
                        <?php echo htmlspecialchars($market_display); ?>
                    </a>
                <?php } ?>
            </div>
        </div>

    </div>

    <?php } ?>

</div>

<?php echo html_pagebar($page, $perpage, $total, $page_url, $filter_query); ?>
