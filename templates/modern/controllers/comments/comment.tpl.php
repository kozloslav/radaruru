<?php
    $limit_nesting = !empty($this->controller->options['limit_nesting']) ? $this->controller->options['limit_nesting'] : 0;
    $dim_negative  = !empty($this->controller->options['dim_negative']);
    $is_highlight_new = isset($is_highlight_new) ? $is_highlight_new : false;
    if (!isset($is_can_rate)) { $is_can_rate = false; }
?>

<?php foreach ($comments as $entry) {

    $no_approved_class = $entry['is_approved'] ? '' : 'no_approved';
    $author_url = !$entry['user']['is_deleted'] ? href_to_profile($entry['user']) : '';

    if ($is_show_target) {
        $target_url = rel_to_href($entry['target_url']) . "#comment_{$entry['id']}";
    }

    $is_selected = $is_highlight_new && (strtotime($entry['date_pub']) > strtotime($user->date_log));

    $level = 0;
    if ($is_levels) {
        $level = (($limit_nesting && $entry['level'] > $limit_nesting) ? $limit_nesting : ($entry['level'] - 1));
    }

    $dim_class = '';
    if ($dim_negative && !$entry['is_deleted'] && $entry['rating'] < 0) {
        $n = min(6, abs((int) $entry['rating']));
        $dim_class = " bad bad{$n}";
    }
?>

<div id="comment_<?php echo $entry['id']; ?>"
     class="r-cmt comment icms-comments-ns ns-<?php echo $level; ?><?php if ($is_selected) { ?> r-cmt--new selected-comment<?php } ?><?php echo $dim_class; ?>"
     data-level="<?php echo $entry['level']; ?>">

    <div class="r-cmt__card media-body">

        <!-- Шапка: аватар / имя / дата  +  рейтинг -->
        <div class="r-cmt__head">

            <!-- Левая часть: аватар + мета -->
            <div class="r-cmt__author">
                <?php if (!$entry['is_deleted']) { ?>
                    <div class="r-cmt__ava">
                        <?php if ($author_url) { ?>
                            <a href="<?php echo $author_url; ?>"
                               class="icms-user-avatar <?php echo !empty($entry['user']['is_online']) ? 'peer_online' : 'peer_no_online'; ?>">
                                <?php echo html_avatar_image($entry['user']['avatar'], 'micro', $entry['user']['nickname']); ?>
                            </a>
                        <?php } else { ?>
                            <span class="icms-user-avatar">
                                <?php echo html_avatar_image($entry['user']['avatar'], 'micro', $entry['user']['nickname']); ?>
                            </span>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="r-cmt__meta">
                    <?php if (!$entry['is_deleted']) { ?>
                        <?php if ($author_url) { ?>
                            <a href="<?php echo $author_url; ?>"
                               class="r-cmt__name user<?php if ($entry['user_id'] && isset($target_user_id) && $target_user_id == $entry['user_id']) { ?> r-cmt__name--op<?php } ?>">
                                <?php echo $entry['user']['nickname']; ?>
                            </a>
                        <?php } else { ?>
                            <span class="r-cmt__name user r-cmt__name--guest">
                                <?php echo $entry['author_name'] ?? LANG_GUEST; ?>
                            </span>
                            <?php if ($user->is_admin && !empty($entry['author_ip'])) { ?>
                                <span class="r-cmt__ip">[<?php echo $entry['author_ip']; ?>]</span>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                    <?php if ($is_show_target && !empty($entry['target_title'])) { ?>
                        <span class="r-cmt__target">
                            → <a href="<?php echo $target_url; ?>"><?php html($entry['target_title']); ?></a>
                        </span>
                    <?php } ?>

                    <?php if (empty($entry['hide_date'])) { ?>
                        <span class="r-cmt__date <?php echo $no_approved_class; ?>">
                            <?php echo string_date_age_max($entry['date_pub'], true); ?>
                            <?php if ($entry['date_last_modified']) { ?>
                                <span class="r-cmt__edited"
                                      data-toggle="tooltip" data-placement="top"
                                      title="<?php echo LANG_CONTENT_EDITED . ' ' . strip_tags(html_date_time($entry['date_last_modified'])); ?>">
                                    <?php html_svg_icon('solid', 'pen'); ?>
                                </span>
                            <?php } ?>
                            <?php if ($no_approved_class) { ?>
                                <span class="ml-1"><?php echo html_bool_span(LANG_CONTENT_NOT_APPROVED, false); ?></span>
                            <?php } ?>
                        </span>
                    <?php } ?>
                </div>
            </div>

            <!-- Правая часть: рейтинг-пилюля + якорь -->
            <div class="r-cmt__right">
                <?php if (!$entry['is_deleted']) { ?>
                    <div class="r-cmt__rating icms-comment-rating <?php echo $no_approved_class; ?>">
                        <?php if ($is_can_rate && $entry['user_id'] != $user->id && empty($entry['is_rated'])) { ?>
                            <a href="#rate-up"
                               class="r-cmt__rate-btn r-cmt__rate-btn--up rate-up"
                               title="<?php echo html(LANG_COMMENT_RATE_UP); ?>"
                               data-id="<?php echo $entry['id']; ?>">
                                <?php html_svg_icon('solid', 'arrow-up'); ?>
                            </a>
                        <?php } else { ?>
                            <span class="r-cmt__rate-btn r-cmt__rate-btn--dis rate-disabled">
                                <?php html_svg_icon('solid', 'arrow-up'); ?>
                            </span>
                        <?php } ?>

                        <span class="r-cmt__rate-val value <?php echo html_signed_class($entry['rating']); ?>">
                            <?php echo $entry['rating'] ? html_signed_num($entry['rating']) : '0'; ?>
                        </span>

                        <?php if ($is_can_rate && $entry['user_id'] != $user->id && empty($entry['is_rated'])) { ?>
                            <a href="#rate-down"
                               class="r-cmt__rate-btn r-cmt__rate-btn--down rate-down"
                               title="<?php echo html(LANG_COMMENT_RATE_DOWN); ?>"
                               data-id="<?php echo $entry['id']; ?>">
                                <?php html_svg_icon('solid', 'arrow-down'); ?>
                            </a>
                        <?php } else { ?>
                            <span class="r-cmt__rate-btn r-cmt__rate-btn--dis rate-disabled">
                                <?php html_svg_icon('solid', 'arrow-down'); ?>
                            </span>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>

        <!-- Текст -->
        <?php if ($entry['is_deleted']) { ?>
            <p class="r-cmt__deleted">
                <?php html_svg_icon('solid', 'ban'); ?>
                <?php echo LANG_COMMENT_DELETED; ?>
            </p>
        <?php } elseif (!empty($entry['hide_controls'])) { ?>
            <div class="r-cmt__text"><?php echo $entry['content_html']; ?></div>
        <?php } else { ?>
            <div class="r-cmt__text icms-comment-html text-break">
                <?php echo $entry['content_html']; ?>
            </div>
        <?php } ?>

        <!-- Действия -->
        <?php if (!$entry['is_deleted'] && empty($entry['hide_controls']) && !empty($entry['actions'])) { ?>
            <div class="r-cmt__actions icms-comment-controls">
                <?php foreach ($entry['actions'] as $action) { ?>
                    <a href="<?php echo $action['href']; ?>"
                       class="r-cmt__act<?php if (!empty($action['class'])) { ?> <?php echo $action['class']; ?><?php } ?>"
                       <?php if (!empty($action['hint'])) { ?> title="<?php html($action['hint']); ?>" data-toggle="tooltip" data-placement="top"<?php } ?>
                       data-id="<?php echo $entry['id']; ?>">
                        <?php if (!empty($action['icon'])) { html_svg_icon('solid', $action['icon']); } ?>
                        <?php if (!empty($action['title'])) { ?><span><?php echo $action['title']; ?></span><?php } ?>
                    </a>
                <?php } ?>
                <?php if ($is_controls) { ?>
                    <?php if ($entry['parent_id']) { ?>
                        <a href="#up" class="r-cmt__act scroll-up"
                           data-id="<?php echo $entry['id']; ?>"
                           data-parent_id="<?php echo $entry['parent_id']; ?>"
                           title="<?php html(LANG_COMMENT_SHOW_PARENT); ?>">
                            <?php html_svg_icon('solid', 'arrow-up'); ?>
                        </a>
                    <?php } ?>
                    <a href="#down" class="r-cmt__act d-none scroll-down"
                       title="<?php echo html(LANG_COMMENT_SHOW_CHILD); ?>">
                        <?php html_svg_icon('solid', 'arrow-down'); ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>

    </div>
</div>

<?php } ?>
