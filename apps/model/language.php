<?php

class ModelLanguage extends Model
{

    public function getLanguages(): array
    {

        $language_data = [];
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE `status` = '1' ORDER BY `sort_order`, `name`");
        foreach ($query->rows as $result) {
            $language_data[$result['code']] = [
                'language_id' => $result['language_id'],
                'name'        => $result['name'],
                'code'        => $result['code'],
                'locale'      => $result['locale'],
                'image'       => $result['image'],
                'directory'   => $result['directory'],
                'sort_order'  => $result['sort_order'],
                'status'      => $result['status']
            ];
        }
        return $language_data;
    }
}
