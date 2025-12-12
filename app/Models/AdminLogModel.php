<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminLogModel extends Model
{
    protected $table      = 'admin_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id','module','action','data'
    ];
}
