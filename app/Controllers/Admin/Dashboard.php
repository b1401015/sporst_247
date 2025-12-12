<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\MatchModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $postM   = new PostModel();
        $matchM  = new MatchModel();

        $data = [
            'title'           => 'Dashboard',
            'postCount'       => $postM->countAllResults(),
            'todayMatchCount' => $matchM->where('DATE(kickoff)', date('Y-m-d'))->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}
