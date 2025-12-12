<?php

use App\Models\LeagueModel;
use App\Libraries\LeagueTableService;

if (! function_exists('standings_widget')) {
    /**
     * Widget BXH nhúng sidebar.
     *
     * @param string $leagueSlug slug của giải (vd: premier-league)
     * @param int    $limit số đội hiển thị
     */
    function standings_widget(string $leagueSlug, int $limit = 5)
    {
        $leagueM = new LeagueModel();
        $league  = $leagueM->where('slug', $leagueSlug)->first();
        if (! $league) {
            echo '<!-- standings_widget: league not found -->';
            return;
        }

        $service = new LeagueTableService();
        $rows    = $service->getFullTable((int)$league['id']);
        if (! $rows) {
            echo '<!-- standings_widget: no data -->';
            return;
        }

        $rows = array_slice($rows, 0, $limit);

        echo '<div class="card mb-3">';
        echo '<div class="card-header bg-danger text-white">BXH '.htmlspecialchars($league['name']).'</div>';
        echo '<table class="table table-sm mb-0"><tbody>';
        $i = 1;
        foreach ($rows as $r) {
            echo '<tr>';
            echo '<td class="small">'.$i++.'</td>';
            echo '<td class="small">';
            if (!empty($r['logo'])) {
                echo '<img src="'.htmlspecialchars($r['logo']).'" alt="" style="height:18px" loading="lazy" class="me-1">';
            }
            echo htmlspecialchars($r['name']).'</td>';
            echo '<td class="small text-end">'.$r['points'].'</td>';
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    }
}
