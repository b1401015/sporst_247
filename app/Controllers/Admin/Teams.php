<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TeamModel;

class Teams extends BaseController
{
    protected $model;

    public $slug = 'teams';

    public function __construct()
    {
        $this->model = new TeamModel();
    }

    public function index()
    {
        $data['title'] = 'Đội bóng';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = $this->slug; 
        return view('admin/teams/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Thêm đội bóng';
        $data['item']  = null;
        $data['slug']  = $this->slug; 
        return view('admin/teams/form', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);
        return redirect()->to('/admin/teams')->with('message','Đã tạo đội bóng');
    }

    public function edit($id)
    {
        $data['title'] = 'Sửa đội bóng';
        $data['item']  = $this->model->find($id);
        $data['slug']  = $this->slug; 
        return view('admin/teams/form', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->model->update($id, $data);
        return redirect()->to('/admin/teams')->with('message','Đã cập nhật đội bóng');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/teams')->with('message','Đã xoá đội bóng');
    }
}
