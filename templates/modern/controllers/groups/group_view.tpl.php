<?php $this->renderChild('group_header', ['group' => $group]); ?>
<?php if ($display_closed) { ?>
    <div class="alert alert-warning my-3">
        <?php echo LANG_GROUP_IS_CLOSED; ?>
    </div>
<?php } ?>
<div id="group_profile" class="content_item groups_item">
    <div class="icms-content-fields r-item-block r-item-desc">
        <?php foreach ($fields_fieldsets as $fieldset_id => $fieldset) { ?>


            <?php if (!empty($fieldset['fields'])) { ?>
                <?php foreach ($fieldset['fields'] as $name => $field) { ?>
                    <?php if ($field['name'] == 'description') { ?>
                    <div class="field ft_<?php echo $field['type']; ?> f_<?php echo $field['name']; ?> <?php echo $field['options']['wrap_type']; ?>_field" <?php if($field['options']['wrap_width']){ ?> style="width: <?php echo $field['options']['wrap_width']; ?>;"<?php } ?>>
                        <?php if ($field['options']['label_in_item'] != 'none') { ?>
                            <div class="title_<?php echo $field['options']['label_in_item']; ?>"><?php html($field['title']); ?>: </div>
                        <?php } ?>
                        <div class="value"><?php echo $field['html']; ?></div>
                    </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

            <?php if ($fieldset['title']) { ?></div><?php } ?>

        <?php } ?>
    </div>

</div>

