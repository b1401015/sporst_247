<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VideoModel;

class Videos extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new VideoModel();
    }

    public function index()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Video';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = 'videos';
        return view('admin/videos/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Thêm video';
        $data['item']  = null;
        $data['slug']  = 'videos';
        return view('admin/videos/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->insert($data);
        admin_log('videos', 'create', $data);
        return redirect()->to('/admin/videos')->with('message','Đã tạo video');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Sửa video';
        $data['item']  = $this->model->find($id);
        $data['slug']  = 'videos';
        return view('admin/videos/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->update($id, $data);
        admin_log('videos', 'update', ['id'=>$id] + $data);
        return redirect()->to('/admin/videos')->with('message','Đã cập nhật video');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $this->model->delete($id);
        admin_log('videos', 'delete', ['id'=>$id]);
        return redirect()->to('/admin/videos')->with('message','Đã xoá video');
    }
}
