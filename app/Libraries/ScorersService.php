<?php

namespace App\Libraries;

use App\Models\GoalModel;
use App\Models\PlayerModel;
use App\Models\MatchModel;
use App\Models\TeamModel;

class ScorersService
{
    /**
     * Top scorers cho 1 giải (league).
     */
    public function getTopScorers(int $leagueId, int $limit = 20): array
    {
        $goalM   = new GoalModel();
        $matchM  = new MatchModel();
        $playerM = new PlayerModel();
        $teamM   = new TeamModel();

        // Lấy tất cả goals thuộc các trận của league
        $builder = $goalM->select('goals.*, matches.league_id, matches.kickoff')
            ->join('matches', 'matches.id = goals.match_id', 'left')
            ->where('matches.league_id', $leagueId)
            ->where('goals.is_own_goal', 0);

        $rows = $builder->findAll();

        if (! $rows) {
            return [];
        }

        $agg = [];
        foreach ($rows as $g) {
            $pid = $g['player_id'];
            if (!isset($agg[$pid])) {
                $agg[$pid] = [
                    'player_id' => $pid,
                    'goals'     => 0,
                    'last_kickoff' => $g['kickoff'],
                ];
            }
            $agg[$pid]['goals']++;
            if ($g['kickoff'] > $agg[$pid]['last_koff'] ?? '') {
                $agg[$pid]['last_kickoff'] = $g['kickoff'];
            }
        }

        // Lấy info player + team
        foreach ($agg as $pid => &$row) {
            $player      = $playerM->find($pid);
            $team        = $player ? $teamM->find($player['team_id']) : null;
            $row['name'] = $player['name'] ?? ('Cầu thủ '.$pid);
            $row['team'] = $team['name'] ?? null;
            $row['logo'] = $team['logo'] ?? null;
        }
        unset($row);

        usort($agg, function($a,$b){
            if ($a['goals'] == $b['goals']) {
                return strcmp($b['last_kickoff'], $a['last_kickoff']);
            }
            return $b['goals'] <=> $a['goals'];
        });

        return array_slice(array_values($agg), 0, $limit);
    }
}
