<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\LeagueModel;
use App\Models\StandingsModel;
use App\Models\MatchModel;

class Home extends BaseController
{
    protected $postModel;
    protected $leagueModel;
    protected $standingsModel;
    protected $matchModel;

    public function __construct()
    {
        $this->postModel      = new PostModel();
        $this->leagueModel    = new LeagueModel();
        $this->standingsModel = new StandingsModel();
        $this->matchModel     = new MatchModel();
    }

    public function index()
    {
        // Tin nổi bật dùng cho hero (1 tin to + các tin nhỏ)
        $featured = $this->postModel->getHomeFeatured(5);

        // Tin mới dưới hero – bỏ qua 5 tin nổi bật đầu
        $latest = $this->postModel->getLatest(20, 5);

        // Tin đọc nhiều (trending)
        $trending = $this->postModel->getTrending(10);

        // Lịch thi đấu hôm nay
        $todayMatches = $this->matchModel->getTodayMatches();

        // Lấy 1 giải để hiển thị BXH – ưu tiên Premier League
        $league = $this->leagueModel
            ->where('slug', 'premier-league')
            ->first();

        if (! $league) {
            $league = $this->leagueModel->first();
        }

        $standings = [];
        if ($league) {
            $standings = $this->standingsModel
                ->select('standings.*, teams.name, teams.logo')
                ->join('teams', 'teams.id = standings.team_id')
                ->where('standings.league_id', $league['id'])
                ->orderBy('points', 'DESC')
                ->orderBy('goals_for', 'DESC')
                ->orderBy('goals_against', 'ASC')
                ->findAll(10);
        }

        return view('frontend/home', [
            'featured'      => $featured,
            'latest'        => $latest,
            'trending'      => $trending,
            'todayMatches'  => $todayMatches,
            'league'        => $league,
            'standings'     => $standings,
        ]);
    }
}
