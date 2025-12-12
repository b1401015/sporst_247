<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-2 mb-3">
    BXH vòng <?= (int)$week ?> - <?= esc($league['name']) ?> <?= esc($league['season']) ?>
</h5>

<table class="table table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Đội</th>
            <th>Tr</th>
            <th>Th</th>
            <th>H</th>
            <th>B</th>
            <th>BT</th>
            <th>BB</th>
            <th>HS</th>
            <th>Đ</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($rows)): $i=1; foreach ($rows as $r): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <?php if (!empty($r['logo'])): ?>
                        <img src="<?= esc($r['logo']) ?>" alt="" style="height:20px" loading="lazy" class="me-1">
                    <?php endif; ?>
                    <?= esc($r['name']) ?>
                </td>
                <td><?= $r['played'] ?></td>
                <td><?= $r['win'] ?></td>
                <td><?= $r['draw'] ?></td>
                <td><?= $r['lose'] ?></td>
                <td><?= $r['goals_for'] ?></td>
                <td><?= $r['goals_against'] ?></td>
                <td><?= $r['goals_for'] - $r['goals_against'] ?></td>
                <td><?= $r['points'] ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="10">Chưa có dữ liệu.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
