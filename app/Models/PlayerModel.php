<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table      = 'players';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'team_id','name','shirt_number','position','photo'
    ];
}
