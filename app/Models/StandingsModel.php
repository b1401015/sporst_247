<?php

namespace App\Models;

use CodeIgniter\Model;

class StandingsModel extends Model
{
    protected $table      = 'standings';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'league_id','team_id','played','win','draw','lose',
        'goals_for','goals_against','points'
    ];
}
