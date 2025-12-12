<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<a href="/admin/ads/new" class="btn btn-sm btn-primary mb-3">
    + Thêm quảng cáo
</a>

<table class="table table-striped table-sm align-middle">
    <thead>
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Vị trí</th>
        <th>Ảnh</th>
        <th>Trạng thái</th>
        <th>Thứ tự</th>
        <th>Thời gian</th>
        <th class="text-end">Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($ads as $ad): ?>
        <tr>
            <td><?= $ad['id'] ?></td>
            <td><?= esc($ad['title'] ?: '(Không tiêu đề)') ?></td>
            <td><span class="badge bg-secondary"><?= esc($ad['position']) ?></span></td>
            <td style="width:120px;">
                <?php if (!empty($ad['image'])): ?>
                    <img src="<?= base_url($ad['image']) ?>" alt="" style="max-width:110px; max-height:60px; object-fit:cover;">
                <?php else: ?>
                    <span class="text-muted small">HTML / không có ảnh</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($ad['is_active']): ?>
                    <span class="badge bg-success">Đang chạy</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Tạm tắt</span>
                <?php endif; ?>
            </td>
            <td><?= (int)$ad['sort_order'] ?></td>
            <td class="small">
                <?php if (!empty($ad['started_at'])): ?>
                    <div>Bắt đầu: <?= $ad['started_at'] ?></div>
                <?php endif; ?>
                <?php if (!empty($ad['ended_at'])): ?>
                    <div>Kết thúc: <?= $ad['ended_at'] ?></div>
                <?php endif; ?>
            </td>
            <td class="text-end">
                <a href="/admin/ads/edit/<?= $ad['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                <a href="/admin/ads/delete/<?= $ad['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Xoá quảng cáo này?')">
                    Xoá
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $pager->links() ?>

<?= $this->endSection() ?>
