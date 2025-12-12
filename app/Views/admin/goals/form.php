<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($item); ?>

<form method="post" action="<?= $isEdit ? '/admin/goals/update/'.$item['id'] : '/admin/goals/create' ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Trận đấu</label>
        <select name="match_id" class="form-select" required>
            <option value="">-- Chọn trận --</option>
            <?php foreach ($matches as $m): ?>
                <option value="<?= $m['id'] ?>" <?= $isEdit && $item['match_id']==$m['id'] ? 'selected' : '' ?>>
                    #<?= $m['id'] ?> - <?= esc($m['kickoff']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Cầu thủ</label>
        <select name="player_id" class="form-select" required>
            <option value="">-- Chọn cầu thủ --</option>
            <?php foreach ($players as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $isEdit && $item['player_id']==$p['id'] ? 'selected' : '' ?>>
                    <?= esc($p['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Phút</label>
        <input type="number" name="minute" class="form-control"
               value="<?= esc($item['minute'] ?? '') ?>">
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="is_penalty" class="form-check-input" value="1"
               <?= !empty($item['is_penalty']) ? 'checked' : '' ?>>
        <label class="form-check-label">Penalty</label>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="is_own_goal" class="form-check-input" value="1"
               <?= !empty($item['is_own_goal']) ? 'checked' : '' ?>>
        <label class="form-check-label">Phản lưới</label>
    </div>

    <button class="btn btn-primary">Lưu</button>
</form>

<?= $this->endSection() ?>
