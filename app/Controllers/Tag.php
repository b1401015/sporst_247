<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\PostModel;
use App\Models\CategoryModel;

class Tag extends BaseController
{
    public function index($slug)
    {
        $tagModel   = new TagModel();
        $postModel  = new PostModel();
        $categoryM  = new CategoryModel();

        $tag = $tagModel->where('slug', $slug)->first();
        if (! $tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $page   = (int) ($this->request->getGet('page') ?? 1);
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $posts = $postModel->select('posts.*')
            ->join('post_tags','post_tags.post_id = posts.id')
            ->where('post_tags.tag_id', $tag['id'])
            ->where('posts.status','published')
            ->orderBy('posts.published_at','DESC')
            ->findAll($limit, $offset);

        $data = [
            'title'      => 'Tag: '.$tag['name'],
            'tag'        => $tag,
            'posts'      => $posts,
            'page'       => $page,
            'limit'      => $limit,
            'categories' => $categoryM->getActive(),
        ];

        return view('frontend/tag', $data);
    }
}
