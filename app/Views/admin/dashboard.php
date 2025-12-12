<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <div class="card card-body">
            <h6>Tổng số bài viết</h6>
            <p class="display-6"><?= (int)$postCount ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-body">
            <h6>Trận hôm nay</h6>
            <p class="display-6"><?= (int)$todayMatchCount ?></p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
