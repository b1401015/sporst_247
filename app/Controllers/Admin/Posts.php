<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;

class Posts extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel     = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if ($r = require_role(['admin','editor','writer'])) return $r;

        $data['title'] = 'Quản lý bài viết';
        $data['posts'] = $this->postModel->orderBy('created_at','DESC')->paginate(20);
        $data['pager'] = $this->postModel->pager;

        return view('admin/posts/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin','editor','writer'])) return $r;

        $data['title']      = 'Thêm bài viết';
        $data['categories'] = $this->categoryModel->getActive();
        $data['post']       = null;

        return view('admin/posts/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin','editor','writer'])) return $r;

        $validation =  service('validation');
        $validation->setRules([
            'title'       => 'required|min_length[5]',
            'category_id' => 'required|integer',
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = $this->request->getPost();
        $data['slug']       = url_title($data['title'], '-', true);
        $data['created_by'] = session('user_id');
        if (($data['status'] ?? '') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        $file = $this->request->getFile('thumbnail_file');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH.'uploads/thumbnails', $newName);
            $data['thumbnail'] = '/uploads/thumbnails/'.$newName;
        }

        $this->postModel->insert($data);
        admin_log('posts','create',$data);

        return redirect()->to('/admin/posts')->with('message','Thêm bài viết thành công');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin','editor','writer'])) return $r;

        $data['title']      = 'Sửa bài viết';
        $data['categories'] = $this->categoryModel->getActive();
        $data['post']       = $this->postModel->find($id);

        return view('admin/posts/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin','editor','writer'])) return $r;

        $data = $this->request->getPost();
        $data['slug'] = url_title($data['title'], '-', true);
        if (($data['status'] ?? '') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        $file = $this->request->getFile('thumbnail_file');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH.'uploads/thumbnails', $newName);
            $data['thumbnail'] = '/uploads/thumbnails/'.$newName;
        }

        $this->postModel->update($id, $data);
        admin_log('posts','update',['id'=>$id] + $data);

        return redirect()->to('/admin/posts')->with('message','Cập nhật thành công');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $this->postModel->delete($id);
        admin_log('posts','delete',['id'=>$id]);
        return redirect()->to('/admin/posts')->with('message','Đã xoá bài viết');
    }
}
