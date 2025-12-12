<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Search extends BaseController
{
    public function index()
    {
        $keyword = trim($this->request->getGet('q') ?? '');
        $postModel = new PostModel();
        $catModel  = new CategoryModel();

        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $posts = [];
        if ($keyword !== '') {
            $posts = $postModel->searchPosts($keyword, $limit, $offset);
        }

        $data = [
            'title'      => 'Tìm kiếm',
            'keyword'    => $keyword,
            'posts'      => $posts,
            'page'       => $page,
            'limit'      => $limit,
            'categories' => $catModel->getActive(),
        ];

        return view('frontend/search', $data);
    }
}
