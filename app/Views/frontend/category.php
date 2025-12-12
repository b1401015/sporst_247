<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-1 mb-3"><?= esc($category['name']) ?></h5>

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="d-flex mb-2 latest-item">
            <img src="<?= esc($post['thumbnail'] ?? '/assets/placeholder_small.jpg') ?>" width="140" class="me-2 flex-shrink-0" alt="" loading="lazy">
            <div>
                <h6 class="mb-1">
                    <a href="/post/<?= esc($post['slug']) ?>" class="text-dark">
                        <?= esc($post['title']) ?>
                    </a>
                </h6>
                <p class="small text-muted mb-1"><?= esc($post['summary']) ?></p>
                <?php if (!empty($post['published_at'])): ?>
                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($post['published_at'])) ?></small>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Chưa có bài viết.</p>
<?php endif; ?>

<?= $this->endSection() ?>
