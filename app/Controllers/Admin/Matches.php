<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MatchModel;
use App\Models\LeagueModel;
use App\Models\TeamModel;
use App\Libraries\StandingsService;

class Matches extends BaseController
{
    protected $matchModel;
    protected $leagueModel;
    protected $teamModel;
    protected $standingsService;

    public function __construct()
    {
        $this->matchModel       = new MatchModel();
        $this->leagueModel      = new LeagueModel();
        $this->teamModel        = new TeamModel();
        $this->standingsService = new StandingsService();
    }

    public function index()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title'] = 'Trận đấu';
        $data['matches'] = $this->matchModel
            ->select('matches.*, l.name as league_name, h.name as home_name, a.name as away_name')
            ->join('leagues l','l.id = matches.league_id')
            ->join('teams h','h.id = matches.home_team_id')
            ->join('teams a','a.id = matches.away_team_id')
            ->orderBy('kickoff','DESC')
            ->paginate(50);
        $data['pager'] = $this->matchModel->pager;

        return view('admin/matches/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title']   = 'Thêm trận đấu';
        $data['item']    = null;
        $data['leagues'] = $this->leagueModel->findAll();
        $data['teams']   = $this->teamModel->findAll();
        return view('admin/matches/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data = $this->request->getPost();
        $this->matchModel->insert($data);
        admin_log('matches','create',$data);

        if (($data['status'] ?? '') === 'finished') {
            $this->standingsService->recalcLeague((int)$data['league_id']);
        }

        return redirect()->to('/admin/matches')->with('message','Đã tạo trận đấu');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title']   = 'Sửa trận đấu';
        $data['item']    = $this->matchModel->find($id);
        $data['leagues'] = $this->leagueModel->findAll();
        $data['teams']   = $this->teamModel->findAll();
        return view('admin/matches/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data = $this->request->getPost();
        $this->matchModel->update($id, $data);
        admin_log('matches','update',['id'=>$id] + $data);

        if (($data['status'] ?? '') === 'finished') {
            $this->standingsService->recalcLeague((int)$data['league_id']);
        }

        return redirect()->to('/admin/matches')->with('message','Đã cập nhật trận đấu');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $match = $this->matchModel->find($id);
        $this->matchModel->delete($id);
        admin_log('matches','delete',['id'=>$id]);

        if ($match) {
            $this->standingsService->recalcLeague((int)$match['league_id']);
        }

        return redirect()->to('/admin/matches')->with('message','Đã xoá trận đấu');
    }
}
