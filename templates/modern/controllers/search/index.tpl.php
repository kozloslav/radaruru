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
    ?>
    <div class="card-item r-content_list_item <?php echo $ctype_name; ?>_list_item<?php if ($is_inactive){ ?> item--inactive<?php } ?>" data-link="<?php echo $item_url; ?>">

        <div class="card-media">
            <div class="r-img">
                <?php if (!empty($item['image'])){ ?>
                    <a href="<?php echo $item_url; ?>"><?php echo $item['image']; ?></a>
                <?php } ?>
                <?php if ($is_inactive) { ?><div class="r-img__inactive-overlay">не активно</div><?php } ?>
            </div>
        </div>

        <div class="card-body">
            <div class="card-meta">
                <span class="card-date">
                    <?php html_svg_icon('solid', 'calendar-alt'); ?>
                    <?php echo html_date($item['date_pub']); ?>
                </span>
            </div>

            <?php
            $search_raw = html_entity_decode($item['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $mob_title = mb_strlen($search_raw, 'UTF-8') > 56
                ? mb_substr($search_raw, 0, 53, 'UTF-8') . '…'
                : $search_raw;
            ?>
            <a class="card-title" href="<?php echo $item_url; ?>">
                <span class="ct-d"><?php echo htmlspecialchars($item['title']); ?></span><span class="ct-m"><?php echo htmlspecialchars($mob_title); ?></span>
            </a>

            <?php
            $desc = '';
            foreach ($item['fields'] as $value) {
                if ($value) { $desc = trim(strip_tags($value)); break; }
            }
            if ($desc) {
                $trimmed = mb_substr($desc, 0, 120, 'UTF-8');
                if (mb_strlen($desc, 'UTF-8') > 120) {
                    $last = mb_strrpos($trimmed, ' ', 0, 'UTF-8');
                    $trimmed = ($last ? mb_substr($trimmed, 0, $last, 'UTF-8') : $trimmed) . '…';
                }
                echo '<p class="card-desc">' . htmlspecialchars($trimmed) . '</p>';
            }
            ?>

            <?php if (isset($item['price']) || isset($item['old_price'])) { ?>
            <div class="card-price-row">
                <?php if (isset($item['price'])) { ?><span class="r-price"><?php echo $item['price']; ?>₽</span><?php } ?>
                <?php if (isset($item['old_price'])) { ?><span class="r-old_price"><?php echo $item['old_price']; ?>₽</span><?php } ?>
            </div>
            <?php } ?>

            <div class="card-actions">
                <div class="card-actions-left">
                    <div class="r-dist-btn r-list-btn ajax-modal"
                        data-url="<?php echo urlencode('https://radaru.ru' . $item_url); ?>"
                        data-title="<?php echo urlencode($item['title']); ?>"
                        data-style="sm"
                        data-item-id="<?php echo $item['id']; ?>">
                        <span class="r-list-icon"><?php html_svg_icon('solid', 'share'); ?></span>
                    </div>
                </div>
                <div class="card-actions-right">
                    <?php if (isset($item['sale_url'])) { ?>
                        <a href="<?php echo $item['sale_url']; ?>" class="r-sale-url">К скидке</a>
                    <?php } else { ?>
                        <a href="<?php echo $item_url; ?>" class="r-sale-url">Подробнее</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php echo html_pagebar($page, $perpage, $search_data['count'], $page_url, $uri_query); ?>

<?php } ?>