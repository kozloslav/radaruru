<?php
/**
 * @property \modelContent $model
 * @property \modelUsers $model_users
 * @property \messages $controller_messages
 */
class actionContentItemNotActual extends cmsAction {

    public function run() {

        if (!$this->request->isAjax()) {
            return cmsCore::error404();
        }

        $ctype = $this->model->getContentTypeByName($this->request->get('ctype_name', ''));
        if (!$ctype) {
            return cmsCore::error404();
        }

        $id = (int) $this->request->get('id', 0);
        if (!$id) {
            return cmsCore::error404();
        }

        $item = $this->model->getContentItem($ctype['name'], $id);
        if (!$item) {
            return cmsCore::error404();
        }

        $cookie_key = 'not_actual_' . $ctype['name'] . $id;

        $already_reported = cmsUser::getCookie($cookie_key) ? true : false;

        if (!$already_reported && $this->cms_user->is_logged) {
            $already_reported = (bool) cmsUser::getUPS($cookie_key);
        }

        if ($already_reported) {

            return $this->cms_template->renderJSON([
                'success' => false,
                'message' => LANG_CONTENT_NOT_ACTUAL_ALREADY
            ]);
        }

        $admin_id = $this->model_users->filterEqual('is_admin', 1)->getFieldFiltered('{users}', 'id');

        if ($admin_id) {

            if ($this->cms_user->is_logged) {
                $sender_name = '<a href="' . href_to_profile($this->cms_user) . '">' . $this->cms_user->nickname . '</a>';
            } else {
                $sender_name = LANG_GUEST;
            }

            $item_link = '<a href="' . href_to($ctype['name'], $item['slug'] . '.html') . '">' . $item['title'] . '</a>';

            $this->controller_messages->addRecipient($admin_id)->sendNoticePM([
                'content' => sprintf(LANG_CONTENT_NOT_ACTUAL_NOTICE, $sender_name, $ctype['labels']['one_genitive'], $item_link),
                'actions' => [
                    'view' => [
                        'title' => LANG_SHOW,
                        'href'  => href_to($ctype['name'], $item['slug'] . '.html')
                    ]
                ]
            ]);
        }

        cmsUser::setCookie($cookie_key, 1, 31536000);

        if ($this->cms_user->is_logged) {
            cmsUser::setUPS($cookie_key, 1);
        }

        return $this->cms_template->renderJSON([
            'success' => true,
            'message' => LANG_CONTENT_NOT_ACTUAL_SENT
        ]);
    }

}
