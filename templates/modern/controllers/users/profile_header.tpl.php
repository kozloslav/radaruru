<?php
$this->addTplJSName('users');
$this->setPagePatternH1($meta_profile, 'nickname');
$user = cmsUser::getInstance();
?>

<div id="user_profile_title" class="up-header">
    <div class="up-header__body">
        <!-- Avatar -->
        <div class="up-avatar-wrap">
            <div class="up-avatar icms-user-avatar <?php if (!empty($profile['is_online'])){ ?>peer_online<?php } else { ?>peer_no_online<?php } ?>">
                <?php if(!empty($profile['avatar'])){ ?>
                    <?php echo html_avatar_image($profile['avatar'], $fields['avatar']['options']['size_teaser'] ?? 'small', $profile['nickname']); ?>
                <?php } else { ?>
                    <?php echo html_avatar_image_empty($profile['nickname'], 'avatar__inlist'); ?>
                <?php } ?>
            </div>
            <?php if (!empty($profile['is_online'])){ ?>
                <span class="up-status-dot up-status-dot--online" title="<?php echo LANG_ONLINE; ?>" data-toggle="tooltip"></span>
            <?php } else { ?>
                <span class="up-status-dot up-status-dot--offline" title="<?php echo defined('LANG_OFFLINE') ? LANG_OFFLINE : 'Не в сети'; ?>" data-toggle="tooltip"></span>
            <?php } ?>
        </div>

        <!-- Name + status -->
        <div class="up-info">
            <h1 class="up-name">
                <?php $this->pageH1(); ?>
                <?php if ($profile['is_locked']){ ?>
                    <span class="up-badge up-badge--lock" title="<?php html(LANG_USERS_LOCKED_NOTICE_PUBLIC.($profile['lock_reason'] ? ': '.$profile['lock_reason'] : '').($profile['lock_until'] ? "\n ".sprintf(LANG_USERS_LOCKED_NOTICE_UNTIL, strip_tags(html_date($profile['lock_until']))) : '')); ?>" data-toggle="tooltip" data-placement="top">
                        <?php html_svg_icon('solid', 'lock'); ?>
                    </span>
                <?php } ?>
                <?php if ($profile['is_deleted']){ ?>
                    <span class="up-badge up-badge--del" title="<?php echo LANG_USERS_IS_DELETED; ?>" data-toggle="tooltip">
                        <?php html_svg_icon('solid', 'user-slash'); ?>
                    </span>
                <?php } ?>
            </h1>

            <?php if ($this->controller->options['is_status']) { ?>
                <div class="status up-status" <?php if (!$profile['status']){ ?>style="display:none"<?php } ?>>
                    <span class="text"><?php if ($profile['status']){ html($profile['status']['content']); } ?></span>
                    <?php if ($user->is_logged){ ?>
                        <?php if ($this->controller->options['is_wall'] && cmsController::enabled('wall')){ ?>
                            <?php if (!empty($profile['status']['wall_entry_id'])) { ?>
                                <?php if (empty($profile['status']['replies_count'])) { ?>
                                    <a class="icms-user-profile__status_reply up-status__action" href="<?php echo href_to_profile($profile)."?wid={$profile['status']['wall_entry_id']}&reply=1"; ?>">
                                        <?php html_svg_icon('solid', 'reply'); ?>
                                        <span><?php echo LANG_REPLY; ?></span>
                                    </a>
                                <?php } else { ?>
                                    <a class="icms-user-profile__status_reply up-status__action" href="<?php echo href_to_profile($profile)."?wid={$profile['status']['wall_entry_id']}"; ?>">
                                        <?php html_svg_icon('solid', 'reply'); ?>
                                        <span><?php echo html_spellcount($profile['status']['replies_count'], LANG_REPLY_SPELLCOUNT); ?></span>
                                    </a>
                                <?php } ?>
                            <?php } else { ?>
                                <a class="icms-user-profile__status_reply up-status__action" href="">
                                    <?php html_svg_icon('solid', 'reply'); ?>
                                    <span><?php echo LANG_REPLY; ?></span>
                                </a>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($profile['id'] == $user->id || $user->is_admin) { ?>
                            <a class="icms-user-profile__status_delete up-status__action up-status__action--danger" href="#delete-status" data-url="<?php echo $this->href_to('status_delete', $profile['id']); ?>" title="<?php echo LANG_DELETE; ?>" data-toggle="tooltip">
                                <?php html_svg_icon('solid', 'trash'); ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <!-- Stats pills -->
        <?php if (!$profile['is_deleted']){ ?>
            <div class="up-stats">
                <?php if ($this->controller->options['is_karma']) { ?>
                    <div class="up-pill up-pill--karma <?php echo $profile['karma'] > 0 ? 'up-pill--positive' : ($profile['karma'] < 0 ? 'up-pill--negative' : ''); ?>"
                         id="user_profile_rates"
                         data-url="<?php echo $this->href_to('karma_vote', $profile['id']); ?>"
                         data-log-url="<?php echo $this->href_to('karma_log', $profile['id']); ?>"
                         data-is-comment="<?php echo $this->controller->options['is_karma_comments']; ?>">
                        <?php if ($profile['is_can_vote_karma']){ ?>
                            <a href="#vote-up" class="thumb thumb_up up-pill__vote" title="<?php echo LANG_KARMA_UP; ?>" data-toggle="tooltip">
                                <?php html_svg_icon('solid', 'thumbs-up'); ?>
                            </a>
                        <?php } ?>
                        <div class="up-pill__body">
                            <span class="value up-pill__value"><?php echo html_signed_num($profile['karma']); ?></span>
                            <span class="up-pill__label"><?php echo LANG_KARMA; ?></span>
                        </div>
                        <?php if ($profile['is_can_vote_karma']){ ?>
                            <a href="#vote-down" class="thumb thumb_down up-pill__vote" title="<?php echo LANG_KARMA_DOWN; ?>" data-toggle="tooltip">
                                <?php html_svg_icon('solid', 'thumbs-down'); ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if (cmsController::enabled('rating')) { ?>
                    <div class="up-pill up-pill--rating" id="user_profile_ratings">
                        <div class="up-pill__body">
                            <span class="value up-pill__value"><?php echo $profile['rating']; ?></span>
                            <span class="up-pill__label"><?php echo LANG_RATING; ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

<?php if ($this->controller->options['is_status'] && $profile['id'] == $user->id) { ?>
    <?php ob_start(); ?>
        <script><?php echo $this->getLangJS('LANG_REPLY', 'LANG_USERS_DELETE_STATUS_CONFIRM'); ?></script>
    <?php $this->addBottom(ob_get_clean()); ?>
    <div id="user_status_widget" class="up-status-input">
        <?php
            echo html_input('text', 'status', '', array(
                'maxlength' => 140,
                'class' => 'form-control form-control-sm',
                'placeholder' => sprintf(LANG_USERS_WHAT_HAPPENED, $profile['nickname']),
                'data-url' => $this->href_to('status'),
                'data-user-id' => $profile['id']
            ));
        ?>
    </div>
<?php } ?>

<?php if ($this->controller->options['is_karma_comments']) { ?>
    <?php ob_start(); ?>
        <script><?php echo $this->getLangJS('LANG_USERS_KARMA_COMMENT'); ?></script>
    <?php $this->addBottom(ob_get_clean()); ?>
<?php } ?>

<?php if (!isset($is_can_view) || $is_can_view){ ?>
    <?php if (empty($tabs)){ $tabs = $this->controller->getProfileMenu($profile); } ?>
    <?php if (count($tabs)>1){ ?>
        <?php $this->addMenuItems('profile_tabs', $tabs); ?>
        <div class="mobile-menu-wrapper mobile-menu-wrapper__tab up-tabs">
            <?php $this->menu('profile_tabs', true, 'icms-profile__tabs nav nav-tabs', $this->controller->options['max_tabs']); ?>
        </div>
    <?php } ?>
<?php } ?>