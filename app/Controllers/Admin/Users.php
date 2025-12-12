<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $model;
    public $slug = 'users';
    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $data['title'] = 'Người dùng';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = $this->slug; 
        return view('admin/users/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Thêm người dùng';
        $data['item']  = null;
        $data['slug']  = $this->slug; 
        return view('admin/users/form', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);
        return redirect()->to('/admin/users')->with('message','Đã tạo người dùng');
    }

    public function edit($id)
    {
        $data['title'] = 'Sửa người dùng';
        $data['item']  = $this->model->find($id);
        $data['slug']  = $this->slug; 
        return view('admin/users/form', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->model->update($id, $data);
        return redirect()->to('/admin/users')->with('message','Đã cập nhật người dùng');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/users')->with('message','Đã xoá người dùng');
    }
}
