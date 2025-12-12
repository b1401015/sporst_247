<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="/admin/goals/new" class="btn btn-sm btn-primary mb-2">Thêm bàn thắng</a>

<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Match</th>
            <th>Player</th>
            <th>Phút</th>
            <th>Penalty</th>
            <th>Phản lưới</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= esc($item['match_id']) ?></td>
                <td><?= esc($item['player_id']) ?></td>
                <td><?= esc($item['minute']) ?></td>
                <td><?= $item['is_penalty'] ? '✔' : '' ?></td>
                <td><?= $item['is_own_goal'] ? '✔' : '' ?></td>
                <td class="text-end">
                    <a href="/admin/goals/edit/<?= $item['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="/admin/goals/delete/<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoá?')">Xoá</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $pager->links() ?>

<?= $this->endSection() ?>
