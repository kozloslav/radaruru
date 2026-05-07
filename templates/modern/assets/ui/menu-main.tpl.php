
    <div id="js-carousel">
        <a class="js-prev"> <?php html_svg_icon('solid', 'angle-left'); ?></a>
        <div class="owl-carousel">
            <?php if(count($active_ids) > 0){?>
                <a title="Назад" class="menu-item eew menu-item-back" href=".">Назад</a>
            <?php } ?>
            <?php foreach ($menu as $id => $item) { ?>
                <?php $myLastElement = end($active_ids); ?>
                <?php if($item['parent_id']==$myLastElement){ ?>

                    <a <?php if (!empty($item['title'])) {?>title="<?php echo html($item['title']); ?>"<?php } ?> class="menu-item eew" href="<?php echo !empty($item['url']) ? html($item['url'], false) : 'javascript:void(0)'; ?>" <?php echo html_attr_str($item['attributes']); ?>>
                            <?php if (!empty($item['options']['icon'])) {
                                $icon_params = explode(':', $item['options']['icon']);
                                if(!isset($icon_params[1])){ array_unshift($icon_params, 'solid'); }
                                html_svg_icon($icon_params[0], $icon_params[1]);
                            } ?>
                            <?php if (!empty($item['title']) && empty($item['options']['hide_title'])) { ?>
                                <?php echo $item['title']; ?>
                            <?php } ?>
                            <?php if (isset($item['counter']) && $item['counter']){ ?>
                                <?php html($item['counter']); ?>
                            <?php } ?>
                    </a>
                <?php }?>
            <?php } ?>
        </div>
        <a class="js-next"><?php html_svg_icon('solid', 'angle-right'); ?></a>
    </div>

