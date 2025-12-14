<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- Form tìm kiếm và bộ lọc -->
<form method="get" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="title" value="<?= esc($title_filter) ?>" class="form-control" placeholder="Tìm theo tiêu đề">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-control">
                <option value="">Chọn trạng thái</option>
                <option value="published" <?= $status_filter === 'published' ? 'selected' : '' ?>>Đã xuất bản</option>
                <option value="draft" <?= $status_filter === 'draft' ? 'selected' : '' ?>>Nháp</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="start_date" value="<?= esc($start_date_filter) ?>" class="form-control">
        </div>
        <div class="col-md-2">
            <input type="date" name="end_date" value="<?= esc($end_date_filter) ?>" class="form-control">
        </div>
    </div>
    <div style="margin-top: 10px;">
<button type="submit" class="btn btn-primary">Tìm kiếm</button>
    <a href="/admin/posts" class="btn btn-secondary">Clear</a> <!-- Nút Clear -->
    </div>
    
</form>

<a href="/admin/posts/new" class="btn btn-sm btn-primary mb-2">Thêm bài viết</a>

<!-- Bảng hiển thị bài viết -->
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Trạng thái</th>
            <th>Lượt xem</th>
            <th>Ngày</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= $post['id'] ?></td>
                <td><?= esc($post['title']) ?></td>
                <td><?= esc($post['status']) ?></td>
                <td><?= $post['view_count'] ?></td>
                <td><?= $post['created_at'] ?></td>
                <td class="text-end">
                    <a href="/admin/posts/edit/<?= $post['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="/admin/posts/delete/<?= $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoá?')">Xoá</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Phân trang -->
<?= $pager->links() ?>

<?= $this->endSection() ?>
