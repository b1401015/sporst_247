<?php
$matches = $todayMatches ?? [];
$matches = array_slice($matches, 0, 12);

$fmtTime = function($unix){
    if (!$unix) return '--:--';
    $dt = new DateTime('@' . (int)$unix);
    $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
    return $dt->format('H:i');
};

$normalizeStatus = function($short){
    $short = strtoupper((string)$short);
    if (in_array($short, ['FT','AET','PEN'], true)) return 'finished';
    if (in_array($short, ['1H','2H','HT','ET','P','BT'], true)) return 'live';
    return 'scheduled';
};
?>

<div class="news_1_left1 p-3 bg-white border_thick mt-3">
  <div class="news_1_left1_inner row align-items-center">
    <div class="col-7 col-sm-6">
      <div class="news_1_left1_inner_left pt-1">
        <b class="d-block text-uppercase">Lịch thi đấu bóng đá</b>
      </div>
    </div>
    <div class="col-5 col-sm-6 text-end">
      <a class="text-decoration-none font_11 fw-bold" href="#">Xem thêm »</a>
    </div>
  </div>
</div>

<div class="bg-white border_light">
  <ul class="mb-0 list-unstyled">
    <?php if (empty($matches)): ?>
      <li class="p-3">Hôm nay chưa có lịch thi đấu.</li>
    <?php else: ?>
      <?php foreach ($matches as $i => $m): ?>
        <?php
          $league     = $m['league']['name'] ?? 'Football';
          $leagueLogo = $m['league']['logo'] ?? '';

          $home     = $m['teams']['home']['name'] ?? 'Home';
          $homeLogo = $m['teams']['home']['logo'] ?? '';

          $away     = $m['teams']['away']['name'] ?? 'Away';
          $awayLogo = $m['teams']['away']['logo'] ?? '';

          $kickoff  = $m['fixture']['timestamp'] ?? null;
          $timeText = $fmtTime($kickoff);

          $statusShort = $m['fixture']['status']['short'] ?? '';
          $status      = $normalizeStatus($statusShort);

          $hg = $m['goals']['home'] ?? null;
          $ag = $m['goals']['away'] ?? null;

          $scoreText = ($hg !== null || $ag !== null) ? trim(($hg ?? '-') . ' - ' . ($ag ?? '-')) : '';

          $fixtureId = $m['fixture']['id'] ?? null;
          $detailUrl = '#'; // $fixtureId ? site_url('match/' . $fixtureId) : '#';
        ?>

        <li class="<?= $i < count($matches)-1 ? 'border-bottom' : '' ?>">
          <div class="px-3 py-2" style="min-width:0;">

            <!-- TOP: League line (luôn hiện) -->
            <div class="d-flex align-items-center justify-content-between gap-2">
              <div class="d-flex align-items-center gap-2" style="min-width:0;">
                <?php if ($leagueLogo): ?>
                  <img src="<?= esc($leagueLogo) ?>" alt="" style="width:16px;height:16px;object-fit:contain;">
                <?php endif; ?>
                <span class="font_11 text-uppercase light_gray"
                      style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width: 70vw;"
                      title="<?= esc($league) ?>">
                  <?= esc($league) ?>
                </span>
              </div>

              <div class="flex-shrink-0">
                <a href="<?= esc($detailUrl) ?>" class="text-decoration-none">»</a>
              </div>
            </div>

            <!-- DESKTOP (>=576px): 3 cột đẹp -->
            <div class="match-desktop mt-1" style="min-width:0;">
              <div style="
                display:grid;
                grid-template-columns: 1fr 90px 1fr;
                align-items:center;
                column-gap:10px;
                min-width:0;
              ">
                <!-- Home -->
                <div class="d-flex align-items-center justify-content-end gap-2" style="min-width:0;">
                  <span class="fw-bold text-uppercase"
                        style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; min-width:0;"
                        title="<?= esc($home) ?>">
                    <?= esc($home) ?>
                  </span>
                  <?php if ($homeLogo): ?>
                    <img src="<?= esc($homeLogo) ?>" alt="" style="width:18px;height:18px;object-fit:contain;">
                  <?php endif; ?>
                </div>

                <!-- Center (giờ / tỉ số / FT xuống dưới) -->
                <div class="text-center" style="line-height:1.15;">
                  <div class="fw-bold text-primary" style="font-size:14px;">
                    <?= esc($timeText) ?>
                  </div>

                  <?php if ($scoreText): ?>
                    <div class="fw-bold" style="font-size:14px;">
                      <?= esc($scoreText) ?>
                    </div>

                    <?php if ($status === 'finished'): ?>
                      <div><span class="badge bg-secondary" style="font-size:10px;">FT</span></div>
                    <?php elseif ($status === 'live'): ?>
                      <div><span class="badge bg-danger" style="font-size:10px;">LIVE</span></div>
                    <?php else: ?>
                      <div style="height:14px;"></div>
                    <?php endif; ?>

                  <?php else: ?>
                    <div style="height:32px;"></div>
                  <?php endif; ?>
                </div>

                <!-- Away -->
                <div class="d-flex align-items-center justify-content-start gap-2" style="min-width:0;">
                  <?php if ($awayLogo): ?>
                    <img src="<?= esc($awayLogo) ?>" alt="" style="width:18px;height:18px;object-fit:contain;">
                  <?php endif; ?>
                  <span class="fw-bold text-uppercase"
                        style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; min-width:0;"
                        title="<?= esc($away) ?>">
                    <?= esc($away) ?>
                  </span>
                </div>
              </div>
            </div>

            <!-- MOBILE (<576px): 1 hàng có TÊN CLB rõ ràng -->
            <div class="match-mobile mt-2" style="min-width:0;">
              <div style="
                display:grid;
                grid-template-columns: 1fr 80px 1fr;
                align-items:center;
                column-gap:8px;
                min-width:0;
              ">
                <!-- Home -->
                <div class="d-flex align-items-center gap-2" style="min-width:0;">
                  <?php if ($homeLogo): ?>
                    <img src="<?= esc($homeLogo) ?>" alt="" style="width:18px;height:18px;object-fit:contain;">
                  <?php endif; ?>
                  <span class="fw-bold"
                        style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; min-width:0;"
                        title="<?= esc($home) ?>">
                    <?= esc($home) ?>
                  </span>
                </div>

                <!-- Center -->
                <div class="text-center" style="line-height:1.1;">
                  <div class="fw-bold text-primary" style="font-size:13px;">
                    <?= esc($timeText) ?>
                  </div>
                  <div class="fw-bold" style="font-size:13px; min-height:16px;">
                    <?= $scoreText ? esc($scoreText) : '&nbsp;' ?>
                  </div>
                  <?php if ($scoreText): ?>
                    <?php if ($status === 'finished'): ?>
                      <div><span class="badge bg-secondary" style="font-size:10px;">FT</span></div>
                    <?php elseif ($status === 'live'): ?>
                      <div><span class="badge bg-danger" style="font-size:10px;">LIVE</span></div>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>

                <!-- Away -->
                <div class="d-flex align-items-center gap-2 justify-content-end" style="min-width:0;">
                  <span class="fw-bold"
                        style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; min-width:0;"
                        title="<?= esc($away) ?>">
                    <?= esc($away) ?>
                  </span>
                  <?php if ($awayLogo): ?>
                    <img src="<?= esc($awayLogo) ?>" alt="" style="width:18px;height:18px;object-fit:contain;">
                  <?php endif; ?>
                </div>
              </div>
            </div>

          </div>
        </li>

      <?php endforeach; ?>
    <?php endif; ?>
  </ul>
</div>

<style>
  /* mặc định: hiện desktop, ẩn mobile */
  .match-mobile { display:none; }
  .match-desktop { display:block; }

  /* mobile: ẩn desktop, hiện mobile */
  @media (max-width: 575.98px){
    .match-desktop { display:none; }
    .match-mobile  { display:block; }
  }
</style>
