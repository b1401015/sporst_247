<?php
/**
 * Params:
 * - $carouselId (string) carousel id
 * - $posts (array)
 * - $badgeText (string) label trên badge
 * - $badgeClass (string) class bg_yellow/bg_orange/bg_violet
 * - $showCategory (bool) có hiển thị category_name không (vd trending/latest đang show)
 * - $postUrl, $postImg, $postDate, $clean (callables)
 */
?>

<?php if (!empty($posts)): ?>
<div id="<?= esc($carouselId) ?>" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <?php foreach ($posts as $i => $p): ?>
      <button type="button"
        data-bs-target="#<?= esc($carouselId) ?>"
        data-bs-slide-to="<?= $i ?>"
        class="<?= $i === 0 ? 'active' : '' ?>"
        aria-label="Slide <?= $i + 1 ?>"></button>
    <?php endforeach; ?>
  </div>

  <div class="carousel-inner">

    <?php foreach ($posts as $i => $p): ?>
    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
      <div class="news_1_left2_inner position-relative">
        <div class="news_1_left2_inner1">
          <a href="<?= post_url($p) ?>">
            <img src="<?= post_img($p) ?>" class="img-fluid" alt="<?= $clean($p['title'] ?? '') ?>">
          </a>
        </div>

        <div class="news_1_left2_inner2 position-absolute bottom-0 px-4 bg_back w-100 h-100 top-0">
          <ul class="mb-0">
            <li class="d-flex">
              <span class="flex-column">
                <b class="d-inline-block <?= esc($badgeClass) ?> text-white p-1 px-3 font_10 text-uppercase rounded-1">
                  <?php if (!empty($showCategory)): ?>
                    <?= $clean($p['category_name'] ?? $badgeText) ?>
                  <?php else: ?>
                    <?= esc($badgeText) ?>
                  <?php endif; ?>
                </b>

                <b class="d-block fs-2 text-uppercase mt-2 mb-2">
                  <a class="text-white" href="<?= post_url($p) ?>"><?= $clean($p['title'] ?? '') ?></a>
                </b>

                <span class="text-light font_11 fw-bold text-uppercase">
                  <?php if (!empty($showCategory) && !empty($p['category_name'])): ?>
                    <?= $clean($p['category_name']) ?> - <?= post_date($p) ?>
                  <?php else: ?>
                    <?= post_date($p) ?>
                  <?php endif; ?>
                </span>
              </span>
            </li>
          </ul>
        </div>

      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<?php else: ?>
  <div class="p-4 bg-white border_light">Chưa có dữ liệu.</div>
<?php endif; ?>
