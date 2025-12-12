<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-2 mb-3">
    Vua phá lưới <?= esc($league['name']) ?> <?= esc($league['season']) ?>
</h5>

<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Cầu thủ</th>
            <th>Đội</th>
            <th>Bàn</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($scorers)): $i=1; foreach ($scorers as $s): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= esc($s['name']) ?></td>
                <td>
                    <?php if (!empty($s['logo'])): ?>
                        <img src="<?= esc($s['logo']) ?>" alt="" style="height:18px" loading="lazy" class="me-1">
                    <?php endif; ?>
                    <?= esc($s['team']) ?>
                </td>
                <td><?= (int)$s['goals'] ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="4">Chưa có dữ liệu.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
