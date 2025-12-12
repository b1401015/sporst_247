<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table      = 'teams';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name','slug','logo','country'];
}
