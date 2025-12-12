<?php

use App\Models\AdminLogModel;

if (! function_exists('require_role')) {
    function require_role(array $roles)
    {
        $role = session('role');
        if (! $role || ! in_array($role, $roles)) {
            return redirect()->to('/admin')->with('error', 'Không có quyền truy cập mục này');
        }
        return null;
    }
}

if (! function_exists('admin_log')) {
    function admin_log(string $module, string $action, $data = null)
    {
        try {
            $model = new AdminLogModel();
            $model->insert([
                'user_id' => session('user_id'),
                'module'  => $module,
                'action'  => $action,
                'data'    => is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : (string)$data,
            ]);
        } catch (\Throwable $e) {
            // tránh làm hỏng flow chính nếu log lỗi
        }
    }
}
