<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-2 mb-3">
    BXH <?= esc($league['name']) ?> <?= esc($league['season']) ?>
    <small class="text-muted ms-2">
        <a href="/league/<?= esc($league['slug']) ?>/scorers">Vua phá lưới</a>
        |
        <a href="/league/<?= esc($league['slug']) ?>/week/1">BXH theo vòng</a>
    </small>
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
            <th>Form</th>
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
                <td class="small">
                    <?php if (!empty($r['form'])): ?>
                        <?php foreach ($r['form'] as $f): ?>
                            <span class="badge bg-<?= $f=='W'?'success':($f=='D'?'secondary':'danger') ?> me-1"><?= $f ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="11">Chưa có dữ liệu.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
