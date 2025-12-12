<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagModel;

class Tags extends BaseController
{
    protected $model;

    public $slug = 'tags';

    public function __construct()
    {
        $this->model = new TagModel();
    }

    public function index()
    {
        $data['title'] = 'Tag';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = $this->slug; 
        return view('admin/tags/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Thêm tag';
        $data['item']  = null;
        $data['slug']  = $this->slug; 
        return view('admin/tags/form', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);
        return redirect()->to('/admin/tags')->with('message','Đã tạo tag');
    }

    public function edit($id)
    {
        $data['title'] = 'Sửa tag';
        $data['item']  = $this->model->find($id);
        $data['slug']  = $this->slug; 
        return view('admin/tags/form', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->model->update($id, $data);
        return redirect()->to('/admin/tags')->with('message','Đã cập nhật tag');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/tags')->with('message','Đã xoá tag');
    }
}
