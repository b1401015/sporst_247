<?php

namespace App\Libraries;

use Config\LiveApi;
use App\Models\MatchModel;

class LiveApiClient
{
    protected $config;
    protected $matchModel;

    public function __construct()
    {
        $this->config     = new LiveApi();
        $this->matchModel = new MatchModel();
    }

    /**
     * Ví dụ skeleton: đồng bộ tỉ số live từ API ngoài.
     * Bạn cần chỉnh lại endpoint & mapping tuỳ theo API thật.
     */
    public function syncToday()
    {
        if (! $this->config->enabled) {
            return;
        }

        $url = $this->config->baseUrl . '/today?key=' . urlencode($this->config->apiKey);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);

        if (! $resp) return;

        $data = json_decode($resp, true);
        if (!is_array($data)) return;

        // TODO: map structure $data với bảng matches của bạn
        // Ví dụ:
        /*
        foreach ($data['matches'] as $m) {
            // tìm match theo league + home + away + kickoff
            // rồi update status, home_score, away_score
        }
        */
    }
}
