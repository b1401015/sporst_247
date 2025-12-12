<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($post); ?>

<form method="post" enctype="multipart/form-data"
      action="<?= $isEdit ? '/admin/posts/update/'.$post['id'] : '/admin/posts/create' ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text" name="title" class="form-control" required
               value="<?= esc($post['title'] ?? old('title')) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Danh mục</label>
        <select name="category_id" class="form-select" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= isset($post['category_id']) && $post['category_id']==$cat['id'] ? 'selected' : '' ?>>
                    <?= esc($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tóm tắt</label>
        <textarea name="summary" class="form-control" rows="3"><?= esc($post['summary'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Nội dung</label>
        <textarea id="content" name="content" class="form-control" rows="10"><?= esc($post['content'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Ảnh thumbnail</label>
        <?php if (!empty($post['thumbnail'])): ?>
            <div class="mb-2"><img src="<?= esc($post['thumbnail']) ?>" width="150" loading="lazy"></div>
        <?php endif; ?>
        <input type="file" name="thumbnail_file" class="form-control">
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <?php $status = $post['status'] ?? 'draft'; ?>
                <option value="draft" <?= $status=='draft'?'selected':'' ?>>Nháp</option>
                <option value="published" <?= $status=='published'?'selected':'' ?>>Đã đăng</option>
                <option value="archived" <?= $status=='archived'?'selected':'' ?>>Lưu trữ</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Nổi bật?</label>
            <select name="is_featured" class="form-select">
                <?php $f = $post['is_featured'] ?? 0; ?>
                <option value="0" <?= !$f?'selected':'' ?>>Không</option>
                <option value="1" <?= $f?'selected':'' ?>>Có</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Hot?</label>
            <select name="is_hot" class="form-select">
                <?php $h = $post['is_hot'] ?? 0; ?>
                <option value="0" <?= !$h?'selected':'' ?>>Không</option>
                <option value="1" <?= $h?'selected':'' ?>>Có</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ngày đăng (nếu có)</label>
            <input type="datetime-local" name="published_at" class="form-control"
                   value="<?= !empty($post['published_at']) ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : '' ?>">
        </div>
    </div>

    <button class="btn btn-primary">Lưu</button>
</form>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>

<?= $this->endSection() ?>
