<?php
$this->addTplCSSFromContext('controllers/groups/styles');
?>
<div class="r-market-widget-list">
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
    <div class="r-market-row" onclick="location.href='<?php echo $group_url; ?>'">

        <a class="r-market-row__logo" href="<?php echo $group_url; ?>" onclick="event.stopPropagation()">
            <?php if (in_array($fields['logo']['id'], $fields_is_in_list) && $group['logo']){ ?>
                <?php echo html_image($group['logo'], $fields['logo']['handler']->getOption('size_teaser'), $group['title']); ?>
            <?php } else { ?>
                <span class="r-market-card__initials r-market-row__initials"><?php echo mb_strtoupper(mb_substr($group['title'], 0, 2, 'UTF-8'), 'UTF-8'); ?></span>
            <?php } ?>
        </a>

        <div class="r-market-row__body">
            <a class="r-market-row__title" href="<?php echo $group_url; ?>" onclick="event.stopPropagation()">
                <?php html($group['title']); ?>
            </a>
            <?php if ($market_display){ ?>
                <span class="r-market-row__url"><?php echo htmlspecialchars($market_display); ?></span>
            <?php } ?>
        </div>

    </div>
    <?php } ?>
</div>
<a class="widget_button" href="/markets">Все площадки</a>
