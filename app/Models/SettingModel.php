<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'key';
    protected $allowedFields = ['key', 'value', 'company_id'];

    public function get($key, $default = null)
    {
        $row = $this->db->query('
            select ifnull(`value`, "") as `value`
            from settings
            where
            company_id=' . current_user()->company_id . '
            and `key`=:key:', [
            'key' => $key
        ])->getRow();
        return $row ? $row->value : $default;
    }

    public function setValue($key, $value, $company_id = null)
    {
        $this->db->query('
            INSERT INTO
            settings (`company_id`, `key`, `value`)
            VALUES   (:company_id:, :key:, :value:)
            ON DUPLICATE KEY UPDATE
            `company_id`=:company_id:,
            `key`=:key:,
            `value`=:value:', [
                'company_id' => $company_id ? $company_id : current_user()->company_id,
                'key' => $key,
                'value' => $value,
        ]);
    }
}