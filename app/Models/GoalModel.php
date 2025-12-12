<?php

namespace App\Models;

use CodeIgniter\Model;

class GoalModel extends Model
{
    protected $table      = 'goals';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'match_id','player_id','minute','is_own_goal','is_penalty'
    ];
}
