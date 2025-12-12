<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\LeagueModel;
use App\Models\VideoModel;

class Sitemap extends BaseController
{
    public function index()
    {
        $postM = new PostModel();
        $catM  = new CategoryModel();
        $lgM   = new LeagueModel();
        $vdM   = new VideoModel();

        $data = [
            'posts'      => $postM->getLatest(1000),
            'categories' => $catM->findAll(),
            'leagues'    => $lgM->findAll(),
            'videos'     => $vdM->where('status','published')->findAll(),
            'baseUrl'    => base_url(),
        ];

        $response = service('response');
        $response->setHeader('Content-Type', 'application/xml; charset=utf-8');
        return $response->setBody(view('sitemap', $data));
    }
}
