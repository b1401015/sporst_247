<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
    // Nếu $ad có dữ liệu => đang sửa, ngược lại là thêm mới
    $isEdit = !empty($ad);
    $action = $isEdit
        ? site_url('admin/ads/update/' . $ad['id'])
        : site_url('admin/ads/create');
?>

<h1 class="h4 mb-3">
    <?= $isEdit ? 'Sửa quảng cáo' : 'Thêm quảng cáo' ?>
</h1>

<form method="post"
      action="<?= $action ?>"
      enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">
        <!-- Cột trái: thông tin chính -->
        <div class="col-md-8">

            <!-- Tiêu đề -->
            <div class="mb-3">
                <label class="form-label">Tiêu đề banner</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="<?= esc($ad['title'] ?? '') ?>"
                       placeholder="VD: Top trang chủ 980x90">
                <div class="form-text">
                    Chỉ dùng để quản lý trong admin, không bắt buộc hiển thị ngoài frontend.
                </div>
            </div>

            <!-- Vị trí -->
            <div class="mb-3">
                <label class="form-label">Vị trí hiển thị</label>
                <?php
                $currentPos = $ad['position'] ?? 'top_banner';
                $positions  = [
                    'top_banner'     => 'Top trang chủ (banner ngang)',
                    'right_sidebar'  => 'Sidebar phải',
                    'article_mid'    => 'Giữa nội dung bài viết',
                    'article_bottom' => 'Cuối bài viết',
                    'popup_home'     => 'Popup khi vào trang chủ',
                ];
                ?>
                <select name="position" class="form-select">
                    <?php foreach ($positions as $value => $label): ?>
                        <option value="<?= $value ?>"
                            <?= $currentPos === $value ? 'selected' : '' ?>>
                            <?= $label ?> (<?= $value ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">
                    Frontend sẽ dùng <code>position</code> này để lấy banner đúng chỗ.
                </div>
            </div>

            <!-- Link click -->
            <div class="mb-3">
                <label class="form-label">Link khi click</label>
                <input type="text"
                       name="link"
                       class="form-control"
                       value="<?= esc($ad['link'] ?? '') ?>"
                       placeholder="https://example.com">
                <div class="form-text">
                    Khi người dùng click banner sẽ chuyển tới link này.
                    Nếu để trống thì click sẽ không redirect.
                </div>
            </div>

            <!-- HTML / Script -->
            <div class="mb-3">
                <label class="form-label">
                    Mã HTML / Script (tuỳ chọn)
                </label>
                <textarea name="html"
                          class="form-control"
                          rows="5"
                          placeholder="Dán mã Adsense, script bên thứ 3, iframe video, ...">
<?= esc($ad['html'] ?? '') ?></textarea>
                <div class="form-text">
                    Nếu nhập HTML/script thì có thể không cần chọn ảnh bên dưới.
                    Frontend sẽ ưu tiên render <code>html</code> nếu không rỗng.
                </div>
            </div>

        </div>

        <!-- Cột phải: ảnh & trạng thái -->
        <div class="col-md-4">

            <!-- Ảnh banner -->
            <div class="mb-3">
                <label class="form-label">Ảnh banner</label>

                <?php if (!empty($ad['image'])): ?>
                    <div class="mb-2">
                        <img src="<?= base_url($ad['image']) ?>"
                             alt="Banner"
                             style="max-width:100%; max-height:160px; object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                    </div>
                <?php endif; ?>

                <input type="file"
                       name="image"
                       class="form-control">
                <div class="form-text">
                    Chọn file ảnh (jpg, png...). Nếu không chọn, hệ thống sẽ giữ ảnh cũ (nếu có).
                    Ảnh sẽ được lưu vào thư mục <code>public/uploads/ads</code>.
                </div>
            </div>

            <!-- Trạng thái -->
            <div class="form-check mb-3">
                <input class="form-check-input"
                       type="checkbox"
                       name="is_active"
                       id="is_active"
                       <?= !empty($ad['is_active']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_active">
                    Đang chạy (hiển thị trên website)
                </label>
            </div>

            <!-- Thứ tự -->
            <div class="mb-3">
                <label class="form-label">Thứ tự hiển thị</label>
                <input type="number"
                       name="sort_order"
                       class="form-control"
                       value="<?= esc($ad['sort_order'] ?? 0) ?>">
                <div class="form-text">
                    Số nhỏ hơn sẽ hiển thị trước khi có nhiều banner cùng vị trí.
                </div>
            </div>

            <!-- Bắt đầu / kết thúc -->
            <div class="mb-3">
                <label class="form-label">Bắt đầu hiển thị</label>
                <input type="datetime-local"
                       name="started_at"
                       class="form-control"
                       value="<?php
                            if (!empty($ad['started_at'])) {
                                echo date('Y-m-d\TH:i', strtotime($ad['started_at']));
                            }
                       ?>">
                <div class="form-text">
                    Để trống nếu muốn hiển thị ngay và không giới hạn ngày bắt đầu.
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kết thúc hiển thị</label>
                <input type="datetime-local"
                       name="ended_at"
                       class="form-control"
                       value="<?php
                            if (!empty($ad['ended_at'])) {
                                echo date('Y-m-d\TH:i', strtotime($ad['ended_at']));
                            }
                       ?>">
                <div class="form-text">
                    Để trống nếu không giới hạn ngày kết thúc.
                </div>
            </div>

        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <?= $isEdit ? 'Cập nhật' : 'Lưu quảng cáo' ?>
    </button>
    <a href="<?= site_url('admin/ads') ?>" class="btn btn-secondary ms-2">
        Quay lại
    </a>
</form>

<?= $this->endSection() ?>
