<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
$isEdit = !empty($item);

$pageId = (int)($page['id'] ?? 0);
$backUrl = '/admin/layout-blocks?page_id=' . $pageId;

$selectedRegion = $isEdit
    ? ($item['region'] ?? 'main')
    : (($_GET['region'] ?? null) ?: 'main');

$actionUrl = $isEdit
    ? '/admin/layout-blocks/' . (int)$item['id']
    : '/admin/layout-blocks';
?>

<div class="d-flex align-items-center justify-content-between mb-2">
    <h5 class="mb-0"><?= $isEdit ? 'Sửa block' : 'Thêm block' ?></h5>
    <a href="<?= esc($backUrl) ?>" class="btn btn-sm btn-secondary">← Quay lại</a>
</div>

<?php if ($pageId <= 0): ?>
    <div class="alert alert-danger">Thiếu page_id.</div>
<?php else: ?>

<form method="post" action="<?= esc($actionUrl) ?>">
    <?= csrf_field() ?>

    <?php if ($isEdit): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <input type="hidden" name="page_id" value="<?= (int)$pageId ?>">

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Vùng (Region)</label>
            <select name="region" class="form-select" required>
                <?php
                $regions = [
                    'hero'    => 'Hero',
                    'main'    => 'Main',
                    'sidebar' => 'Sidebar',
                    'footer'  => 'Footer',
                ];
                foreach ($regions as $k => $label):
                ?>
                    <option value="<?= esc($k) ?>" <?= $selectedRegion === $k ? 'selected' : '' ?>>
                        <?= esc($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-8 mb-3">
            <label class="form-label">Loại block</label>
            <select name="block_type_id" class="form-select" required id="blockTypeSelect">
                <option value="">-- Chọn loại block --</option>
                <?php foreach (($types ?? []) as $t): ?>
                    <option
                        value="<?= (int)$t['id'] ?>"
                        data-default-config="<?= esc($t['default_config'] ?? '') ?>"
                        <?= $isEdit && (int)($item['block_type_id'] ?? 0) === (int)$t['id'] ? 'selected' : '' ?>
                    >
                        <?= esc($t['name']) ?> (<?= esc($t['key']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="text-muted">Chọn loại block để áp default config (nếu bạn chưa nhập).</small>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Tiêu đề (tuỳ chọn)</label>
        <input type="text" name="title" class="form-control"
               value="<?= esc($item['title'] ?? '') ?>"
               placeholder="VD: Tin mới nhất / BXH V-League...">
    </div>

    <div class="mb-3">
        <label class="form-label">Config (JSON / text)</label>
        <textarea name="config" class="form-control" rows="8" id="configTextarea"
                  placeholder='VD: {"limit":10,"thumb":true,"order":"latest"}'><?= esc($item['config'] ?? '') ?></textarea>
        <small class="text-muted">Có thể để trống. Nếu trống và bạn đổi loại block, hệ thống sẽ đổ default config.</small>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Sort order</label>
            <input type="number" name="sort_order" class="form-control"
                   value="<?= esc($item['sort_order'] ?? 0) ?>">
        </div>

        <div class="col-md-4 mb-3 d-flex align-items-end">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                    <?= empty($item) || !empty($item['is_active']) ? 'checked' : '' ?>>
                <label class="form-check-label">Hiển thị (Active)</label>
            </div>
        </div>
    </div>

    <button class="btn btn-primary"><?= $isEdit ? 'Cập nhật' : 'Tạo block' ?></button>
</form>

<script>
(function () {
    var sel = document.getElementById('blockTypeSelect');
    var cfg = document.getElementById('configTextarea');
    if (!sel || !cfg) return;

    sel.addEventListener('change', function () {
        // chỉ đổ default nếu textarea đang trống
        if (cfg.value && cfg.value.trim() !== '') return;
        var opt = sel.options[sel.selectedIndex];
        if (!opt) return;
        var def = opt.getAttribute('data-default-config') || '';
        if (def) cfg.value = def;
    });
})();
</script>

<?php endif; ?>

<?= $this->endSection() ?>
