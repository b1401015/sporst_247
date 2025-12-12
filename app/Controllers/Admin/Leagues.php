<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LeagueModel;

class Leagues extends BaseController
{
    protected $model;

     public $slug = 'leagues';

    public function __construct()
    {
        $this->model = new LeagueModel();
    }

    public function index()
    {
        $data['title'] = 'Giải đấu';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(20);
        $data['pager'] = $this->model->pager;
        $data['slug']  = $this->slug; 
        return view('admin/leagues/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Thêm giải đấu';
        $data['item']  = null;
        $data['slug']  = $this->slug; 
        return view('admin/leagues/form', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);
        return redirect()->to('/admin/leagues')->with('message','Đã tạo giải đấu');
    }

    public function edit($id)
    {
        $data['title'] = 'Sửa giải đấu';
        $data['item']  = $this->model->find($id);
        $data['slug']  = $this->slug; 
        return view('admin/leagues/form', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->model->update($id, $data);
        return redirect()->to('/admin/leagues')->with('message','Đã cập nhật giải đấu');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/leagues')->with('message','Đã xoá giải đấu');
    }
}
