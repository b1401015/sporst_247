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
        $postModel->update($post['id'], ['view_count' => $post['view_count'] + 1]);

        // bài liên quan
        if (method_exists($postModel, 'getRelated')) {
            $related = $postModel->getRelated($post['id'], $post['category_id'], 6);
        } else {
            $related = [];
        }

        $comments = $commentModel->getApprovedByPost($post['id']);

        $data = [
            'title'           => $post['title'],
            'meta_title'      => $post['title'],
            'meta_description'=> $post['summary'] ?? '',
            'meta_image'      => $post['thumbnail'] ?? null,
            'post'            => $post,
            'categories'      => $catModel->getActive(),
            'related'         => $related,
            'comments'        => $comments,
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
            'user_name'  => $data['user_name'] ?? 'Khách',
            'user_email' => $data['user_email'] ?? null,
            'content'    => $data['content'],
            'status'     => 'pending',
        ]);

        return redirect()->back()->with('message','Bình luận đã gửi, vui lòng chờ duyệt.');
    }
}
