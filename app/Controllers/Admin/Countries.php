<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CountryModel;

class Countries extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CountryModel();
    }

    public function index()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Quốc gia';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = 'countries';
        return view('admin/countries/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Thêm quốc gia';
        $data['item']  = null;
        $data['slug']  = 'countries';
        return view('admin/countries/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->insert($data);
        admin_log('countries', 'create', $data);
        return redirect()->to('/admin/countries')->with('message','Đã tạo quốc gia');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data['title'] = 'Sửa quốc gia';
        $data['item']  = $this->model->find($id);
        $data['slug']  = 'countries';
        return view('admin/countries/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $data = $this->request->getPost();
        $this->model->update($id, $data);
        admin_log('countries', 'update', ['id'=>$id] + $data);
        return redirect()->to('/admin/countries')->with('message','Đã cập nhật quốc gia');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $this->model->delete($id);
        admin_log('countries', 'delete', ['id'=>$id]);
        return redirect()->to('/admin/countries')->with('message','Đã xoá quốc gia');
    }
}
