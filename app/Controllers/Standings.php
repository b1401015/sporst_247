<?php

namespace App\Controllers;

use App\Models\LeagueModel;
use App\Models\CategoryModel;
use App\Libraries\LeagueTableService;

class Standings extends BaseController
{
    public function index()
    {
        $leagueM = new LeagueModel();
        $catM    = new CategoryModel();
        $service = new LeagueTableService();

        $leagues = $leagueM->orderBy('name','ASC')->findAll();

        $tables = [];
        foreach ($leagues as $lg) {
            $tables[$lg['id']] = $service->getFullTable((int)$lg['id']);
        }

        $data = [
            'title'           => 'BXH nhiều giải',
            'meta_title'      => 'Bảng xếp hạng nhiều giải',
            'meta_description'=> 'Tổng hợp bảng xếp hạng nhiều giải đấu.',
            'categories'      => $catM->getActive(),
            'leagues'         => $leagues,
            'tables'          => $tables,
        ];

        return view('frontend/standings_multi', $data);
    }
}
