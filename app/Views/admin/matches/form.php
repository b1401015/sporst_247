<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php $isEdit = !empty($item); ?>

<form method="post" action="<?= $isEdit ? '/admin/matches/update/'.$item['id'] : '/admin/matches/create' ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Giải đấu</label>
        <select name="league_id" class="form-select">
            <?php foreach ($leagues as $l): ?>
                <option value="<?= $l['id'] ?>" <?= !empty($item['league_id']) && $item['league_id']==$l['id']?'selected':'' ?>>
                    <?= esc($l['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Đội chủ nhà</label>
        <select name="home_team_id" class="form-select">
            <?php foreach ($teams as $t): ?>
                <option value="<?= $t['id'] ?>" <?= !empty($item['home_team_id']) && $item['home_team_id']==$t['id']?'selected':'' ?>>
                    <?= esc($t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Đội khách</label>
        <select name="away_team_id" class="form-select">
            <?php foreach ($teams as $t): ?>
                <option value="<?= $t['id'] ?>" <?= !empty($item['away_team_id']) && $item['away_team_id']==$t['id']?'selected':'' ?>>
                    <?= esc($t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Thời gian</label>
            <input type="datetime-local" name="kickoff" class="form-control"
                   value="<?= !empty($item['kickoff']) ? date('Y-m-d\TH:i', strtotime($item['kickoff'])) : '' ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sân</label>
            <input type="text" name="stadium" class="form-control" value="<?= esc($item['stadium'] ?? '') ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <?php $status = $item['status'] ?? 'scheduled'; ?>
                <option value="scheduled" <?= $status=='scheduled'?'selected':'' ?>>Sắp diễn ra</option>
                <option value="live" <?= $status=='live'?'selected':'' ?>>Đang diễn ra</option>
                <option value="finished" <?= $status=='finished'?'selected':'' ?>>Đã kết thúc</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label class="form-label">Bàn thắng chủ nhà</label>
            <input type="number" name="home_score" class="form-control" value="<?= esc($item['home_score'] ?? 0) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Bàn thắng đội khách</label>
            <input type="number" name="away_score" class="form-control" value="<?= esc($item['away_score'] ?? 0) ?>">
        </div>
    </div>

    <button class="btn btn-primary">Lưu</button>
</form>

<?= $this->endSection() ?>
