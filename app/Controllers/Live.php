<?php

namespace App\Controllers;

use App\Models\MatchModel;
use App\Models\CategoryModel;

class Live extends BaseController
{
    public function index()
    {
        $matchModel = new MatchModel();
        $categoryM  = new CategoryModel();

        $matches = $matchModel->where('status','live')->findAll(50);

        $data = [
            'title'      => 'Trực tiếp',
            'matches'    => $matches,
            'categories' => $categoryM->getActive(),
        ];

        return view('frontend/live', $data);
    }

    public function matches()
    {
        $matchModel = new MatchModel();
        $matches = $matchModel->where('status','live')->findAll(50);

        return $this->response->setJSON($matches);
    }
}
