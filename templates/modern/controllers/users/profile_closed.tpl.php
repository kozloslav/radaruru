<?php

    $this->addTplJSName('jquery-ui');
    $this->addTplCSSName('jquery-ui');

    $this->setPageTitle($profile['nickname']);

    if($this->controller->listIsAllowed()){
        $this->addBreadcrumb(LANG_USERS, href_to('users'));
    }
    $this->addBreadcrumb($profile['nickname']);

    if (is_array($tool_buttons)){
        foreach($tool_buttons as $button){
            $this->addToolButton($button);
        }
    }

?>

<?php $this->renderChild('profile_header', ['profile' => $profile, 'meta_profile' => $meta_profile, 'tabs' => false, 'is_can_view' => false, 'fields' => $fields]); ?>

<div class="icms-users-profile__view up-body row mt-3 mt-md-4">

    <div id="left_column" class="col-md-3">
        <?php $this->block('after_profile_avatar'); ?>
    </div>

    <div id="right_column" class="col-md-9 mt-3 mt-md-0">
        <div id="information" class="content_item up-card up-card--info">
            <div class="fieldset up-fieldset">
                <div class="fieldset_title up-fieldset__title">
                    <h3><?php echo LANG_USERS_PROFILE_IS_HIDDEN; ?></h3>
                </div>
                <?php foreach($sys_fields as $name => $field){ ?>
                    <div class="field ft_string f_<?php echo $name; ?> up-field">
                        <div class="text-secondary title title_left up-field__label">
                            <?php echo $field['title']; ?>:
                        </div>
                        <div class="value up-field__value">
                            <?php echo $field['text']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>