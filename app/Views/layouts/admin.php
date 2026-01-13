<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Admin - <?= esc($title ?? '') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link href="/assets/style_admin.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <nav class="bg-dark text-white p-3" style="min-width:220px; min-height:100vh;">
        <h5>Admin</h5>
        <ul class="nav flex-column small">
            <li class="nav-item"><a href="/admin" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="/admin/posts" class="nav-link text-white">Bài viết</a></li>
            <li class="nav-item"><a href="/admin/categories" class="nav-link text-white">Danh mục</a></li>
            <li class="nav-item"><a href="/admin/tags" class="nav-link text-white">Tags</a></li>
            <li class="nav-item"><a href="/admin/leagues" class="nav-link text-white">Giải đấu</a></li>
            <li class="nav-item"><a href="/admin/teams" class="nav-link text-white">Đội bóng</a></li>
            <li class="nav-item"><a href="/admin/matches" class="nav-link text-white">Trận đấu</a></li>
            <li class="nav-item"><a href="/admin/ads" class="nav-link text-white">Quảng cáo</a></li>
            <li class="nav-item"><a href="/admin/settings" class="nav-link text-white">Cấu hình</a></li>
            <li class="nav-item"><a href="/admin/layout-pages" class="nav-link text-white">Layout Pages</a></li>
            <li class="nav-item"><a href="/admin/users" class="nav-link text-white">Người dùng</a></li>
            <li class="nav-item mt-3"><a href="/logout" class="nav-link text-warning">Đăng xuất</a></li>
        </ul>
    </nav>
    <main class="flex-grow-1 p-3">
        <h4 class="mb-3"><?= esc($title ?? '') ?></h4>
        <?php if (session('message')): ?>
            <div class="alert alert-success small"><?= session('message') ?></div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/main.js"></script>
</body>
</html>
