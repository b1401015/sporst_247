<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'id';

    protected $allowedFields = ['key','value','type'];

    public function getValue($key, $default = null)
    {
        $row = $this->where('key', $key)->first();
        return $row ? $row['value'] : $default;
    }
}
