<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
$pageTitle = $page['title'] ?? '';
$pageType  = $page['page_type'] ?? '';
$refId     = $page['ref_id'] ?? null;

$subtitle = $pageType === 'home'
    ? 'Home Layout'
    : ($refId === null ? 'Default Category Layout' : 'Category Override (category_id='.$refId.')');

$regionLabels = [
    'hero'    => 'Hero',
    'main'    => 'Main',
    'sidebar' => 'Sidebar',
    'footer'  => 'Footer',
];

$grouped = [];
foreach (($blocks ?? []) as $b) {
    $r = $b['region'] ?? 'main';
    $grouped[$r][] = $b;
}
?>

<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <h5 class="mb-0">Blocks: <b><?= esc($pageTitle) ?></b></h5>
        <small class="text-muted"><?= esc($subtitle) ?></small>
    </div>
    <div class="text-end">
        <a href="/admin/layout-pages" class="btn btn-sm btn-secondary">← Quay lại</a>
        <a href="/admin/layout-blocks/new?page_id=<?= (int)$page['id'] ?>" class="btn btn-sm btn-primary">Thêm block</a>
    </div>
</div>

<?php if (empty($blocks)): ?>
    <div class="alert alert-info">
        Chưa có block nào. Nhấn <b>Thêm block</b> để tạo.
    </div>
<?php else: ?>

    <?php foreach ($grouped as $region => $items): ?>
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <b><?= esc($regionLabels[$region] ?? strtoupper($region)) ?></b>
                    <small class="text-muted"> (<?= count($items) ?> block)</small>
                </div>
                <a href="/admin/layout-blocks/new?page_id=<?= (int)$page['id'] ?>&region=<?= urlencode($region) ?>"
                   class="btn btn-sm btn-outline-primary">
                    + Thêm vào <?= esc($regionLabels[$region] ?? $region) ?>
                </a>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped table-sm mb-0">
                    <thead>
                        <tr>
                            <th style="width:80px;">#</th>
                            <th>Loại</th>
                            <th>Tiêu đề</th>
                            <th style="width:120px;">Trạng thái</th>
                            <th class="text-end" style="width:180px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $b): ?>
                            <tr>
                                <td><?= (int)($b['sort_order'] ?? 0) ?></td>
                                <td>
                                    <b><?= esc($b['block_name'] ?? '') ?></b>
                                    <?php if (!empty($b['block_key'])): ?>
                                        <small class="text-muted">(<?= esc($b['block_key']) ?>)</small>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($b['title'] ?? '') ?></td>
                                <td>
                                    <?php if (!empty($b['is_active'])): ?>
                                        <span class="badge bg-success">ON</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">OFF</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="/admin/layout-blocks/<?= (int)$b['id'] ?>/edit" class="btn btn-sm btn-warning">
                                        Sửa
                                    </a>
                                    <form method="post" action="/admin/layout-blocks/<?= (int)$b['id'] ?>"
                                          class="d-inline" onsubmit="return confirm('Xoá block này?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-sm btn-danger">Xoá</button>
                                    </form>
                                </td>
                            </tr>

                            <?php if (!empty($b['config'])): ?>
                                <tr>
                                    <td></td>
                                    <td colspan="4">
                                        <small class="text-muted">Config:</small>
                                        <pre class="mb-0" style="white-space: pre-wrap;"><?= esc($b['config']) ?></pre>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

<?= $this->endSection() ?>
