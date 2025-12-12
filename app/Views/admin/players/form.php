<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($item); ?>

<form method="post" action="<?= $isEdit ? '/admin/players/update/'.$item['id'] : '/admin/players/create' ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Đội</label>
        <select name="team_id" class="form-select" required>
            <option value="">-- Chọn đội --</option>
            <?php foreach ($teams as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $isEdit && $item['team_id']==$t['id'] ? 'selected' : '' ?>>
                    <?= esc($t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tên cầu thủ</label>
        <input type="text" name="name" class="form-control" required
               value="<?= esc($item['name'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Số áo</label>
        <input type="number" name="shirt_number" class="form-control"
               value="<?= esc($item['shirt_number'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Vị trí</label>
        <input type="text" name="position" class="form-control"
               value="<?= esc($item['position'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Ảnh (URL)</label>
        <input type="text" name="photo" class="form-control"
               value="<?= esc($item['photo'] ?? '') ?>">
    </div>

    <button class="btn btn-primary">Lưu</button>
</form>

<?= $this->endSection() ?>
