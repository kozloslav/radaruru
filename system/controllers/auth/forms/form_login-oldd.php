<?php

class formAuthLogin extends cmsForm {

    public $show_unsave_notice = false;

    public function init() {

        return [
            'basic' => [
                'type'   => 'fieldset',
                'childs' => [
                    new fieldString('login_email', [
                        'type'  => 'email',
                        'options' => [
                            'placeholder' => LANG_EMAIL
                        ],
                        'rules' => [
                            ['required'],
                            ['email']
                        ]
                    ]),
                    new fieldString('login_password', [
                        'is_password' => true,
                        'options'     => [
                            'min_length' => 6,
                            'max_length' => 72,
                            'placeholder' => LANG_PASSWORD
                        ],
                        'rules' => [
                            ['required']
                        ]
                        ]),
                              new fieldHidden('remember', [
                        'default' => 1
                    ])
                ]
            ]
        ];
    }

}
