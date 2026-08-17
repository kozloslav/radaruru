<div class="r-item-block r-item-desc static-page">
    <h1><?php html($item['title']); ?></h1>
    <?php if (!empty($item['date_last_modified'])) { ?>
        <div class="text-muted small mb-3">Обновлено: <?php echo html_date($item['date_last_modified']); ?></div>
    <?php } ?>
    <?php echo $item['content']; ?>
</div>
