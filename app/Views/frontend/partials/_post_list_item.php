<?php
// expected:
// $p, $label, $badgeClass (string), $liClass
// $showThumb (bool), $thumbWidth (int), $showSummary (bool)
// $postUrl(callable), $postImg(callable), $postDate(callable), $e(callable)

$liClass     = $liClass ?? '';
$label       = $label ?? '';
$badgeClass  = $badgeClass ?? 'bg_yellow';
$showThumb   = $showThumb ?? false;
$thumbWidth  = $thumbWidth ?? 70;
$showSummary = $showSummary ?? false;

$url  = isset($p)  ? post_url($p)  : '#';
$img  = isset($p)  ? post_img($p)  : '';
$date = isset($p) ? post_date($p) : '';
$title = isset($e) ? $e($p['title'] ?? '') : esc($p['title'] ?? '');
$summary = isset($e) ? $e($p['summary'] ?? '') : esc($p['summary'] ?? '');
?>


<li class="<?= esc($liClass) ?>">
    <?php if ($showThumb): ?>
        <span class="ps-3">
            <a href="<?= $url ?>"><img width="<?= (int)$thumbWidth ?>" alt="abc" src="<?= $img ?>"></a>
        </span>
        <span class="flex-column mx-3">
    <?php else: ?>
        <span class="d-block">
    <?php endif; ?>

        <b class="d-inline-block <?= esc($badgeClass) ?> text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">
            <?= esc($label) ?>
        </b>

        <b class="d-block font_15 text-uppercase mt-2 px-3">
            <a href="<?= $url ?>"><?= $title ?></a>
        </b>

        <span class="light_gray font_10 fw-bold text-uppercase px-3">
            <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc($date) ?>
        </span>

        <?php if ($showSummary): ?>
            <span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $summary ?></span>
        <?php endif; ?>

    </span>
</li>
