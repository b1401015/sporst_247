<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    public function index()
    {
        $model = new SettingModel();
        $data['title'] = 'Cấu hình site';
        $data['settings'] = $model->findAll();
        return view('admin/settings/index', $data);
    }

    public function save()
    {
        $model = new SettingModel();
        $post = $this->request->getPost();

        foreach ($post as $key => $value) {
            if ($key === 'csrf_test_name') continue;
            $existing = $model->where('key', $key)->first();
            if ($existing) {
                $model->update($existing['id'], ['value' => $value]);
            } else {
                $model->insert(['key' => $key, 'value' => $value]);
            }
        }

        return redirect()->to('/admin/settings')->with('message','Đã lưu cấu hình');
    }
}
