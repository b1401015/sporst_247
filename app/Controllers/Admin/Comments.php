<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommentModel;

class Comments extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CommentModel();
    }

    public function index()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Bình luận';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = 'comments';
        return view('admin/comments/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Thêm bình luận';
        $data['item']  = null;
        $data['slug']  = 'comments';
        return view('admin/comments/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->insert($data);
        admin_log('comments', 'create', $data);
        return redirect()->to('/admin/comments')->with('message','Đã tạo bình luận');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Sửa bình luận';
        $data['item']  = $this->model->find($id);
        $data['slug']  = 'comments';
        return view('admin/comments/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->update($id, $data);
        admin_log('comments', 'update', ['id'=>$id] + $data);
        return redirect()->to('/admin/comments')->with('message','Đã cập nhật bình luận');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $this->model->delete($id);
        admin_log('comments', 'delete', ['id'=>$id]);
        return redirect()->to('/admin/comments')->with('message','Đã xoá bình luận');
    }
}
