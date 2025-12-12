<?php

namespace App\Controllers;

use App\Models\PostModel;

class Rss extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();
        $posts     = $postModel->getLatest(30);

        $response = service('response');
        $response->setHeader('Content-Type', 'application/rss+xml; charset=utf-8');

        $siteUrl  = base_url();
        $siteName = 'SportNews CI4';

        $xml = view('rss', compact('posts','siteUrl','siteName'));
        return $response->setBody($xml);
    }
}
