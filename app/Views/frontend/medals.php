<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-1 mb-3">Bảng huy chương</h5>

<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th><th>Quốc gia</th><th>Vàng</th><th>Bạc</th><th>Đồng</th><th>Tổng</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($rows)): $i=1; foreach ($rows as $r): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= esc($r['name']) ?></td>
                <td><?= $r['gold'] ?></td>
                <td><?= $r['silver'] ?></td>
                <td><?= $r['bronze'] ?></td>
                <td><?= $r['total'] ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="6">Chưa có dữ liệu.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
