<?php
namespace App\Models;

use CodeIgniter\Model;

class LayoutPageModel extends Model
{
    protected $table = 'layout_pages';
    protected $allowedFields = ['page_type','ref_id','title','is_active'];
}
