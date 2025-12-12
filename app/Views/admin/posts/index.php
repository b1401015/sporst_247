<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="/admin/posts/new" class="btn btn-sm btn-primary mb-2">Thêm bài viết</a>

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

<?= $pager->links() ?>

<?= $this->endSection() ?>
