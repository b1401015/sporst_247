<?php
$matches = $todayMatches ?? [];
$matches = array_slice($matches, 0, 12);

// Format giờ theo Asia/Ho_Chi_Minh (tránh lệch timezone server)
$fmtTime = function($unix){
    if (!$unix) return '--:--';
    $dt = new DateTime('@' . (int)$unix); // epoch seconds
    $dt->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
    return $dt->format('H:i');
};

// Chuẩn hoá status
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
          // Data từ API-Football
          $league     = $m['league']['name'] ?? 'Football';
          $leagueLogo = $m['league']['logo'] ?? '';

          $home     = $m['teams']['home']['name'] ?? 'Home';
          $homeLogo = $m['teams']['home']['logo'] ?? '';

          $away     = $m['teams']['away']['name'] ?? 'Away';
          $awayLogo = $m['teams']['away']['logo'] ?? '';

          $kickoff = $m['fixture']['timestamp'] ?? null;
          $time    = $fmtTime($kickoff);

          $statusShort = $m['fixture']['status']['short'] ?? '';
          $status      = $normalizeStatus($statusShort);

          $hg = $m['goals']['home'] ?? null;
          $ag = $m['goals']['away'] ?? null;

          // Center text: luôn hiện giờ; nếu có tỉ số thì kèm
          $score = trim(($hg ?? '-') . ' - ' . ($ag ?? '-'));
          $centerText = ($hg !== null || $ag !== null) ? ($time . ' • ' . $score) : $time;

          // Badge trạng thái
          $badge = '';
          if ($status === 'live')     $badge = '<span class="badge bg-danger ms-2" style="font-size:10px;">LIVE</span>';
          if ($status === 'finished') $badge = '<span class="badge bg-secondary ms-2" style="font-size:10px;">FT</span>';

          $fixtureId = $m['fixture']['id'] ?? null;
          $detailUrl = '#'; // $fixtureId ? site_url('match/' . $fixtureId) : '#';
        ?>

        <li class="px-3 py-2 <?= $i < count($matches)-1 ? 'border-bottom' : '' ?>">
          <!-- Responsive wrapper: mobile dọc, desktop ngang -->
          <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">

            <!-- League (desktop cố định 170px; mobile full) -->
            <div class="d-flex align-items-center gap-2 flex-shrink-0"
                 style="min-width:170px;max-width:170px;">
              <?php if ($leagueLogo): ?>
                <img src="<?= esc($leagueLogo) ?>" alt="" style="width:16px;height:16px;object-fit:contain;">
              <?php endif; ?>
              <span class="font_11 text-uppercase light_gray text-truncate" title="<?= esc($league) ?>">
                <?= esc($league) ?>
              </span>
            </div>

            <!-- Match row -->
            <div class="flex-grow-1 w-100">
              <!-- mobile: xếp cột | từ sm: 1 hàng -->
              <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-center gap-2">

                <!-- Home -->
                <div class="d-flex align-items-center justify-content-between justify-content-sm-end gap-2"
                     style="min-width:0; flex: 1 1 240px;">
                  <span class="fw-bold text-uppercase text-truncate" style="min-width:0;" title="<?= esc($home) ?>">
                    <?= esc($home) ?>
                  </span>
                  <?php if ($homeLogo): ?>
                    <img src="<?= esc($homeLogo) ?>" alt="" style="width:18px;height:18px;object-fit:contain;">
                  <?php endif; ?>
                </div>

                <!-- Center time/score -->
                <div class="text-center flex-shrink-0" style="min-width:130px;">
                  <span class="fw-bold text-primary"><?= esc($centerText) ?></span>
                  <?= $badge ?>
                </div>

                <!-- Away -->
                <div class="d-flex align-items-center justify-content-between justify-content-sm-start gap-2"
                     style="min-width:0; flex: 1 1 240px;">
                  <?php if ($awayLogo): ?>
                    <img src="<?= esc($awayLogo) ?>" alt="" style="width:18px;height:18px;object-fit:contain;">
                  <?php endif; ?>
                  <span class="fw-bold text-uppercase text-truncate" style="min-width:0;" title="<?= esc($away) ?>">
                    <?= esc($away) ?>
                  </span>
                </div>

              </div>
            </div>

            <!-- Detail -->
            <div class="text-end flex-shrink-0 align-self-end align-self-md-center" style="min-width:30px;">
              <a href="<?= esc($detailUrl) ?>" class="text-decoration-none">»</a>
            </div>

          </div>
        </li>

      <?php endforeach; ?>
    <?php endif; ?>
  </ul>
</div>
