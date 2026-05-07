<?php

    $this->setPagePatternTitle($meta_profile, 'nickname');
    $this->setPagePatternDescription($meta_profile, 'nickname');

    if($this->controller->listIsAllowed()){
        $this->addBreadcrumb(LANG_USERS, href_to('users'));
    }
    $this->addBreadcrumb($profile['nickname']);

    $this->addToolButtons($tool_buttons);

?>

<?php $this->renderChild('profile_header', ['profile' => $profile, 'meta_profile' => $meta_profile, 'tabs' => $tabs, 'fields' => $fields]); ?>

<div id="user_profile" class="icms-users-profile__view up-body row mt-3 mt-md-4">

    <div id="left_column" class="col-md-3">

        <?php $this->block('after_profile_avatar'); ?>

        <?php if ($is_friends_on && $friends) { ?>
            <div class="up-card up-card--friends">
                <div class="up-card__head">
                    <span class="up-card__title">
                        <?php if($show_all_flink){ ?>
                            <a href="<?php echo href_to_profile($profile, 'friends'); ?>"><?php echo LANG_USERS_FRIENDS; ?></a>
                        <?php } else { ?>
                            <?php echo LANG_USERS_FRIENDS; ?>
                        <?php } ?>
                    </span>
                    <span class="up-card__count"><?php echo $profile['friends_count']; ?></span>
                </div>
                <div class="up-friends-grid">
                    <?php foreach($friends as $friend){ ?>
                        <a href="<?php echo href_to_profile($friend); ?>" class="up-friend icms-user-avatar <?php if (!empty($friend['is_online'])){ ?>peer_online<?php } else { ?>peer_no_online<?php } ?>" title="<?php html($friend['nickname']); ?>" data-toggle="tooltip" data-placement="top">
                            <?php if($friend['avatar']){ ?>
                                <?php echo html_avatar_image($friend['avatar'], 'micro', $friend['nickname']); ?>
                            <?php } else { ?>
                                <?php echo html_avatar_image_empty($friend['nickname'], 'avatar__mini'); ?>
                            <?php } ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <div class="up-card up-card--content content_counts">
            <?php if ($content_counts) { ?>
                <?php foreach($content_counts as $ctype_name=>$count){ ?>
                    <?php if (!$count['is_in_list']) { continue; } ?>
                    <a class="up-ccount" href="<?php echo href_to_profile($profile, ['content', $ctype_name]); ?>">
                        <span class="up-ccount__title"><?php html($count['title']); ?></span>
                        <span class="up-ccount__num"><?php html($count['count']); ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>

        <?php $this->block('users_profile_view_blocks'); ?>
    </div>

    <div id="right_column" class="col-md-9 mt-3 mt-md-0">
        <div id="information" class="content_item up-card up-card--info">

            <?php foreach($sys_fields as $name => $field){ ?>
                <div class="field ft_string f_<?php echo $name; ?> up-field">
                    <div class="text-secondary title title_left up-field__label">
                        <?php echo $field['title']; ?>:
                    </div>
                    <div class="value up-field__value">
                        <?php if (!empty($field['href'])){ ?>
                            <a href="<?php echo $field['href']; ?>">
                                <?php echo $field['text']; ?>
                            </a>
                        <?php } else {?>
                            <?php echo $field['text']; ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php foreach($fieldsets as $fieldset){ ?>

                <?php if (!$fieldset['fields']) { continue; } ?>

                <div class="fieldset up-fieldset">

                <?php if ($fieldset['title']){ ?>
                    <div class="fieldset_title up-fieldset__title">
                        <h3><?php echo $fieldset['title']; ?></h3>
                    </div>
                <?php } ?>

                <?php foreach($fieldset['fields'] as $field){ ?>
                    <?php
                        if (!isset($field['options']['label_in_item'])) {
                            $label_pos = 'none';
                        } else {
                            $label_pos = $field['options']['label_in_item'];
                        }
                    ?>

                    <div class="field ft_<?php echo $field['type']; ?> f_<?php echo $field['name']; ?> up-field">
                        <?php if ($label_pos != 'none'){ ?>
                            <div class="text-secondary title title_<?php echo $label_pos; ?> up-field__label"><?php echo $field['title']; ?>: </div>
                        <?php } ?>
                        <div class="value up-field__value">
                            <?php echo $field['html']; ?>
                        </div>
                    </div>
                <?php } ?>

                </div>
            <?php } ?>

            <?php $this->block('users_profile_information_blocks'); ?>
        </div>
    </div>
</div>
<?php $this->block('users_profile_view_bottom'); ?>
