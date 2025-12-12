<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LeagueModel;
use App\Libraries\LeagueTableService;
use App\Libraries\ScorersService;

class Standings extends BaseController
{
    protected function json($data)
    {
        return $this->response->setJSON($data);
    }

    public function all()
    {
        $leagueM = new LeagueModel();
        $service = new LeagueTableService();

        $leagues = $leagueM->findAll();
        $out = [];
        foreach ($leagues as $lg) {
            $out[$lg['slug']] = $service->getFullTable((int)$lg['id']);
        }
        return $this->json($out);
    }

    public function league($slug)
    {
        $leagueM = new LeagueModel();
        $service = new LeagueTableService();

        $league = $leagueM->where('slug',$slug)->first();
        if (! $league) {
            return $this->response->setStatusCode(404)->setJSON(['error'=>'League not found']);
        }
        $table = $service->getFullTable((int)$league['id']);
        return $this->json($table);
    }

    public function week($slug, $week)
    {
        $leagueM = new LeagueModel();
        $service = new LeagueTableService();

        $league = $leagueM->where('slug',$slug)->first();
        if (! $league) {
            return $this->response->setStatusCode(404)->setJSON(['error'=>'League not found']);
        }
        $week = (int)$week;
        if ($week < 1) $week = 1;

        $table = $service->getTableForWeek((int)$league['id'], $week);
        return $this->json($table);
    }

    public function scorers($slug)
    {
        $leagueM = new LeagueModel();
        $service = new ScorersService();

        $league = $leagueM->where('slug',$slug)->first();
        if (! $league) {
            return $this->response->setStatusCode(404)->setJSON(['error'=>'League not found']);
        }

        $scorers = $service->getTopScorers((int)$league['id'], 50);
        return $this->json($scorers);
    }
}
