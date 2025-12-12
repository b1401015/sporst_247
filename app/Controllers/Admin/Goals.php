<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GoalModel;
use App\Models\MatchModel; use App\Models\PlayerModel;

class Goals extends BaseController
{
    protected $model;
    protected $matchModel; protected $playerModel;

    public function __construct()
    {
        $this->model = new GoalModel();
        $this->matchModel = new MatchModel(); $this->playerModel = new PlayerModel();
    }

    public function index()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title'] = 'Bàn thắng';
        $data['items'] = $this->model->orderBy('id','DESC')->paginate(50);
        $data['pager'] = $this->model->pager;
        $data['slug']  = 'goals';
        return view('admin/goals/index', $data);
    }

    public function new()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title'] = 'Thêm bàn thắng';
        $data['item']  = null;
        $data['slug']  = 'goals';
        $data['matches'] = $this->matchModel->findAll(); $data['players'] = $this->playerModel->findAll();
        return view('admin/goals/form', $data);
    }

    public function create()
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data = $this->request->getPost();
        $this->model->insert($data);
        admin_log('goals', 'create', $data);
        return redirect()->to('/admin/goals')->with('message','Đã tạo bàn thắng');
    }

    public function edit($id)
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data['title'] = 'Sửa bàn thắng';
        $data['item']  = $this->model->find($id);
        $data['slug']  = 'goals';
        $data['matches'] = $this->matchModel->findAll(); $data['players'] = $this->playerModel->findAll();
        return view('admin/goals/form', $data);
    }

    public function update($id)
    {
        if ($r = require_role(['admin','editor'])) return $r;

        $data = $this->request->getPost();
        $this->model->update($id, $data);
        admin_log('goals', 'update', ['id'=>$id] + $data);
        return redirect()->to('/admin/goals')->with('message','Đã cập nhật bàn thắng');
    }

    public function delete($id)
    {
        if ($r = require_role(['admin'])) return $r;

        $this->model->delete($id);
        admin_log('goals', 'delete', ['id'=>$id]);
        return redirect()->to('/admin/goals')->with('message','Đã xoá bàn thắng');
    }
}
