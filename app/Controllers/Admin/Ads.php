<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Ads extends BaseController
{
    protected $adModel;

    protected $slug = 'ads';

    public function __construct()
    {
        $this->adModel = new AdModel();
    }

    public function index()
    {
        if ($r = require_role(['admin', 'editor'])) return $r;

        $ads = $this->adModel
            ->orderBy('position', 'ASC')
            ->orderBy('sort_order', 'ASC')
            ->paginate(20);

        return view('admin/ads/index', [
            'title' => 'Quản lý quảng cáo',
            'ads'   => $ads,
            'pager' => $this->adModel->pager,
            'slug'  => $this->slug,
        ]);
    }

    public function new()
    {
        if ($r = require_role(['admin', 'editor'])) return $r;

        return view('admin/ads/form', [
            'title' => 'Thêm quảng cáo',
            'ad'    => null,
            'slug'  => $this->slug,
        ]);
    }

    /**
     * Upload file ảnh, trả về path lưu trong DB
     */
    protected function handleUpload(?array $old = null): ?string
    {
        $file = $this->request->getFile('image');

        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return $old['image'] ?? null;
        }

        if (! $file->isValid()) {
            return $old['image'] ?? null;
        }

        $uploadPath = FCPATH . 'uploads/ads';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        // xóa ảnh cũ nếu có
        if ($old && ! empty($old['image']) && is_file(FCPATH . $old['image'])) {
            @unlink(FCPATH . $old['image']);
        }

        return 'uploads/ads/' . $newName;
    }

    public function create()
    {
        if ($r = require_role(['admin', 'editor'])) return $r;

        $post = $this->request->getPost();

        $data = [
            'title'      => trim($post['title'] ?? ''),
            'position'   => $post['position'] ?? 'top_banner',
            'link'       => trim($post['link'] ?? ''),
            'html'       => $post['html'] ?? null,
            'is_active'  => isset($post['is_active']) ? 1 : 0,
            'sort_order' => (int)($post['sort_order'] ?? 0),
            'started_at' => !empty($post['started_at'])
                ? date('Y-m-d H:i:s', strtotime($post['started_at']))
                : null,
            'ended_at'   => !empty($post['ended_at'])
                ? date('Y-m-d H:i:s', strtotime($post['ended_at']))
                : null,
        ];

        $data['image'] = $this->handleUpload();

        $id = $this->adModel->insert($data, true);

        admin_log('ads', 'create', ['id' => $id] + $data);

        return redirect()->to('/admin/ads')->with('message', 'Đã thêm quảng cáo');
    }

    public function edit($id = null)
    {
        if ($r = require_role(['admin', 'editor'])) return $r;

        $ad = $this->adModel->find($id);
        if (! $ad) {
            throw new PageNotFoundException('Không tìm thấy quảng cáo');
        }

        return view('admin/ads/form', [
            'title' => 'Sửa quảng cáo',
            'ad'    => $ad,
            'slug'  => $this->slug,
        ]);
    }

    public function update($id = null)
    {
        if ($r = require_role(['admin', 'editor'])) return $r;

        $ad = $this->adModel->find($id);
        if (! $ad) {
            throw new PageNotFoundException('Không tìm thấy quảng cáo');
        }

        $post = $this->request->getPost();

        $data = [
            'title'      => trim($post['title'] ?? ''),
            'position'   => $post['position'] ?? 'top_banner',
            'link'       => trim($post['link'] ?? ''),
            'html'       => $post['html'] ?? null,
            'is_active'  => isset($post['is_active']) ? 1 : 0,
            'sort_order' => (int)($post['sort_order'] ?? 0),
            'started_at' => !empty($post['started_at'])
                ? date('Y-m-d H:i:s', strtotime($post['started_at']))
                : null,
            'ended_at'   => !empty($post['ended_at'])
                ? date('Y-m-d H:i:s', strtotime($post['ended_at']))
                : null,
        ];

        $data['image'] = $this->handleUpload($ad);

        $this->adModel->update($id, $data);

        admin_log('ads', 'update', ['id' => $id] + $data);

        return redirect()->to('/admin/ads')->with('message', 'Đã cập nhật quảng cáo');
    }

    public function delete($id = null)
    {
        if ($r = require_role(['admin'])) return $r;

        $ad = $this->adModel->find($id);

        if ($ad && ! empty($ad['image']) && is_file(FCPATH . $ad['image'])) {
            @unlink(FCPATH . $ad['image']);
        }

        $this->adModel->delete($id);

        admin_log('ads', 'delete', ['id' => $id]);

        return redirect()->to('/admin/ads')->with('message', 'Đã xoá quảng cáo');
    }
}
