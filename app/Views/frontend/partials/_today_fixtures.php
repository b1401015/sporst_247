<?php
// =====================
// Helpers (self-contained)
// =====================
$tz = new DateTimeZone('Asia/Ho_Chi_Minh');

$fmtTime = function($unix) use ($tz){
    if (!$unix) return '--:--';
    $dt = new DateTime('@' . (int)$unix);
    $dt->setTimezone($tz);
    return $dt->format('H:i');
};

$fmtDate = function($unix) use ($tz){
    if (!$unix) return '--/--';
    $dt = new DateTime('@' . (int)$unix);
    $dt->setTimezone($tz);
    return $dt->format('d/m');
};

$statusType = function($short){
    $short = strtoupper((string)$short);
    if (in_array($short, ['FT','AET','PEN'], true)) return 'finished';
    if (in_array($short, ['1H','2H','HT','ET','P','BT'], true)) return 'live';
    return 'scheduled';
};

$minuteText = function(array $m){
    $elapsed = $m['fixture']['status']['elapsed'] ?? null;
    return $elapsed !== null ? ((int)$elapsed . "'") : 'LIVE';
};

$groupByLeague = function(array $matches): array {
    $groups = [];
    foreach ($matches as $m) {
        $lid   = $m['league']['id'] ?? null;
        $lname = $m['league']['name'] ?? 'Football';
        $key   = $lid ?: md5($lname);

        if (!isset($groups[$key])) {
            $groups[$key] = [
                'league' => $m['league'] ?? ['name' => $lname],
                'items'  => [],
            ];
        }
        $groups[$key]['items'][] = $m;
    }

    uasort($groups, function($a, $b){
        return strcmp(($a['league']['name'] ?? ''), ($b['league']['name'] ?? ''));
    });

    foreach ($groups as &$g) {
        usort($g['items'], function($x, $y){
            return ($x['fixture']['timestamp'] ?? 0) <=> ($y['fixture']['timestamp'] ?? 0);
        });
    }
    unset($g);

    return $groups;
};

// =====================
// Data
// =====================
$fixtures = array_slice($todayMatches ?? [], 0, 60);

$rawResults = array_merge($yesterdayResults ?? [], $todayResults ?? []);
$results = [];
foreach ($rawResults as $m) {
    if ($statusType($m['fixture']['status']['short'] ?? '') === 'finished') $results[] = $m;
}
$results = array_slice($results, 0, 60);

$fixturesGroups = $groupByLeague($fixtures);
$resultsGroups  = $groupByLeague($results);

// unique id để nhiều box trên 1 page vẫn chạy
$boxId = 'tt247_' . substr(md5(__FILE__ . microtime(true)), 0, 8);
?>

<div class="tt247-box" id="<?= esc($boxId) ?>">
  <div class="tt247-tabs">
    <button class="tt247-tab active" type="button" data-tttab="#tab-fixtures-<?= esc($boxId) ?>">LỊCH THI ĐẤU BÓNG ĐÁ</button>
    <button class="tt247-tab" type="button" data-tttab="#tab-results-<?= esc($boxId) ?>">KẾT QUẢ BÓNG ĐÁ</button>
    <a class="tt247-more" href="#">Xem thêm »</a>
  </div>

  <div class="tt247-body match-scroll">
    <!-- FIXTURES -->
    <div class="tt247-pane show" id="tab-fixtures-<?= esc($boxId) ?>">
      <?php if (empty($fixturesGroups)): ?>
        <div class="p-3">Hôm nay chưa có lịch thi đấu.</div>
      <?php else: ?>
        <?php foreach ($fixturesGroups as $g): ?>
          <?php
            $league = $g['league']['name'] ?? 'Football';
            $logo   = $g['league']['logo'] ?? '';
          ?>
          <div class="tt247-league">
            <?php if ($logo): ?><img src="<?= esc($logo) ?>" alt=""><?php endif; ?>
            <span><?= esc($league) ?></span>
          </div>

          <ul class="tt247-list">
            <?php foreach ($g['items'] as $idx => $m): ?>
              <?php
                $home = $m['teams']['home']['name'] ?? 'Home';
                $away = $m['teams']['away']['name'] ?? 'Away';
                $hl   = $m['teams']['home']['logo'] ?? '';
                $al   = $m['teams']['away']['logo'] ?? '';

                $ts   = $m['fixture']['timestamp'] ?? null;
                $dmy  = $fmtDate($ts);
                $time = $fmtTime($ts);

                $short = $m['fixture']['status']['short'] ?? '';
                $type  = $statusType($short);

                $fixtureId = $m['fixture']['id'] ?? null;
                $detailUrl = '#'; // $fixtureId ? site_url('match/' . $fixtureId) : '#';

                $rowClass = ($idx % 2 === 0) ? 'tt247-row alt' : 'tt247-row';
              ?>
              <li class="<?= $rowClass ?>">
                <div class="tt247-date"><?= esc($dmy) ?></div>

                <div class="tt247-team right">
                  <span class="name" title="<?= esc($home) ?>"><?= esc($home) ?></span>
                  <?php if ($hl): ?><img class="logo" src="<?= esc($hl) ?>" alt=""><?php endif; ?>
                </div>

                <div class="tt247-mid">
                  <?php if ($type === 'live'): ?>
                    <div class="kicky live"><?= esc($minuteText($m)) ?></div>
                    <?php
                      $hg = $m['goals']['home'] ?? null;
                      $ag = $m['goals']['away'] ?? null;
                      $liveScore = ($hg !== null || $ag !== null) ? (($hg ?? '-') . ' - ' . ($ag ?? '-')) : ' - ';
                    ?>
                    <div class="score"><?= esc($liveScore) ?></div>
                    <span class="badge mini red">LIVE</span>

                  <?php elseif ($type === 'scheduled'): ?>
                    <div class="kicky"><?= esc($time) ?></div>
                    <div class="score ghost"> </div>

                  <?php else: ?>
                    <div class="kicky"><?= esc($time) ?></div>
                    <div class="score ghost"> </div>
                    <span class="badge mini gray">FT</span>
                  <?php endif; ?>
                </div>

                <div class="tt247-team left">
                  <?php if ($al): ?><img class="logo" src="<?= esc($al) ?>" alt=""><?php endif; ?>
                  <span class="name" title="<?= esc($away) ?>"><?= esc($away) ?></span>
                </div>

                <a class="tt247-arrow" href="<?= esc($detailUrl) ?>" aria-label="Chi tiết">»</a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- RESULTS -->
    <div class="tt247-pane" id="tab-results-<?= esc($boxId) ?>">
      <?php if (empty($resultsGroups)): ?>
        <div class="p-3">Chưa có kết quả.</div>
      <?php else: ?>
        <?php foreach ($resultsGroups as $g): ?>
          <?php
            $league = $g['league']['name'] ?? 'Football';
            $logo   = $g['league']['logo'] ?? '';
          ?>
          <div class="tt247-league">
            <?php if ($logo): ?><img src="<?= esc($logo) ?>" alt=""><?php endif; ?>
            <span><?= esc($league) ?></span>
          </div>

          <ul class="tt247-list">
            <?php foreach ($g['items'] as $idx => $m): ?>
              <?php
                $home = $m['teams']['home']['name'] ?? 'Home';
                $away = $m['teams']['away']['name'] ?? 'Away';
                $hl   = $m['teams']['home']['logo'] ?? '';
                $al   = $m['teams']['away']['logo'] ?? '';

                $ts   = $m['fixture']['timestamp'] ?? null;
                $dmy  = $fmtDate($ts);
                $time = $fmtTime($ts);

                $hg = $m['goals']['home'] ?? 0;
                $ag = $m['goals']['away'] ?? 0;
                $score = $hg . ' - ' . $ag;

                $fixtureId = $m['fixture']['id'] ?? null;
                $detailUrl = '#'; // $fixtureId ? site_url('match/' . $fixtureId) : '#';

                $rowClass = ($idx % 2 === 0) ? 'tt247-row alt' : 'tt247-row';
              ?>
              <li class="<?= $rowClass ?>">
                <div class="tt247-date"><?= esc($dmy) ?></div>

                <div class="tt247-team right">
                  <span class="name" title="<?= esc($home) ?>"><?= esc($home) ?></span>
                  <?php if ($hl): ?><img class="logo" src="<?= esc($hl) ?>" alt=""><?php endif; ?>
                </div>

                <div class="tt247-mid">
                  <div class="kicky"><?= esc($time) ?></div>
                  <div class="score"><?= esc($score) ?></div>
                  <span class="badge mini gray">FT</span>
                </div>

                <div class="tt247-team left">
                  <?php if ($al): ?><img class="logo" src="<?= esc($al) ?>" alt=""><?php endif; ?>
                  <span class="name" title="<?= esc($away) ?>"><?= esc($away) ?></span>
                </div>

                <a class="tt247-arrow" href="<?= esc($detailUrl) ?>" aria-label="Chi tiết">»</a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.tt247-box').forEach(function(box){
    const tabs  = box.querySelectorAll('.tt247-tab');
    const panes = box.querySelectorAll('.tt247-pane');

    tabs.forEach(function(btn){
      btn.addEventListener('click', function(){
        tabs.forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        panes.forEach(p => p.classList.remove('show'));

        const target = btn.getAttribute('data-tttab');
        const pane = box.querySelector(target);
        if (pane) pane.classList.add('show');
      });
    });
  });
});
</script>

<style>
/* ===== container ===== */
.tt247-box{
  border: 1px solid #d9d9ee;
  background: #fff;
  border-radius: 12px;           /* bo góc */
  box-shadow: 0 6px 16px rgba(0,0,0,.06); /* shadow nhẹ */
  overflow: hidden;              /* cắt viền gọn */
}

/* ===== tabs ===== */
.tt247-tabs{
  display:flex;
  align-items:center;
  gap:10px;
  padding: 12px 12px 0 12px;
  background: #fff;
  border-bottom: 1px solid #eef0ff;
}
.tt247-tab{
  border: 1px solid #e3e6ff;
  background: #f7f9ff;
  padding: 10px 14px;
  font-weight: 900;
  font-size: 13px;
  text-transform: uppercase;
  border-radius: 999px; /* pill */
  cursor:pointer;
  color:#1f2a44;
}
.tt247-tab.active{
  background:#ffffff;
  border-color:#cfd6ff;
  box-shadow: 0 3px 10px rgba(0,0,0,.05);
}
.tt247-more{
  margin-left:auto;
  font-weight:800;
  font-size:12px;
  text-decoration:none;
  padding: 10px 0 12px 0;
}

/* ===== scroll ===== */
.match-scroll{
  max-height: 420px;
  overflow-y: auto;
  overflow-x: hidden;
}
.match-scroll::-webkit-scrollbar { width: 6px; }
.match-scroll::-webkit-scrollbar-thumb { background: #cfcfcf; border-radius: 8px; }
.match-scroll::-webkit-scrollbar-track { background: transparent; }

/* ===== panes ===== */
.tt247-pane{ display:none; }
.tt247-pane.show{ display:block; }

/* ===== league header ===== */
.tt247-league{
  display:flex;
  align-items:center;
  gap:8px;
  padding: 10px 12px;
  font-weight:900;
  font-size:12px;
  text-transform: uppercase;
  color:#2c2c55;
  border-top: 1px solid #eef0ff;
  border-bottom: 1px solid #eef0ff;
  background: #ffffff;
}
.tt247-league img{
  width:16px;height:16px;object-fit:contain;
}

/* ===== list + rows ===== */
.tt247-list{ list-style:none; margin:0; padding:0; }
.tt247-row{
  display:grid;
  grid-template-columns: 56px 1fr 90px 1fr 28px;
  align-items:center;
  padding: 12px 12px;
  border-bottom: 1px solid #eef0ff;
}
.tt247-row.alt{ background:#eef6ff; } /* xanh nhạt xen kẽ */
.tt247-date{
  font-weight:800;
  color:#111827;
  font-size:12px;
}

/* ===== teams ===== */
.tt247-team{
  display:flex;
  align-items:center;
  gap:8px;
  min-width:0;
}
.tt247-team.right{ justify-content:flex-end; }
.tt247-team.left{ justify-content:flex-start; }
.tt247-team .name{
  font-weight:900;
  font-size:13px;
  text-transform: uppercase;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  max-width: 100%;
}
.tt247-team .logo{ width:18px;height:18px;object-fit:contain; }

/* ===== middle ===== */
.tt247-mid{
  text-align:center;
  line-height:1.1;
}
.kicky{
  font-weight:900;
  color:#1d4ed8;
  font-size:14px;
}
.kicky.live{ color:#dc2626; }
.score{
  font-weight:900;
  font-size:14px;
  color:#111;
  min-height: 16px;
}
.score.ghost{ color:transparent; }

/* ===== badges ===== */
.badge.mini{
  display:inline-block;
  margin-top:4px;
  padding: 2px 6px;
  border-radius:6px;
  font-size:10px;
  font-weight:900;
  color:#fff;
}
.badge.mini.gray{ background:#6b7280; }
.badge.mini.red{ background:#dc2626; }

/* ===== arrow ===== */
.tt247-arrow{
  text-decoration:none;
  font-weight:900;
  color:#1d4ed8;
  text-align:right;
  font-size:18px;
  line-height:1;
}
.tt247-arrow:hover{ color:#0b2ea8; }

/* ===== responsive ===== */
@media (max-width: 575.98px){
  .tt247-row{
    grid-template-columns: 44px 1fr 78px 1fr 22px;
    padding: 12px 10px;
  }
  .tt247-tab{ font-size:12px; padding:9px 12px; }
  .tt247-team .name{ font-size:12px; }
  .kicky,.score{ font-size:13px; }
}
</style>
