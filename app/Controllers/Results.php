<?php

namespace App\Controllers;

use App\Models\MatchModel;
use App\Models\LeagueModel;
use App\Models\CategoryModel;
use App\Libraries\LeagueTableService;

class Results extends BaseController
{
    public function index()
    {
        $matchM = new MatchModel();
        $leagueM = new LeagueModel();
        $catM   = new CategoryModel();

        $today = date('Y-m-d');

        $matches = $matchM->select('matches.*, l.name as league_name, h.name as home_name, a.name as away_name')
            ->join('leagues l','l.id = matches.league_id')
            ->join('teams h','h.id = matches.home_team_id')
            ->join('teams a','a.id = matches.away_team_id')
            ->where('DATE(kickoff) >=', $today)
            ->orderBy('kickoff','ASC')
            ->findAll(100);

        $data = [
            'title'      => 'Kết quả & lịch thi đấu',
            'categories' => $catM->getActive(),
            'matches'    => $matches,
            'leagues'    => $leagueM->findAll(),
        ];

        return view('frontend/results', $data);
    }

    public function league($slug)
{
    $leagueM = new LeagueModel();
    $matchM  = new MatchModel();
    $catM    = new CategoryModel();

    $league = $leagueM->where('slug', $slug)->first();
    if (! $league) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Lấy status từ query string (?status=live ...)
    $status = $this->request->getGet('status') ?? '';

    // Chỉ chấp nhận 3 giá trị, còn lại thì cho về rỗng
    if (! in_array($status, ['scheduled', 'live', 'finished'])) {
        $status = '';
    }

    $builder = $matchM->select('matches.*, h.name as home_name, a.name as away_name')
        ->join('teams h','h.id = matches.home_team_id')
        ->join('teams a','a.id = matches.away_team_id')
        ->where('matches.league_id', $league['id']);

    if ($status !== '') {
        $builder->where('matches.status', $status);
    }

    $matches = $builder->orderBy('kickoff','ASC')->findAll();

    $data = [
        'title'      => 'Lịch / kết quả - '.$league['name'],
        'categories' => $catM->getActive(),
        'league'     => $league,
        'matches'    => $matches,
        'status'     => $status,   // *** TRUYỀN XUỐNG VIEW ***
    ];

    return view('frontend/league_matches', $data);
}


    public function table($slug)
    {
        $leagueM = new LeagueModel();
        $catM    = new CategoryModel();
        $service = new LeagueTableService();

        $league = $leagueM->where('slug',$slug)->first();
        if (! $league) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rows = $service->getFullTable((int)$league['id']);

        $data = [
            'title'      => 'BXH '.$league['name'],
            'categories' => $catM->getActive(),
            'league'     => $league,
            'rows'       => $rows,
        ];

        return view('frontend/league_table', $data);
    }

    public function weekTable($slug, $week)
    {
        $leagueM = new LeagueModel();
        $catM    = new CategoryModel();
        $service = new LeagueTableService();

        $league = $leagueM->where('slug',$slug)->first();
        if (! $league) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $week  = (int)$week;
        if ($week < 1) $week = 1;

        $rows = $service->getTableForWeek((int)$league['id'], $week);

        $data = [
            'title'      => 'BXH vòng '.$week.' - '.$league['name'],
            'categories' => $catM->getActive(),
            'league'     => $league,
            'rows'       => $rows,
            'week'       => $week,
        ];

        return view('frontend/league_table_week', $data);
    }
}
