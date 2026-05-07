<?php
    $this->addTplJSNameFromContext('search');

    $this->addBreadcrumb(LANG_SEARCH_TITLE, $this->href_to(''));
    if($query){
        $this->addBreadcrumb($query);
    }

    $content_menu = [];

    $uri_query = http_build_query([
        'order_by' => $order_by,
        'q'        => $query,
        'type'     => $type,
        'date'     => $date
    ]);

    if ($results){

        foreach($results as $result) {

            $content_menu[] = [
                'title'    => $result['title'],
                'url'      => $this->href_to($result['name']) . '?' . $uri_query,
                'url_mask' => $this->href_to($result['name']),
                'counter'  => $result['count']
            ];

            if($result['items'] || $result['html']) {
                $search_data = $result;
            }
        }

        $this->addMenuItems('results_tabs', $content_menu);
    }
?>

<h1>
    <?php $this->pageH1();?>
</h1>

<?php $this->renderChild('search_form', [
    'show_search_params' => $show_search_params,
    'query'              => $query,
    'type'               => $type,
    'date'               => $date,
    'order_by'           => $order_by
]); ?>

<?php if ($query && empty($search_data)){ ?>
    <?php $this->addHead('<meta name="robots" content="noindex">'); ?>
    <p class="alert alert-info">
        <?php echo LANG_SEARCH_NO_RESULTS; ?>
    </p>
<?php } ?>

<?php if (empty($search_data)){ return; } ?>

<?php $this->menu('results_tabs', true, 'nav nav-pills mb-3 mb-md-4'); ?>

<?php if (!empty($search_data['html'])) { ?>
    <?php echo $search_data['html']; ?>
<?php } else { ?>

<div class="icms-widget__content_list content_list mb-3 mb-md-4">
    <?php foreach($search_data['items'] as $item){ ?>
    <?php
        $ctype_name = !empty($item['ctype']['name']) ? $item['ctype']['name'] : '';
        $is_inactive = isset($item['is_pub']) && $item['is_pub'] < 1;
        $item_url = $item['url'];
        $short_title = mb_substr($item['title'], 0, 80, 'UTF-8');
        if (mb_strlen($item['title'], 'UTF-8') > 80) { $short_title .= '...'; }
        $mobile_title = mb_substr($item['title'], 0, 40, 'UTF-8');
        if (mb_strlen($item['title'], 'UTF-8') > 40) { $mobile_title .= '...'; }
    ?>
    <div class="content_list_item <?php echo $ctype_name; ?>_list_item r-content_list_item clearfix<?php if ($is_inactive){ ?> item--inactive<?php } ?>" data-link="<?php echo $item_url; ?>">
        <div class="bar-info r-mobile">
            <div class="bar">
                <div class="r-date">
                    <?php html_svg_icon('solid', 'calendar-alt'); ?>
                    <?php echo html_date($item['date_pub']); ?>
                </div>
            </div>
        </div>

        <div class="r-content_list">
            <div class="icms-content-left-column">
                <div class="r-img">
                    <?php if(!empty($item['image'])){ ?>
                        <a href="<?php echo $item_url; ?>">
                            <?php echo $item['image']; ?>
                        </a>
                    <?php } ?>
                    <?php if ($is_inactive) { ?>
                    <div class="r-img__inactive-overlay">не активно</div>
                    <?php } ?>
                </div>
            </div>
            <div class="icms-content-right-column">
                <div class="bar-info r-nmobile">
                    <div class="bar">
                        <div class="r-date">
                            <?php html_svg_icon('solid', 'calendar-alt'); ?>
                            <?php echo html_date($item['date_pub']); ?>
                        </div>
                    </div>
                </div>

                <div class="r-nmobile">
                    <a class="r-content_title" href="<?php echo $item_url; ?>">
                        <?php echo $short_title; ?>
                    </a>
                </div>

                <div class="r-mobile">
                    <a class="r-content_title" href="<?php echo $item_url; ?>">
                        <?php echo $mobile_title; ?>
                    </a>
                </div>

                <div class="r-nmobile">
                    <?php foreach($item['fields'] as $field => $value){ ?>
                        <?php if (!$value) { continue; } ?>
                        <?php
                            $text = trim(strip_tags($value));
                            $len = mb_strlen($text, 'UTF-8');
                            if ($len > 120) {
                                $trimmed = mb_substr($text, 0, 120, 'UTF-8');
                                $lastSpace = mb_strrpos($trimmed, ' ', 0, 'UTF-8');
                                if ($lastSpace !== false) { $trimmed = mb_substr($trimmed, 0, $lastSpace, 'UTF-8'); }
                                echo htmlspecialchars($trimmed . '...');
                            } else {
                                echo $value;
                            }
                        ?>
                    <?php } ?>
                </div>

                <?php if (isset($item['sale_url'])) { ?>
                <div class="price_market">
                    <?php if (isset($item['price'])) { ?>
                        <div class="r-price"><?php echo $item['price']; ?>₽</div>
                    <?php } ?>
                    <?php if (isset($item['old_price'])) { ?>
                        <div class="r-old_price"><?php echo $item['old_price']; ?>₽</div>
                    <?php } ?>
                </div>
                <?php } ?>

                <div class="r-list-button r-nmobile">
                    <div class="r-list-button-left">
                        <div class="r-dist-btn r-list-btn ajax-modal"
                            data-url="<?php echo urlencode('https://radaru.ru' . $item_url); ?>"
                            data-title="<?php echo urlencode($item['title']); ?>"
                            data-style="sm"
                            data-item-id="<?php echo $item['id']; ?>">
                            <span class="r-list-icon"><?php html_svg_icon('solid', 'share'); ?></span>
                        </div>
                    </div>
                    <div class="r-list-button-right">
                        <?php if (isset($item['sale_url'])) { ?>
                            <a href="<?php echo $item['sale_url']; ?>" class="r-content_link r-sale-url">К скидке</a>
                        <?php } else { ?>
                            <a href="<?php echo $item_url; ?>" class="r-content_link r-sale-url">Подробнее</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="r-list-button r-mobile">
            <div class="r-list-button-left">
                <div class="r-dist-btn r-list-btn ajax-modal"
                     data-url="<?php echo urlencode('https://radaru.ru' . $item_url); ?>"
                     data-title="<?php echo urlencode($item['title']); ?>"
                     data-style="sm"
                     data-item-id="<?php echo $item['id']; ?>">
                    <span class="r-list-icon"><?php html_svg_icon('solid', 'share'); ?></span>
                </div>
            </div>
            <div class="r-list-button-right">
                <?php if (isset($item['sale_url'])) { ?>
                    <a href="<?php echo $item['sale_url']; ?>" class="r-content_link r-sale-url">К скидке</a>
                <?php } else { ?>
                    <a href="<?php echo $item_url; ?>" class="r-content_link r-sale-url">Подробнее</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php echo html_pagebar($page, $perpage, $search_data['count'], $page_url, $uri_query); ?>

<?php } ?>