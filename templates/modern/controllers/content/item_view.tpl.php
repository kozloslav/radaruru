<?php

    $this->addHead('<link rel="canonical" href="'.href_to_abs($ctype['name'], $item['slug'] . '.html').'">');

    // Добавляем класс для неактивных постов
    if (isset($item['is_pub']) && $item['is_pub'] < 1) {
        $this->addHead('<style>.content_item_wrap { position: relative; } .content_item_wrap.item--inactive .r-img { position: relative; } .content_item_wrap.item--inactive .r-img img { filter: grayscale(100%); opacity: 0.7; } .content_item_wrap.item--inactive::after { content: "НЕ АКТИВНО"; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.7); color: #fff; padding: 15px 30px; font-size: 18px; font-weight: bold; border-radius: 8px; z-index: 100; pointer-events: none; }</style>');
    }

    // === Open Graph / Twitter Card / SEO ===

    $_og_url   = href_to_abs($ctype['name'], $item['slug'] . '.html');
    $_og_title = htmlspecialchars(!empty($item_seo['title_str']) ? $item_seo['title_str'] : $item['title'], ENT_QUOTES, 'UTF-8');

    // Описание: SEO desc → краткое описание из полей → пусто
    $_og_desc_raw = '';
    if (!empty($item_seo['desc_str'])) {
        $_og_desc_raw = $item_seo['desc_str'];
    } elseif (!empty($item['description'])) {
        $_og_desc_raw = strip_tags($item['description']);
    } elseif (!empty($item['intro_text'])) {
        $_og_desc_raw = strip_tags($item['intro_text']);
    }
    $_og_desc = htmlspecialchars(mb_substr($_og_desc_raw, 0, 300), ENT_QUOTES, 'UTF-8');

    // Изображение: ищем по убыванию качества
    $_og_image = '';
    if (!empty($item['photo'])) {
        $_og_image = html_image_src($item['photo'], 'big', true, false)
                  ?: html_image_src($item['photo'], 'medium', true, false)
                  ?: html_image_src($item['photo'], 'small', true, false);
    }

    // --- Open Graph ---
    $this->addHead('<meta property="og:locale" content="ru_RU">');
    $this->addHead('<meta property="og:type" content="article">');
    $this->addHead('<meta property="og:site_name" content="'.htmlspecialchars($config->site_name ?? '', ENT_QUOTES, 'UTF-8').'">');
    $this->addHead('<meta property="og:url" content="'.$_og_url.'">');
    $this->addHead('<meta property="og:title" content="'.$_og_title.'">');

    if ($_og_desc) {
        $this->addHead('<meta property="og:description" content="'.$_og_desc.'">');
    }

    if ($_og_image) {
        $this->addHead('<meta property="og:image" content="'.$_og_image.'">');
        $this->addHead('<meta property="og:image:type" content="image/jpeg">');
    }

    if (!empty($item['date_pub'])) {
        $this->addHead('<meta property="article:published_time" content="'.date('c', strtotime($item['date_pub'])).'">');
    }
    if (!empty($item['date_last_modified'])) {
        $this->addHead('<meta property="article:modified_time" content="'.date('c', strtotime($item['date_last_modified'])).'">');
    }

    // --- Twitter Card ---
    if ($_og_image) {
        $this->addHead('<meta name="twitter:card" content="summary_large_image">');
        $this->addHead('<meta name="twitter:image" content="'.$_og_image.'">');
    } else {
        $this->addHead('<meta name="twitter:card" content="summary">');
    }
    $this->addHead('<meta name="twitter:title" content="'.$_og_title.'">');
    if ($_og_desc) {
        $this->addHead('<meta name="twitter:description" content="'.$_og_desc.'">');
    }

    // === /Open Graph ===

    $is_inactive = isset($item['is_pub']) && $item['is_pub'] < 1;
    if ($is_inactive) { echo '<div class="content_item_wrap item--inactive">'; }

    $this->renderContentItem($ctype['name'], [
        'item'             => $item,
        'ctype'            => $ctype,
        'fields'           => $fields,
        'fields_fieldsets' => $fields_fieldsets,
        'props'            => $props,
        'props_values'     => $props_values,
        'props_fields'     => $props_fields,
        'props_fieldsets'  => $props_fieldsets,
    ]);

    if ($is_inactive) { echo '</div>'; }

    if (!empty($childs['lists'])){
        foreach($childs['lists'] as $list){
            if ($list['title']){ ?><h2><?php echo $list['title']; ?></h2><?php }
            echo $list['html'];
        }
    }

?>

<?php if ($item['is_approved'] && $item['approved_by'] && ($user->is_admin || $user->id == $item['user_id'])){ ?>
    <div class="content_moderator_info small text-muted my-3 text-right">
        <?php echo LANG_MODERATION_APPROVED_BY; ?>
        <a href="<?php echo href_to_profile($item['approved_by']); ?>">
            <?php echo $item['approved_by']['nickname']; ?>
        </a>
        <?php echo html_date_time($item['date_approved']); ?>
    </div>
<?php } ?>

<?php $this->block('after_content_item'); ?>

<?php if (!empty($item['comments_widget'])){ ?>
    <?php echo $item['comments_widget']; ?>
<?php } ?>
