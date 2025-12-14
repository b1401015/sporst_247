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

        // Pagination (dùng paginate() để có $pager)
        $limit = 10;

        /**
         * Nếu DB của bạn không dùng cột posts.category_id
         * (vd: dùng category_slug, hoặc bảng pivot), hãy chỉnh lại phần where/join cho đúng.
         */
       // print_r($category);die;
        $posts = $postModel
            ->select('posts.*')
            ->where('posts.category_id', $category['id'])
            ->where('posts.status', 'published')
            ->orderBy('posts.created_at', 'DESC')
            ->paginate($limit, 'default');

        $pager = $postModel->pager;

        // Sidebar - giữ nguyên các block (Popular News, Trending News, Popular tags, Our Newsletter)
        // NOTE: Nếu bạn không có các cột views/comment_count, hãy đổi orderBy sang created_at hoặc id.
        $popularNews = $postModel
            ->select('posts.*')
            ->where('posts.status', 'published')
            ->orderBy('posts.view_count', 'DESC')
            ->limit(4)
            ->find();

        $trendingNewest = $postModel
            ->select('posts.*')
            ->where('posts.status', 'published')
            ->orderBy('posts.created_at', 'DESC')
            ->limit(3)
            ->find();

        $trendingCommented = $postModel
            ->select('posts.*')
            ->where('posts.status', 'published')
           // ->orderBy('posts.comment_count', 'DESC')
            ->limit(3)
            ->find();

        $trendingPopular = $postModel
            ->select('posts.*')
            ->where('posts.status', 'published')
            ->orderBy('posts.view_count', 'DESC')
            ->limit(3)
            ->find();

        $data = [
            'title'             => $category['name'],
            'category'          => $category,
            'posts'             => $posts,
            'pager'             => $pager,
            'limit'             => $limit,
            'categories'        => $catModel->getActive(),

            // Sidebar
            'popularNews'       => $popularNews ?? [],
            'trendingNewest'    => $trendingNewest ?? [],
            'trendingCommented' => $trendingCommented ?? [],
            'trendingPopular'   => $trendingPopular ?? [],
        ];

        return view('frontend/category', $data);
    }
}
