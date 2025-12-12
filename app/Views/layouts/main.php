<?php
helper('url');
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title><?= isset($title) ? esc($title) . ' - ' : '' ?>SportNews CI4</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <!-- CSS custom -->
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
</head>
<body class="bg-light">

    <!-- TOP BAR -->
    <div class="sn-topbar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="sn-logo fw-bold">
                <a href="<?= base_url() ?>">SportNews CI4</a>
            </div>

            <form class="d-none d-md-flex sn-search" action="<?= base_url('search') ?>" method="get">
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="Tìm kiếm tin tức, đội bóng, giải đấu..."
                />
            </form>
        </div>
    </div>

    <!-- MAIN NAV -->
    <nav class="sn-mainnav">
        <div class="container">
            <ul class="nav sn-nav-list">
                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('results') ?>">Kết quả</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('live') ?>">Trực tiếp</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('fixtures') ?>">Lịch thi đấu</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('medals') ?>">Bảng huy chương</a></li>
                <li class="nav-item"><a class="nav-link" href <?= base_url('videos') ?>>Video</a></li>
            </ul>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main class="sn-main">
        <div class="container">

            <!-- TOP BANNER ADS (view_cell) -->
            <?= view_cell('App\Cells\AdCell::topBanner', 'limit=1') ?>

            <!-- MAIN CONTENT -->
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="sn-footer">
        <div class="container text-center">
            <small>© <?= date('Y') ?> SportNews CI4. All rights reserved.</small>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/main.js') ?>"></script>
</body>
</html>
