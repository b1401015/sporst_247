<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MedalModel;

class Medals extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MedalModel();
    }

    public function index()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Huy chương';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = 'medals';
        return view('admin/medals/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Thêm bản ghi huy chương';
        $data['item']  = null;
        $data['slug']  = 'medals';
        return view('admin/medals/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->insert($data);
        admin_log('medals', 'create', $data);
        return redirect()->to('/admin/medals')->with('message','Đã tạo bản ghi huy chương');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Sửa bản ghi huy chương';
        $data['item']  = $this->model->find($id);
        $data['slug']  = 'medals';
        return view('admin/medals/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->update($id, $data);
        admin_log('medals', 'update', ['id'=>$id] + $data);
        return redirect()->to('/admin/medals')->with('message','Đã cập nhật bản ghi huy chương');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $this->model->delete($id);
        admin_log('medals', 'delete', ['id'=>$id]);
        return redirect()->to('/admin/medals')->with('message','Đã xoá bản ghi huy chương');
    }
}
