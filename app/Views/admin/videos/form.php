<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($item); ?>

<form method="post" action="<?= $isEdit ? '/admin/'.$slug.'/update/'.$item['id'] : '/admin/'.$slug.'/create' ?>">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" name="name" class="form-control"
               value="<?= esc($item['name'] ?? '') ?>">
    </div>
    <button class="btn btn-primary">Lưu</button>
</form>

<?= $this->endSection() ?>
