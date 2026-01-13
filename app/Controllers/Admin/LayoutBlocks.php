<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LayoutBlockModel;
use App\Models\LayoutPageModel;
use App\Models\BlockTypeModel;

class LayoutBlocks extends BaseController
{
    public function index()
    {
        $pageId = (int)($this->request->getGet('page_id') ?? 0);
        if ($pageId <= 0) return redirect()->to('/admin/layout-pages');

        $page = (new LayoutPageModel())->find($pageId);
        if (!$page) return redirect()->to('/admin/layout-pages');

        $blocks = (new LayoutBlockModel())
            ->select('layout_blocks.*, layout_block_types.name AS block_name, layout_block_types.key AS block_key')
            ->join('layout_block_types','layout_block_types.id = layout_blocks.block_type_id')
            ->where('page_id',$pageId)
            ->orderBy('region')->orderBy('sort_order')
            ->findAll();

        return view('admin/layout_blocks/index', compact('page','blocks'));
    }

    public function new()
    {
        $pageId = (int)($this->request->getGet('page_id') ?? 0);
        if ($pageId <= 0) return redirect()->to('/admin/layout-pages');

        $page  = (new LayoutPageModel())->find($pageId);
        $types = (new BlockTypeModel())->where('is_active',1)->findAll();

        return view('admin/layout_blocks/form', compact('page','types'));
    }

    public function create()
    {
        $pageId = (int)$this->request->getPost('page_id');

        (new LayoutBlockModel())->insert([
            'page_id'       => $pageId,
            'region'        => $this->request->getPost('region'),
            'block_type_id' => (int)$this->request->getPost('block_type_id'),
            'title'         => $this->request->getPost('title'),
            'config'        => $this->request->getPost('config'),
            'sort_order'    => (int)($this->request->getPost('sort_order') ?? 0),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/layout-blocks?page_id='.$pageId);
    }

    public function edit($id)
    {
        $item = (new LayoutBlockModel())->find($id);
        if (!$item) return redirect()->to('/admin/layout-pages');

        $page  = (new LayoutPageModel())->find($item['page_id']);
        $types = (new BlockTypeModel())->where('is_active',1)->findAll();

        return view('admin/layout_blocks/form', compact('page','types','item'));
    }

    public function update($id)
    {
        $model  = new LayoutBlockModel();
        $item   = $model->find($id);
        if (!$item) return redirect()->to('/admin/layout-pages');

        $pageId = (int)($this->request->getPost('page_id') ?? $item['page_id']);

        $model->update($id, [
            'region'        => $this->request->getPost('region'),
            'block_type_id' => (int)$this->request->getPost('block_type_id'),
            'title'         => $this->request->getPost('title'),
            'config'        => $this->request->getPost('config'),
            'sort_order'    => (int)($this->request->getPost('sort_order') ?? 0),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/layout-blocks?page_id='.$pageId);
    }

    public function delete($id)
    {
        $model = new LayoutBlockModel();
        $item  = $model->find($id);
        if (!$item) return redirect()->to('/admin/layout-pages');

        $pageId = (int)$item['page_id'];
        $model->delete($id);

        return redirect()->to('/admin/layout-blocks?page_id='.$pageId);
    }
}
