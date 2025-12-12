<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchModel extends Model
{
    protected $table = 'matches';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'league_id','home_team_id','away_team_id',
        'kickoff','stadium','status','home_score','away_score'
    ];

    public function getTodayMatches()
    {
        $today = date('Y-m-d');
        return $this->select('matches.*, 
                              h.name as home_name, a.name as away_name,
                              l.name as league_name')
            ->join('teams h','h.id = matches.home_team_id')
            ->join('teams a','a.id = matches.away_team_id')
            ->join('leagues l','l.id = matches.league_id')
            ->where("DATE(kickoff)", $today)
            ->orderBy('kickoff','ASC')
            ->findAll();
    }

    public function getByLeague($leagueId, $status = null, $limit = 20, $offset = 0)
    {
        $builder = $this->select('matches.*, 
                              h.name as home_name, a.name as away_name,
                              l.name as league_name')
            ->join('teams h','h.id = matches.home_team_id')
            ->join('teams a','a.id = matches.away_team_id')
            ->join('leagues l','l.id = matches.league_id')
            ->where('matches.league_id', $leagueId)
            ->orderBy('kickoff','DESC');

        if ($status) {
            $builder->where('matches.status', $status);
        }

        return $builder->findAll($limit, $offset);
    }
}
