<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- HERO TRANG CHỦ (kiểu Thể Thao 247) -->
<div class="row sn-home-hero g-3">
    <div class="col-lg-8">
        <?php
        $mainFeatured      = !empty($featured) ? $featured[0] : null;
        $secondaryFeatured = !empty($featured) ? array_slice($featured, 1) : [];
        ?>
        <?php if ($mainFeatured): ?>
            <div class="sn-hero-main">
                <a href="<?= base_url('post/' . esc($mainFeatured['slug'])) ?>" class="sn-hero-main-link">
                    <?php if (!empty($mainFeatured['thumbnail'])): ?>
                        <img src="<?= base_url($mainFeatured['thumbnail']) ?>" alt="<?= esc($mainFeatured['title']) ?>">
                    <?php else: ?>
                        <div class="sn-hero-main-placeholder">
                            Không có ảnh
                        </div>
                    <?php endif; ?>

                    <div class="sn-hero-main-caption">
                        <?php if (!empty($mainFeatured['category_name'])): ?>
                            <span class="sn-hero-main-category">
                                <?= esc($mainFeatured['category_name']) ?>
                            </span>
                        <?php endif; ?>
                        <h2 class="sn-hero-main-title">
                            <?= esc($mainFeatured['title']) ?>
                        </h2>
                    </div>
                </a>
            </div>

            <?php if (!empty($secondaryFeatured)): ?>
                <div class="sn-hero-secondary row g-3 mt-2">
                    <?php foreach ($secondaryFeatured as $sub): ?>
                        <div class="col-md-6">
                            <article class="sn-hero-secondary-item">
                                <a href="<?= base_url('post/' . esc($sub['slug'])) ?>" class="sn-hero-secondary-thumb">
                                    <?php if (!empty($sub['thumbnail'])): ?>
                                        <img src="<?= base_url($sub['thumbnail']) ?>" alt="<?= esc($sub['title']) ?>">
                                    <?php else: ?>
                                        <div class="sn-thumb-placeholder">Không có ảnh</div>
                                    <?php endif; ?>
                                </a>
                                <div class="sn-hero-secondary-body">
                                    <?php if (!empty($sub['category_name'])): ?>
                                        <div class="sn-hero-secondary-cat">
                                            <?= esc($sub['category_name']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="sn-hero-secondary-title">
                                        <a href="<?= base_url('post/' . esc($sub['slug'])) ?>">
                                            <?= esc($sub['title']) ?>
                                        </a>
                                    </h3>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Chưa có tin nổi bật.</p>
        <?php endif; ?>
    </div>

    <!-- Cột phải: lịch đấu + BXH -->
    <div class="col-lg-4">
        <!-- Lịch đấu hôm nay -->
        <div class="sn-widget">
            <div class="sn-widget-header sn-widget-header--blue">
                LỊCH THI ĐẤU / TỶ SỐ HÔM NAY
            </div>
            <div class="sn-widget-body">
                <?php if (!empty($todayMatches)): ?>
                    <?php foreach ($todayMatches as $m): ?>
                        <div class="sn-match-row">
                            <span class="sn-match-time">
                                <?= date('H:i', strtotime($m['kickoff'])) ?>
                            </span>
                            <span class="sn-match-teams">
                                <?= esc($m['home_name']) ?> vs <?= esc($m['away_name']) ?>
                            </span>
                            <?php if ($m['status'] === 'finished'): ?>
                                <span class="sn-match-score">
                                    <?= $m['home_score'] ?> - <?= $m['away_score'] ?>
                                </span>
                            <?php elseif ($m['status'] === 'live'): ?>
                                <span class="sn-match-score sn-match-score--live">
                                    LIVE
                                </span>
                            <?php else: ?>
                                <span class="sn-match-score sn-match-score--scheduled">
                                    -
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="mb-0 text-muted small">Không có trận đấu nào hôm nay.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- BXH -->
        <div class="sn-widget">
            <div class="sn-widget-header sn-widget-header--green">
                BXH <?= !empty($league['name']) ? esc($league['name']) : '' ?>
            </div>
            <div class="sn-widget-body p-0">
                <?php if (!empty($standings)): ?>
                    <table class="table table-sm mb-0 sn-table-standings">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Đội</th>
                            <th>Tr</th>
                            <th>Đ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; foreach ($standings as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['name']) ?></td>
                                <td><?= $row['played'] ?></td>
                                <td><?= $row['points'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="p-3">
                        <p class="mb-0 text-muted small">Chưa có dữ liệu BXH.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- DÒNG TIN MỚI + TRENDING -->
<div class="row g-4 mt-2">
    <div class="col-lg-8">
        <h2 class="sn-block-title">TIN MỚI NHẤT</h2>

        <?php if (!empty($latest)): ?>
            <?php foreach ($latest as $post): ?>
                <article class="sn-article-card">
                    <a href="<?= base_url('post/' . esc($post['slug'])) ?>" class="sn-article-thumb">
                        <?php if (!empty($post['thumbnail'])): ?>
                            <img src="<?= base_url($post['thumbnail']) ?>" alt="<?= esc($post['title']) ?>">
                        <?php else: ?>
                            <div class="sn-thumb-placeholder">Không có ảnh</div>
                        <?php endif; ?>
                    </a>
                    <div class="sn-article-body">
                        <?php if (!empty($post['category_name'])): ?>
                            <div class="sn-article-category">
                                <?= esc($post['category_name']) ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="sn-article-title">
                            <a href="<?= base_url('post/' . esc($post['slug'])) ?>">
                                <?= esc($post['title']) ?>
                            </a>
                        </h3>
                        <div class="sn-article-meta">
                            <?= date('d/m/Y H:i', strtotime($post['published_at'])) ?>
                        </div>
                        <?php if (!empty($post['summary'])): ?>
                            <p class="sn-article-summary">
                                <?= esc($post['summary']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có bài viết nào.</p>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <!-- Tin trending -->
        <div class="sn-widget">
            <div class="sn-widget-header sn-widget-header--orange">
                TIN ĐỌC NHIỀU
            </div>
            <div class="sn-widget-body">
                <?php if (!empty($trending)): ?>
                    <ul class="sn-list-trending">
                        <?php $i = 1; foreach ($trending as $p): ?>
                            <li>
                                <span class="sn-trending-index"><?= $i++ ?></span>
                                <a href="<?= base_url('post/' . esc($p['slug'])) ?>">
                                    <?= esc($p['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="mb-0 text-muted small">Chưa có bài trending.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- SIDEBAR BANNER ADS (view_cell) -->
        <?= view_cell('App\Cells\AdCell::rightSidebar', 'limit=2') ?>

    </div>
</div>

<?= $this->endSection() ?>
