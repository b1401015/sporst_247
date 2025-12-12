<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $model;
    public $slug = 'categories';

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index()
    {
        $data['title'] = 'Danh mục';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = $this->slug; 
        return view('admin/categories/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Thêm danh mục';
        $data['item']  = null;
        $data['slug']  = $this->slug; 
        return view('admin/categories/form', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);
        return redirect()->to('/admin/categories')->with('message','Đã tạo danh mục');
    }

    public function edit($id)
    {
        $data['title'] = 'Sửa danh mục';
        $data['item']  = $this->model->find($id);
        $data['slug']  = $this->slug; 
        return view('admin/categories/form', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->model->update($id, $data);
        return redirect()->to('/admin/categories')->with('message','Đã cập nhật danh mục');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/categories')->with('message','Đã xoá danh mục');
    }
}
