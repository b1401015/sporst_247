<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Category extends BaseController
{
    public function view($slug)
    {
        $postModel = new PostModel();
        $catModel  = new CategoryModel();

        $category = $catModel->where('slug', $slug)->first();
        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $posts = $postModel->getByCategorySlug($slug, $limit, $offset);

        $data = [
            'title'      => $category['name'],
            'category'   => $category,
            'posts'      => $posts,
            'page'       => $page,
            'limit'      => $limit,
            'categories' => $catModel->getActive(),
        ];

        return view('frontend/category', $data);
    }
}
