<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-1 mb-3">Kết quả & lịch thi đấu</h5>

<div class="row">
    <?php if (!empty($leagues)): ?>
        <?php foreach ($leagues as $league): ?>
            <div class="col-md-4 mb-2">
                <div class="card card-body py-2">
                    <a href="/league/<?= esc($league['slug']) ?>">
                        <?= esc($league['name']) ?> (<?= esc($league['season']) ?>)
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có giải đấu.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
