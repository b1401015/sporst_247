<?php

namespace App\Models;

use CodeIgniter\Model;

class MedalModel extends Model
{
    protected $table      = 'medals';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'country_id','gold','silver','bronze','total','event_name'
    ];
}
