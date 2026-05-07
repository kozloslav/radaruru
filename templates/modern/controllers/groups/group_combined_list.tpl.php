<?php if (!empty($items)) { ?>
    <div class="card my-3 group_combined_list">
        <div class="card-header">
            <strong><?php echo LANG_CONTENT; ?></strong>
        </div>
        <ul class="list-group list-group-flush">
            <?php foreach ($items as $item) { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="<?php echo $item['url']; ?>"><?php html($item['title']); ?></a>
                    <span class="badge bg-secondary text-wrap">
                        <?php echo $item['ctype_title']; ?> · <?php echo string_date_age_max($item['date_pub'], true); ?>
                    </span>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

