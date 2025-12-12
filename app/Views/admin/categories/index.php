<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="/admin/<?= $slug ?>/new" class="btn btn-sm btn-primary mb-2">Thêm mới</a>

<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= esc($item['name'] ?? ($item['key'] ?? '')) ?></td>
                <td class="text-end">
                    <a href="/admin/<?= $slug ?>/edit/<?= $item['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="/admin/<?= $slug ?>/delete/<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoá?')">Xoá</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $pager->links() ?>

<?= $this->endSection() ?>
