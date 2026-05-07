<?php $this->addTplJSName('subscriptions'); ?>
<div class="r-subscribe"
<div class="subscribe_wrap position-relative ml-lg-2 mb-2 mb-lg-0 d-flex flex-shrink-0">
    <a href="#" class="btn subscriber btn-responsive is-busy sub-btn" data-hash="<?php echo $hash; ?>" data-link0="<?php echo $this->href_to('subscribe'); ?>" data-link1="<?php echo $this->href_to('unsubscribe'); ?>" data-text0="<?php echo LANG_USERS_SUBSCRIBE; ?>" data-text1="<?php echo LANG_USERS_UNSUBSCRIBE; ?>" data-issubscribe="<?php echo (int)$user_is_subscribed; ?>" data-target="<?php html(json_encode($target)); ?>" title="" data-show_btn_title="<?php echo (int)$show_btn_title; ?>">
        <b class="icon-bell">
            <?php html_svg_icon('solid', 'bell'); ?>
        </b>
        <b class="icon-bell-slash">
            <?php html_svg_icon('solid', 'bell-slash'); ?>
        </b>
        <?php if($show_btn_title) { ?>
            <span class="icms-subscriptions__label"></span>
        <?php } ?>
    </a>
</div>
</div>
