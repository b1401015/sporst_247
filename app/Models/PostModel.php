<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table      = 'posts';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'category_id','title','slug','summary','content',
        'thumbnail','status','is_featured','is_hot',
        'view_count','published_at','created_by','source_url','source_name'
    ];

    protected $useTimestamps = true;

    public function getHomeFeatured($limit = 5)
    {
        return $this->select('posts.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = posts.category_id')
            ->where('posts.status', 'published')
            ->where('posts.is_featured', 1)
            ->orderBy('posts.published_at', 'DESC')
            ->limit($limit)
            ->find();
    }

    public function getLatest($limit = 10, $offset = 0)
    {
        return $this->where('status','published')
            ->orderBy('published_at', 'DESC')
            ->findAll($limit, $offset);
    }

    public function getBySlug($slug)
    {
        return $this->select('posts.*, categories.name as category_name')
            ->join('categories','categories.id = posts.category_id')
            ->where('posts.slug', $slug)
            ->first();
    }

    public function getByCategorySlug($slug, $limit = 10, $offset = 0)
    {
        return $this->select('posts.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories','categories.id = posts.category_id')
            ->where('categories.slug', $slug)
            ->where('posts.status','published')
            ->orderBy('posts.published_at','DESC')
            ->findAll($limit, $offset);
    }

    public function getTrending($limit = 10)
    {
        return $this->where('status','published')
            ->orderBy('view_count','DESC')
            ->limit($limit)
            ->find();
    }

    public function searchPosts($keyword, $limit = 20, $offset = 0)
    {
        return $this->like('title', $keyword)
            ->orLike('summary', $keyword)
            ->orLike('content', $keyword)
            ->where('status','published')
            ->orderBy('published_at','DESC')
            ->findAll($limit, $offset);
    }
}
