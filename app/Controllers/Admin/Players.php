<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlayerModel;
use App\Models\TeamModel;

class Players extends BaseController
{
    protected $model;
    protected $teamModel;

    public function __construct()
    {
        $this->model = new PlayerModel();
        $this->teamModel = new TeamModel();
    }

    public function index()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title'] = 'Cầu thủ';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(50);
        $data['pager'] = $this->model->pager;
        $data['slug']  = 'players';
        return view('admin/players/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title'] = 'Thêm cầu thủ';
        $data['item']  = null;
        $data['slug']  = 'players';
        $data['teams'] = $this->teamModel->findAll();
        return view('admin/players/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data = $this->request->getPost();
        $this->model->insert($data);
        admin_log('players', 'create', $data);
        return redirect()->to('/admin/players')->with('message','Đã tạo cầu thủ');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title'] = 'Sửa cầu thủ';
        $data['item']  = $this->model->find($id);
        $data['slug']  = 'players';
        $data['teams'] = $this->teamModel->findAll();
        return view('admin/players/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data = $this->request->getPost();
        $this->model->update($id, $data);
        admin_log('players', 'update', ['id'=>$id] + $data);
        return redirect()->to('/admin/players')->with('message','Đã cập nhật cầu thủ');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $this->model->delete($id);
        admin_log('players', 'delete', ['id'=>$id]);
        return redirect()->to('/admin/players')->with('message','Đã xoá cầu thủ');
    }
}
