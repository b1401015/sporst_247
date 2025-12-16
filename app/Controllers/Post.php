<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\CommentModel;

class Post extends BaseController
{
    public function detail($slug)
    {
        $postModel    = new PostModel();
        $catModel     = new CategoryModel();
        $commentModel = new CommentModel();

        $post = $postModel->getBySlug($slug);
        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // tăng view
        $postModel->update($post['id'], ['view_count' => ((int) ($post['view_count'] ?? 0)) + 1]);
        $post['view_count'] = ((int) ($post['view_count'] ?? 0)) + 1;

        // bài liên quan
        $related = method_exists($postModel, 'getRelated')
            ? $postModel->getRelated($post['id'], $post['category_id'] ?? null, 6)
            : [];

        // comments đã duyệt của bài
        $comments = method_exists($commentModel, 'getApprovedByPost')
            ? $commentModel->getApprovedByPost($post['id'])
            : [];

        // Sidebar data (nếu model có method thì dùng, không thì để rỗng)
        $popularPosts = method_exists($postModel, 'getPopular') ? $postModel->getPopular(4) : [];
        $trendingNewest = method_exists($postModel, 'getNewest') ? $postModel->getNewest(3) : [];
        $trendingCommented = method_exists($postModel, 'getMostCommented') ? $postModel->getMostCommented(3) : [];
        $trendingPopular = method_exists($postModel, 'getPopular') ? $postModel->getPopular(3) : [];

        $latestComments = method_exists($commentModel, 'getLatestApproved')
            ? $commentModel->getLatestApproved(3)
            : [];

        // tags: ưu tiên lấy từ post['tags'] (chuỗi "a,b,c") nếu có
        $popularTags = [];
        if (! empty($post['tags'])) {
            $popularTags = array_values(array_filter(array_map('trim', preg_split('/[,;]+/', (string) $post['tags']))));
        }

        $data = [
            'title'            => $post['title'] ?? 'News Detail',
            'meta_title'       => $post['title'] ?? 'News Detail',
            'meta_description' => $post['summary'] ?? '',
            'meta_image'       => $post['thumbnail'] ?? null,

            'post'             => $post,
            'categories'       => $catModel->getActive(),

            'related'          => $related,
            'comments'         => $comments,

            // sidebar
            'popularPosts'     => $popularPosts,
            'trendingNewest'   => $trendingNewest,
            'trendingCommented'=> $trendingCommented,
            'trendingPopular'  => $trendingPopular,
            'latestComments'   => $latestComments,
            'popularTags'      => $popularTags,
        ];

        return view('frontend/post_detail', $data);
    }

    public function comment($slug)
    {
        $postModel    = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getBySlug($slug);
        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->request->getPost();
        if (! trim($data['content'] ?? '')) {
            return redirect()->back();
        }

        $commentModel->insert([
            'post_id'    => $post['id'],
            'user_name'  => $data['user_name'] ?? ($data['name'] ?? 'Khách'),
            'user_email' => $data['user_email'] ?? ($data['email'] ?? null),
            'content'    => $data['content'],
            'status'     => 'pending',
        ]);

        return redirect()->back()->with('message', 'Bình luận đã gửi, vui lòng chờ duyệt.');
    }
}
