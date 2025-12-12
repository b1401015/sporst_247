<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập - SportNews CI4</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh">
    <div class="card shadow-sm" style="min-width:340px;">
        <div class="card-header bg-danger text-white text-center">
            <strong>Đăng nhập Admin</strong>
        </div>
        <div class="card-body">
            <?php if (session('error')): ?>
                <div class="alert alert-danger small"><?= session('error') ?></div>
            <?php endif; ?>
            <form method="post" action="/login">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Tài khoản</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-danger w-100">Đăng nhập</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
