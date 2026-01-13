<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="mb-0">Quản lý bố cục (Layouts)</h5>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><b>Home</b></div>
            <div class="card-body">
                <?php if (!empty($homePage['id'])): ?>
                    <a class="btn btn-primary btn-sm" href="/admin/layout-blocks?page_id=<?= (int)$homePage['id'] ?>">
                        Quản lý blocks Home
                    </a>
                <?php else: ?>
                    <div class="alert alert-warning mb-0">Chưa có Home Layout page.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><b>Default Category Layout</b></div>
            <div class="card-body">
                <?php if (!empty($defaultCategoryPage['id'])): ?>
                    <a class="btn btn-primary btn-sm" href="/admin/layout-blocks?page_id=<?= (int)$defaultCategoryPage['id'] ?>">
                        Quản lý blocks mặc định cho Category
                    </a>
                <?php else: ?>
                    <div class="alert alert-warning mb-0">Chưa có Default Category Layout page.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <b>Layout theo danh mục (Override)</b>
        <span class="text-muted">Tạo layout riêng cho 1 danh mục</span>
    </div>
    <div class="card-body">
        <form method="post" action="/admin/layout-pages">
            <?= csrf_field() ?>
            <input type="hidden" name="page_type" value="category">
            <input type="hidden" name="is_active" value="1">

            <div class="row">
                <div class="col-md-5 mb-2">
                    <label class="form-label">Chọn danh mục</label>
                    <select name="ref_id" class="form-select" required>
                        <option value="">-- Chọn --</option>
                        <?php foreach (($categories ?? []) as $c): ?>
                            <option value="<?= (int)$c['id'] ?>">
                                <?= esc($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-5 mb-2">
                    <label class="form-label">Tiêu đề layout</label>
                    <input class="form-control" name="title" placeholder="VD: Layout Bóng đá Việt Nam">
                </div>

                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button class="btn btn-success w-100">Tạo / Mở</button>
                </div>
            </div>
        </form>

        <hr>

        <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width:80px;">ID</th>
                        <th>Loại</th>
                        <th>ref_id</th>
                        <th>Tiêu đề</th>
                        <th style="width:120px;">Active</th>
                        <th class="text-end" style="width:220px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($pages ?? []) as $p): ?>
                        <tr>
                            <td><?= (int)$p['id'] ?></td>
                            <td><?= esc($p['page_type']) ?></td>
                            <td><?= $p['ref_id'] === null ? '<span class="text-muted">NULL</span>' : (int)$p['ref_id'] ?></td>
                            <td><?= esc($p['title'] ?? '') ?></td>
                            <td>
                                <?php if (!empty($p['is_active'])): ?>
                                    <span class="badge bg-success">ON</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">OFF</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-primary"
                                   href="/admin/layout-blocks?page_id=<?= (int)$p['id'] ?>">
                                    Blocks
                                </a>

                                <form method="post" action="/admin/layout-pages/<?= (int)$p['id'] ?>" class="d-inline"
                                      onsubmit="return confirm('Xoá layout page này? (sẽ xoá luôn blocks)')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-sm btn-danger">Xoá</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($pages)): ?>
                        <tr><td colspan="6" class="text-muted">Chưa có layout page.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
