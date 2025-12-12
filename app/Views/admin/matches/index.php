<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="/admin/matches/new" class="btn btn-sm btn-primary mb-2">Thêm trận đấu</a>

<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>Thời gian</th>
            <th>Giải</th>
            <th>Trận</th>
            <th>Tỷ số</th>
            <th>Trạng thái</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($matches as $m): ?>
            <tr>
                <td><?= $m['kickoff'] ?></td>
                <td><?= esc($m['league_name']) ?></td>
                <td><?= esc($m['home_name']) ?> vs <?= esc($m['away_name']) ?></td>
                <td><?= $m['home_score'] ?> - <?= $m['away_score'] ?></td>
                <td><?= esc($m['status']) ?></td>
                <td class="text-end">
                    <a href="/admin/matches/edit/<?= $m['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="/admin/matches/delete/<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoá?')">Xoá</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $pager->links() ?>

<?= $this->endSection() ?>
