<?php if(!isset($ds_prefix)){ $ds_prefix = '/'; } ?>
<?php $active_filters_query = $this->controller->getActiveFiltersQuery(); ?>
<div class="card-header r-header">
    <ul class="nav nav-tabs border-0 menu-group_tabs">
        <?php $ds_counter = 0; ?>
        <?php foreach($datasets as $set){ ?>
            <?php $ds_selected = ($dataset_name == $set['name'] || (!$dataset_name && $ds_counter==0)); ?>
            <li class="nav-item <?php if ($ds_selected){ ?> is-active<?php } ?> nav-item__<?php echo $set['name'].(!empty($set['target_controller']) ? '_'.$set['target_controller'] : ''); ?>">

                <?php $ds_url = sprintf($base_ds_url, ($ds_counter > 0 ? $ds_prefix.$set['name'] : '')); ?>

                <?php if ($ds_selected){ ?>
                    <span class="nav-link nowrap active">
                        <?php echo $set['title']; ?>
                        <?php if (!empty($set['counter'])){ ?>
                            <span class="ml-1 counter badge"><?php html($set['counter']); ?></span>
                        <?php } ?>
                    </span>
                <?php } else { ?>
                    <a class="nav-link text-nowrap" href="<?php html($ds_url.($active_filters_query ? '?'.$active_filters_query : '')); ?>">
                        <?php echo $set['title']; ?>
                        <?php if (!empty($set['counter'])){ ?>
                            <span class="ml-1 counter badge"><?php html($set['counter']); ?></span>
                        <?php } ?>
                    </a>
                <?php } ?>
            </li>
            <?php $ds_counter++; ?>
        <?php } ?>
    </ul>
</div>
<?php if (!empty($current_dataset['description'])){ ?>
    <div class="content_datasets_description">
        <?php echo $current_dataset['description']; ?>
    </div>
<?php } ?>
