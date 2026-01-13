<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LayoutPageModel;
use App\Models\CategoryModel;

class LayoutPages extends BaseController
{
    public function index()
    {
        $pageModel = new LayoutPageModel();
        $pages = $pageModel->orderBy('page_type')->orderBy('ref_id')->findAll();

        // list categories để tạo override nhanh
        $categories = (new CategoryModel())->orderBy('name')->findAll();

        return view('admin/layout_pages/index', compact('pages','categories'));
    }

    // create() theo presenter: POST /admin/layout-pages
    public function create()
    {
        $pageType = $this->request->getPost('page_type');
        $refId    = $this->request->getPost('ref_id') !== '' ? (int)$this->request->getPost('ref_id') : null;
        $title    = $this->request->getPost('title');
        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        $pageModel = new LayoutPageModel();

        // upsert thủ công: nếu đã có thì update, chưa có thì insert
        $existing = $pageModel->where('page_type',$pageType)->where('ref_id',$refId)->first();

        if ($existing) {
            $pageModel->update($existing['id'], ['title'=>$title, 'is_active'=>$isActive]);
            $id = $existing['id'];
        } else {
            $id = $pageModel->insert(['page_type'=>$pageType, 'ref_id'=>$refId, 'title'=>$title, 'is_active'=>$isActive], true);
        }

        return redirect()->to('/admin/layout-blocks?page_id='.$id);
    }
}
