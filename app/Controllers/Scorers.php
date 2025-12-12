<?php

namespace App\Controllers;

use App\Models\LeagueModel;
use App\Models\CategoryModel;
use App\Libraries\ScorersService;

class Scorers extends BaseController
{
    public function league($slug)
    {
        $leagueM = new LeagueModel();
        $catM    = new CategoryModel();
        $service = new ScorersService();

        $league = $leagueM->where('slug',$slug)->first();
        if (! $league) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $scorers = $service->getTopScorers((int)$league['id'], 50);

        $data = [
            'title'           => 'Vua phá lưới - '.$league['name'],
            'meta_title'      => 'Vua phá lưới '.$league['name'],
            'meta_description'=> 'Danh sách cầu thủ ghi bàn nhiều nhất '.$league['name'],
            'categories'      => $catM->getActive(),
            'league'          => $league,
            'scorers'         => $scorers,
        ];

        return view('frontend/scorers_league', $data);
    }
}
