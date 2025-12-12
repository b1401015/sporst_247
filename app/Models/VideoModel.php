<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table      = 'videos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title','slug','summary','embed_url','thumbnail','status'
    ];
}
