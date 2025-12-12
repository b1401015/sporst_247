<?php

namespace App\Libraries;

use App\Models\MatchModel;
use App\Models\StandingsModel;

class StandingsService
{
    public function recalcLeague(int $leagueId): void
    {
        $matchModel     = new MatchModel();
        $standingsModel = new StandingsModel();

        // Lấy tất cả trận đã kết thúc của giải
        $matches = $matchModel->where('league_id', $leagueId)
            ->where('status', 'finished')
            ->findAll();

        $data = [];

        foreach ($matches as $m) {
            $home = $m['home_team_id'];
            $away = $m['away_team_id'];

            foreach ([$home, $away] as $teamId) {
                if (!isset($data[$teamId])) {
                    $data[$teamId] = [
                        'league_id'      => $leagueId,
                        'team_id'        => $teamId,
                        'played'         => 0,
                        'win'            => 0,
                        'draw'           => 0,
                        'lose'           => 0,
                        'goals_for'      => 0,
                        'goals_against'  => 0,
                        'points'         => 0,
                    ];
                }
            }

            $hs = (int)$m['home_score'];
            $as = (int)$m['away_score'];

            $data[$home]['played']++;
            $data[$away]['played']++;
            $data[$home]['goals_for']     += $hs;
            $data[$home]['goals_against'] += $as;
            $data[$away]['goals_for']     += $as;
            $data[$away]['goals_against'] += $hs;

            if ($hs > $as) {
                $data[$home]['win']++;
                $data[$home]['points'] += 3;
                $data[$away]['lose']++;
            } elseif ($hs < $as) {
                $data[$away]['win']++;
                $data[$away]['points'] += 3;
                $data[$home]['lose']++;
            } else {
                $data[$home]['draw']++;
                $data[$away]['draw']++;
                $data[$home]['points'] += 1;
                $data[$away]['points'] += 1;
            }
        }

        // Xoá BXH cũ của giải
        $standingsModel->where('league_id', $leagueId)->delete();

        // Ghi lại
        if ($data) {
            $standingsModel->insertBatch(array_values($data));
        }
    }
}
