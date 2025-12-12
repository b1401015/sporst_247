<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-1 mb-3"><?= esc($league['name']) ?> - <?= esc($league['season']) ?></h5>

<form class="mb-3" method="get">
    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">Tất cả</option>
        <option value="scheduled" <?= $status=='scheduled'?'selected':'' ?>>Sắp diễn ra</option>
        <option value="live" <?= $status=='live'?'selected':'' ?>>Đang diễn ra</option>
        <option value="finished" <?= $status=='finished'?'selected':'' ?>>Đã kết thúc</option>
    </select>
</form>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Thời gian</th>
            <th>Trận đấu</th>
            <th>Tỷ số</th>
            <th>Sân</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($matches)): ?>
            <?php foreach ($matches as $m): ?>
                <tr>
                    <td><?= date('d/m H:i', strtotime($m['kickoff'])) ?></td>
                    <td><?= esc($m['home_name']) ?> vs <?= esc($m['away_name']) ?></td>
                    <td>
                        <?php if ($m['status'] == 'finished' || $m['status'] == 'live'): ?>
                            <?= $m['home_score'] ?> - <?= $m['away_score'] ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= esc($m['stadium']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">Chưa có trận đấu.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
