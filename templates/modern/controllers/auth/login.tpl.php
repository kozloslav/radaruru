<?php
    $this->addBreadcrumb(LANG_LOG_IN);
    $is_ajax = $this->controller->request->isAjax();
?>

<?php if($ajax_page_redirect){ ?>
    <script>window.location.href='<?php echo $this->href_to('login'); ?>';</script>
    <?php return; ?>
<?php } ?>

<?php if(!$is_ajax){ ?>
<div class="r-content-form">

    <div class="r-content-form__head">
        <div class="r-content-form__icon">
            <?php html_svg_icon('solid', 'sign-in-alt', 22); ?>
        </div>
        <div class="r-content-form__head-text">
            <h1 class="r-content-form__title">
                <?php $this->pageH1();?>
            </h1>
        </div>
    </div>
<?php } ?>

<div class="left_cell">
    <?php
        $this->renderForm($form, $data, [
            'action' => href_to('auth', 'login'),
            'method' => 'post',
            'cancel' => [
                'show'  => $is_reg_enabled,
                'title' => LANG_NO_ACCOUNT.' '.LANG_REGISTRATION,
                'href'  => $this->href_to('register').($back_url ? '?back='.$back_url : '')
            ],
            'submit' => [
                'title' => LANG_LOG_IN
            ]
        ], $errors);
    ?>
</div>
<?php if($hooks_html){ ?>
    <div class="center_cell"><?php echo LANG_OR; ?></div>
    <div class="right_cell">
        <h3><?php echo LANG_LOG_IN_OPENID; ?></h3>
        <?php echo html_each($hooks_html); ?>
    </div>
<?php } ?>
<?php if(!$is_ajax){ ?>
</div>
<?php } ?>