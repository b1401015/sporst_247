<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = db_connect();

        // Posts
        $basePostSelect = "posts.id, posts.category_id, posts.title, posts.slug, posts.summary, posts.thumbnail, posts.view_count, posts.published_at,
                           categories.name AS category_name, categories.slug AS category_slug";

        $featuredPosts = $db->table('posts')
            ->select($basePostSelect)
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.status', 'published')
            ->where('posts.is_featured', 1)
            ->orderBy('posts.published_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $trendingPosts = $db->table('posts')
            ->select($basePostSelect)
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.status', 'published')
            ->where('posts.is_hot', 1)
            ->orderBy('posts.published_at', 'DESC')
            ->limit(8)
            ->get()->getResultArray();

        $popularPosts = $db->table('posts')
            ->select($basePostSelect)
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.status', 'published')
            ->orderBy('posts.view_count', 'DESC')
            ->orderBy('posts.published_at', 'DESC')
            ->limit(8)
            ->get()->getResultArray();

        $latestPosts = $db->table('posts')
            ->select($basePostSelect)
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.status', 'published')
            ->orderBy('posts.published_at', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        // ===== Banner data cho carousel (mỗi tab 2 bài) =====
        $bannerAll      = array_slice($featuredPosts, 0, 2);   // tab #home (All)
        $bannerTrending = array_slice($trendingPosts, 0, 2);   // tab #profile1 (Trending)
        $bannerPopular  = array_slice($popularPosts, 0, 2);    // tab #profile2 (Popular)
        $bannerLatest   = array_slice($latestPosts, 0, 2);     // tab #profile3 (Latest)

        // Videos (optional section)
        $videos = [];
        if ($db->tableExists('videos')) {
            $videos = $db->table('videos')
                ->select('id, title, slug, summary, embed_url, thumbnail, updated_at')
                ->where('status', 'published')
                ->orderBy('updated_at', 'DESC')
                ->limit(4)
                ->get()->getResultArray();
        }

        // Ads (optional)
        $ads = [];
        if ($db->tableExists('ads')) {
            $ads = $db->table('ads')
                ->select('id, title, position, image, link, html, is_active, sort_order')
                ->where('is_active', 1)
                ->orderBy('position', 'ASC')
                ->orderBy('sort_order', 'ASC')
                ->get()->getResultArray();
        }

        return view('frontend/home', [
            'title'         => 'Trang chủ',
            'featuredPosts' => $featuredPosts,
            'trendingPosts' => $trendingPosts,
            'popularPosts'  => $popularPosts,
            'latestPosts'   => $latestPosts,

            // Gắn vào carousel
            'bannerAll'      => $bannerAll,
            'bannerTrending' => $bannerTrending,
            'bannerPopular'  => $bannerPopular,
            'bannerLatest'   => $bannerLatest,

            'videos'        => $videos,
            'ads'           => $ads,
        ]);
    }
}
