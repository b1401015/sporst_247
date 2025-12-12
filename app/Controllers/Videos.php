<?php

namespace App\Controllers;

use App\Models\VideoModel;
use App\Models\CategoryModel;

class Videos extends BaseController
{
    public function index()
    {
        $videoM = new VideoModel();
        $catM   = new CategoryModel();

        $videos = $videoM->where('status','published')
            ->orderBy('created_at','DESC')
            ->findAll(50);

        $data = [
            'title'           => 'Video',
            'meta_title'      => 'Video thể thao',
            'meta_description'=> 'Tổng hợp video thể thao nổi bật.',
            'videos'          => $videos,
            'categories'      => $catM->getActive(),
        ];

        return view('frontend/videos', $data);
    }

    public function detail($slug)
    {
        $videoM = new VideoModel();
        $catM   = new CategoryModel();

        $video = $videoM->where('slug',$slug)->where('status','published')->first();
        if (! $video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'           => $video['title'],
            'meta_title'      => $video['title'],
            'meta_description'=> $video['summary'] ?? '',
            'meta_image'      => $video['thumbnail'] ?? null,
            'video'           => $video,
            'categories'      => $catM->getActive(),
        ];

        return view('frontend/video_detail', $data);
    }
}
