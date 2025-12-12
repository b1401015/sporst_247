<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-1 mb-3">Video</h5>

<div class="row">
    <?php if (!empty($videos)): ?>
        <?php foreach ($videos as $v): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <?php if (!empty($v['thumbnail'])): ?>
                        <img src="<?= esc($v['thumbnail']) ?>" class="card-img-top" alt="" loading="lazy">
                    <?php endif; ?>
                    <div class="card-body">
                        <h6 class="card-title">
                            <a href="/video/<?= esc($v['slug']) ?>"><?= esc($v['title']) ?></a>
                        </h6>
                        <p class="card-text small text-muted"><?= esc($v['summary']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có video.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
