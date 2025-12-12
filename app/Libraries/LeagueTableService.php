<?php

namespace App\Libraries;

use App\Models\StandingsModel;
use App\Models\MatchModel;
use App\Models\TeamModel;

class LeagueTableService
{
    /**
     * Full bảng xếp hạng 1 giải, kèm logo, form 5 trận gần nhất, home/away.
     */
    public function getFullTable(int $leagueId): array
    {
        $standingsM = new StandingsModel();
        $teamM      = new TeamModel();
        $matchM     = new MatchModel();

        // Lấy standings hiện tại + tên đội + logo
        $rows = $standingsM->select('standings.*, teams.name, teams.logo')
            ->join('teams','teams.id = standings.team_id')
            ->where('standings.league_id', $leagueId)
            ->orderBy('points', 'DESC')
            ->orderBy('goals_for', 'DESC')
            ->orderBy('goals_against', 'ASC')
            ->get()->getResultArray();

        $table = [];
        foreach ($rows as $r) {
            $r['home_played'] = 0;
            $r['home_win']    = 0;
            $r['home_draw']   = 0;
            $r['home_lose']   = 0;
            $r['away_played'] = 0;
            $r['away_win']    = 0;
            $r['away_draw']   = 0;
            $r['away_lose']   = 0;
            $r['form']        = [];
            $table[$r['team_id']] = $r;
        }

        if (! $table) {
            return [];
        }

        // Lấy tất cả trận đã kết thúc
        $matches = $matchM->where('league_id', $leagueId)
            ->where('status', 'finished')
            ->orderBy('kickoff','DESC')
            ->findAll();

        $resultsByTeam = [];

        foreach ($matches as $m) {
            $home = $m['home_team_id'];
            $away = $m['away_team_id'];
            $hs   = (int)$m['home_score'];
            $as   = (int)$m['away_score'];

            foreach ([$home, $away] as $tid) {
                if (!isset($resultsByTeam[$tid])) {
                    $resultsByTeam[$tid] = [];
                }
            }

            // home stats
            if (isset($table[$home])) {
                $table[$home]['home_played']++;
                if ($hs > $as) {
                    $table[$home]['home_win']++;
                    $resultsByTeam[$home][] = ['kickoff'=>$m['kickoff'], 'res'=>'W'];
                } elseif ($hs == $as) {
                    $table[$home]['home_draw']++;
                    $resultsByTeam[$home][] = ['kickoff'=>$m['kickoff'], 'res'=>'D'];
                } else {
                    $table[$home]['home_lose']++;
                    $resultsByTeam[$home][] = ['kickoff'=>$m['kickoff'], 'res'=>'L'];
                }
            }

            // away stats
            if (isset($table[$away])) {
                $table[$away]['away_played']++;
                if ($as > $hs) {
                    $table[$away]['away_win']++;
                    $resultsByTeam[$away][] = ['kickoff'=>$m['kickoff'], 'res'=>'W'];
                } elseif ($as == $hs) {
                    $table[$away]['away_draw']++;
                    $resultsByTeam[$away][] = ['kickoff'=>$m['kickoff'], 'res'=>'D'];
                } else {
                    $table[$away]['away_lose']++;
                    $resultsByTeam[$away][] = ['kickoff'=>$m['kickoff'], 'res'=>'L'];
                }
            }
        }

        // Tính form 5 trận gần nhất
        foreach ($table as $tid => &$r) {
            if (!isset($resultsByTeam[$tid])) {
                $r['form'] = [];
                continue;
            }
            usort($resultsByTeam[$tid], function($a,$b){
                return strcmp($b['kickoff'], $a['kickoff']);
            });
            $last5 = array_slice($resultsByTeam[$tid], 0, 5);
            $r['form'] = array_column($last5, 'res');
        }
        unset($r);

        return array_values($table);
    }

    /**
     * BXH cho 1 giải tính đến 1 vòng (matchweek).
     */
    public function getTableForWeek(int $leagueId, int $week): array
    {
        $matchM = new MatchModel();

        $matches = $matchM->where('league_id', $leagueId)
            ->where('status', 'finished')
            ->where('matchweek <=', $week)
            ->orderBy('kickoff','ASC')
            ->findAll();

        $data = [];

        foreach ($matches as $m) {
            $home = $m['home_team_id'];
            $away = $m['away_team_id'];

            foreach ([$home, $away] as $teamId) {
                if (!isset($data[$teamId])) {
                    $data[$teamId] = [
                        'team_id'       => $teamId,
                        'played'        => 0,
                        'win'           => 0,
                        'draw'          => 0,
                        'lose'          => 0,
                        'goals_for'     => 0,
                        'goals_against' => 0,
                        'points'        => 0,
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

        if (! $data) {
            return [];
        }

        $teamM = new TeamModel();
        foreach ($data as $tid => &$r) {
            $team = $teamM->find($tid);
            $r['name'] = $team['name'] ?? 'Đội '.$tid;
            $r['logo'] = $team['logo'] ?? null;
        }
        unset($r);

        usort($data, function($a,$b) {
            if ($a['points'] == $b['points']) {
                $gdA = $a['goals_for'] - $a['goals_against'];
                $gdB = $b['goals_for'] - $b['goals_against'];
                if ($gdA == $gdB) {
                    return $b['goals_for'] <=> $a['goals_for'];
                }
                return $gdB <=> $gdA;
            }
            return $b['points'] <=> $a['points'];
        });

        return array_values($data);
    }
}
