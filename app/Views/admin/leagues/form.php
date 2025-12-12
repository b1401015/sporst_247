<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($item); ?>

<form method="post" action="<?= $isEdit ? '/admin/leagues/update/'.$item['id'] : '/admin/leagues/create' ?>">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" name="name" class="form-control" required
               value="<?= esc($item['name'] ?? '') ?>">
    </div>
    <?php if ($slug == 'categories'): ?>
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control"
                   value="<?= esc($item['slug'] ?? '') ?>">
        </div>
    <?php endif; ?>
    <button class="btn btn-primary">Lưu</button>
</form>

<?= $this->endSection() ?>
