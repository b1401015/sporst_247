<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<article class="row">
    <div class="col-lg-8">
        <h2 class="mb-2"><?= esc($post['title']) ?></h2>
        <p class="text-muted small mb-3">
            <?= !empty($post['published_at']) ? date('d/m/Y H:i', strtotime($post['published_at'])) : '' ?>
            | Lượt xem: <?= (int)$post['view_count'] + 1 ?>
        </p>
        <?php if (!empty($post['thumbnail'])): ?>
            <img src="<?= esc($post['thumbnail']) ?>" class="img-fluid mb-3" alt="" loading="lazy">
        <?php endif; ?>

        <div class="post-content">
            <?= $post['content'] ?>
        </div>

        <div class="mt-4">
            <h5>Bình luận</h5>

            <?php if (session('message')): ?>
                <div class="alert alert-success small"><?= session('message') ?></div>
            <?php endif; ?>

            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $c): ?>
                    <div class="mb-2 border-bottom pb-1">
                        <strong><?= esc($c['user_name']) ?></strong>
                        <span class="text-muted small"><?= $c['created_at'] ?></span>
                        <p class="mb-1"><?= nl2br(esc($c['content'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="small text-muted">Chưa có bình luận nào.</p>
            <?php endif; ?>

            <form method="post" action="/post/<?= esc($post['slug']) ?>/comment" class="mt-3">
                <?= csrf_field() ?>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input name="user_name" class="form-control form-control-sm" placeholder="Tên của bạn">
                    </div>
                    <div class="col-md-6">
                        <input name="user_email" type="email" class="form-control form-control-sm" placeholder="Email (không bắt buộc)">
                    </div>
                </div>
                <div class="mb-2">
                    <textarea name="content" rows="3" class="form-control" placeholder="Nội dung bình luận..." required></textarea>
                </div>
                <button class="btn btn-sm btn-primary">Gửi bình luận</button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <?php if (!empty($related)): ?>
            <div class="card mb-3">
                <div class="card-header bg-danger text-white">Bài liên quan</div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($related as $rp): ?>
                        <li class="list-group-item small">
                            <a href="/post/<?= esc($rp['slug']) ?>"><?= esc($rp['title']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</article>

<?= $this->endSection() ?>
