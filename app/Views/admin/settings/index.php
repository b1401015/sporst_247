<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<form method="post" action="/admin/settings/save">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Tên site</label>
        <input type="text" name="site_name" class="form-control"
               value="<?php
               $val = '';
               foreach ($settings as $s) if ($s['key']=='site_name') $val=$s['value'];
               echo esc($val);
               ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả site</label>
        <textarea name="site_description" class="form-control" rows="3"><?php
            $val = '';
            foreach ($settings as $s) if ($s['key']=='site_description') $val=$s['value'];
            echo esc($val);
        ?></textarea>
    </div>
    <button class="btn btn-primary">Lưu</button>
</form>

<?= $this->endSection() ?>
