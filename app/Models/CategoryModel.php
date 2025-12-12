<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name','slug','parent_id','sort_order','is_active'
    ];

    public function getActive()
    {
        return $this->where('is_active',1)->orderBy('sort_order','ASC')->findAll();
    }
}
