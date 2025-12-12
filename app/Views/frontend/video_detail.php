<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3 class="mb-3"><?= esc($video['title']) ?></h3>

<div class="ratio ratio-16x9 mb-3">
    <!-- Giả định embed_url là link iframe YouTube, bạn có thể tinh chỉnh -->
    <iframe src="<?= esc($video['embed_url']) ?>" allowfullscreen loading="lazy"></iframe>
</div>

<?php if (!empty($video['summary'])): ?>
    <p><?= nl2br(esc($video['summary'])) ?></p>
<?php endif; ?>

<?= $this->endSection() ?>
