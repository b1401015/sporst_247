<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-2 mb-3">Bảng xếp hạng nhiều giải</h5>

<div class="row">
    <?php foreach ($leagues as $lg): ?>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <span><?= esc($lg['name']) ?> <?= esc($lg['season']) ?></span>
                    <a href="/league/<?= esc($lg['slug']) ?>/table" class="text-white small">Xem đầy đủ</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Đội</th>
                                <th>Tr</th>
                                <th>Đ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $rows = $tables[$lg['id']] ?? [];
                            $rows = array_slice($rows, 0, 6);
                            $i = 1;
                        ?>
                        <?php if ($rows): ?>
                            <?php foreach ($rows as $r): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?php if (!empty($r['logo'])): ?>
                                            <img src="<?= esc($r['logo']) ?>" alt="" style="height:18px" loading="lazy" class="me-1">
                                        <?php endif; ?>
                                        <?= esc($r['name']) ?>
                                    </td>
                                    <td><?= (int)$r['played'] ?></td>
                                    <td><?= (int)$r['points'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4">Chưa có dữ liệu.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
