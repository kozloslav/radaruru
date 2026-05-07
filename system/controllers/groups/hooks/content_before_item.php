<?php

class onGroupsContentBeforeItem extends cmsAction {

    public function run($data){

        list($ctype, $item, $fields) = $data;

        // Временная отладка - записываем в лог
        error_log('DEBUG: content_before_item hook called. Parent type: ' . ($item['parent_type'] ?? 'none') . ', Parent ID: ' . ($item['parent_id'] ?? 'none'));

        if (!empty($item['parent_id'])){

            $group = $this->model->getGroup($item['parent_id']);

            if ($group){

                error_log('DEBUG: Group found. Adding parent_url_market...');
                
                // Получаем url_market через модель контента
                $content_model = cmsCore::getModel('content');
                $content_model->setTablePrefix('');
                
                $groups_fields = $content_model->getContentFields('groups');
                
                $url_market_found = false;
                foreach($groups_fields as $field){
                    if($field['name'] === 'url_market'){
                        // Создаем новый экземпляр модели groups для получения поля
                        $groups_model = cmsCore::getModel('groups');
                        $field_value = $groups_model->selectOnly($field['name'])->getItemById('groups', $item['parent_id'], $field['name']);
                        
                        // Если field_value массив, пробуем извлечь значение
                        if(is_array($field_value)) {
                            $item['parent_url_market'] = $field_value['url_market'] ?? $field_value['html'] ?? $field_value['value'] ?? $field_value['url'] ?? '';
                        } else {
                            $item['parent_url_market'] = $field_value;
                        }
                        
                        $url_market_found = true;
                        error_log('DEBUG: url_market found via content fields: ' . (is_array($field_value) ? print_r($field_value, true) : $field_value));
                        break;
                    }
                }
                
                // Если поле не найдено через поля контента, пробуем прямой SQL-запрос
                if(!$url_market_found) {
                    $database = cmsCore::getInstance()->db;
                    $result = $database->query("SELECT url_market FROM {#}groups WHERE id = ?", [$item['parent_id']]);
                    if($result) {
                        $row = $result->fetch('assoc');
                        if($row && !empty($row['url_market'])) {
                            $item['parent_url_market'] = $row['url_market'];
                            $url_market_found = true;
                            error_log('DEBUG: url_market found via direct SQL: ' . $row['url_market']);
                        }
                    }
                }
                
                // Если все еще не найдено, пробуем таблицу с полями
                if(!$url_market_found) {
                    $database = cmsCore::getInstance()->db;
                    $result = $database->query("SELECT url_market FROM {#}groups_fields WHERE item_id = ?", [$item['parent_id']]);
                    if($result) {
                        $row = $result->fetch('assoc');
                        if($row && !empty($row['url_market'])) {
                            $item['parent_url_market'] = $row['url_market'];
                            error_log('DEBUG: url_market found via fields table: ' . $row['url_market']);
                        }
                    }
                }

                if(!$url_market_found) {
                    error_log('DEBUG: url_market NOT found anywhere');
                }

                $group['access'] = $this->getGroupAccess($group);

                // администраторы групп могут отвязывать контент
                if ($group['access']['member_role'] == groups::ROLE_STAFF) {

                    $this->cms_template->addToolButton(array(
                        'class' => 'newspaper_delete ajax-modal',
                        'icon'  => 'unlink',
                        'title' => LANG_GROUPS_UNBIND,
                        'href'  => href_to($this->name, $group['slug'], array('unbind', $ctype['name'], $item['id']))
                    ));

                }

            } else {
                error_log('DEBUG: Group NOT found for ID: ' . $item['parent_id']);
            }

        } else {
            error_log('DEBUG: Condition not met. parent_id empty');
        }

        return array($ctype, $item, $fields);

    }

}
