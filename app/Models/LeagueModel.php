<?php

namespace App\Models;

use CodeIgniter\Model;

class LeagueModel extends Model
{
    protected $table      = 'leagues';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name','slug','season','type'];
}
