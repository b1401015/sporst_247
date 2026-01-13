<?php
namespace App\Models;

use CodeIgniter\Model;

class LayoutBlockModel extends Model
{
    protected $table = 'layout_blocks';
    protected $allowedFields = [
        'page_id','region','block_type_id','title',
        'sort_order','is_active','config'
    ];
}
