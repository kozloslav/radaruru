<?php

class actionGroupsGroup extends cmsAction {

    use icms\traits\services\fieldsParseable;

    public $lock_explicit_call = true;

    public function run($group, $display_closed = false) {

        // Получаем поля для данного типа контента
        // И парсим их, получая HTML полей
        $group['fields'] = $this->parseContentFields($group['fields'], $group);

        list($group, $fields) = cmsEventsManager::hook('group_before_view', [$group, $group['fields']]);

        // Строим поля, которые выведем в шаблоне
        $group['fields'] = $this->getViewableItemFields($fields, $group, 'owner_id', function($field, $item) use($display_closed) {
            return !($display_closed && !$field['is_in_closed']);
        });

        // Применяем хуки полей к записи
        $group = $this->applyFieldHooksToItem($group['fields'], $group);

        $fields_fieldsets = cmsForm::mapFieldsToFieldsets($group['fields'], function ($field, $user) {
            return empty($field['is_system']);
        });

        // Проверяем прохождение модерации
        if (!$group['is_approved']) {

            if (!$group['access']['is_moderator'] && !$group['access']['is_owner']) {
                return cmsCore::errorForbidden(LANG_MODERATION_NOTICE, true);
            }

            $item_view_notice = LANG_MODERATION_NOTICE;

            if ($group['access']['is_moderator']) {
                $item_view_notice = LANG_MODERATION_NOTICE_MODER;
            }

            cmsUser::addSessionMessage($item_view_notice, 'info');
        }

        $this->cms_template->addBreadcrumb(LANG_GROUPS, href_to('groups'));
        $this->cms_template->addBreadcrumb($group['title']);

        // Build combined content list from all ctypes attached to the group
        $combined_list_html = false;
        if (!empty($group['content_counts'])) {
            $content_model = cmsCore::getModel('content');
            $items_merged = [];

            foreach ($group['content_counts'] as $ctype_name => $count_info) {
                if (empty($count_info['is_in_list']) || empty($count_info['count'])) { continue; }

                $ctype = $content_model->getContentTypeByName($ctype_name);
                if (!$ctype || empty($ctype['is_in_groups'])) { continue; }

                $model = cmsCore::getModel('content');
                $model->orderBy('date_pub', 'desc');

                if (($this->cms_user->id == $group['owner_id']) || $this->cms_user->is_admin){
                    $model->disablePubFilter();
                    $model->disablePrivacyFilter();
                }

                $this->filterPrivacyGroupsContent($ctype, $model, $group);

                $model->filterEqual('parent_id', $group['id'])->filterEqual('parent_type', 'group');

                $items = $model->limit(0, 25)->getContentItems($ctype['name']);
                if (!$items) { continue; }

                foreach ($items as $it) {
                    $items_merged[] = [
                        'title'       => $it['title'],
                        'date_pub'    => $it['date_pub'],
                        'url'         => href_to($ctype['name'], $it['slug'] . '.html'),
                        'ctype_title' => empty($ctype['labels']['profile']) ? $ctype['title'] : $ctype['labels']['profile']
                    ];
                }
            }

            if ($items_merged) {
                usort($items_merged, function ($a, $b) {
                    return strcmp($b['date_pub'], $a['date_pub']);
                });

                $combined_list_html = $this->cms_template->render('group_combined_list', [
                    'items' => $items_merged,
                    'group' => $group
                ]);
            }
        }

        return $this->cms_template->render('group_view', [
            'display_closed'   => $display_closed,
            'options'          => $this->options,
            'group'            => $group,
            'fields_fieldsets' => $fields_fieldsets,
            'user'             => $this->cms_user,
            'wall_html'        => false, // Не используется, чтобы нотиса в старых шаблонах не было
            'combined_list_html' => $combined_list_html
        ]);
    }

}
