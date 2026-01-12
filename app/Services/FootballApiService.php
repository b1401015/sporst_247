<?php

namespace App\Services;

class FootballApiService
{
    private string $baseUrl = 'https://v3.football.api-sports.io';
    private string $apiKey  = 'cdbb27544372f16c1d665ddec2d2dd11'; // đổi sang key thật

    /**
     * Lấy lịch thi đấu hôm nay (1 ngày gọi 1 lần)
     */
    public function todaysMatches(): array
    {
        $today    = date('Y-m-d');
        $cacheKey = 'af_today_matches_' . $today;

        $cached = cache($cacheKey);
       // print_r(json_encode($cached));die;
        if (is_array($cached)) {
            return $cached;
        }

        if (!$this->apiKey) {
            return [];
        }

        $url = $this->baseUrl . '/fixtures';

        $client = service('curlrequest', [
            'timeout'     => 15,
            'http_errors' => false,
        ]);

        $res = $client->get($url, [
            'headers' => [
                'x-apisports-key' => $this->apiKey,
            ],
            'query' => [
                'date'     => $today,
                'timezone' => 'Asia/Ho_Chi_Minh',
            ],
        ]);

        if ($res->getStatusCode() !== 200) {
            return [];
        }

        $json = json_decode($res->getBody(), true);
        //print_r($json);die;

        // API-Football trả dữ liệu trong "response"
        $data = $json['response'] ?? [];

        // cache 24 tiếng (1 ngày)
        cache()->save($cacheKey, $data, 86400);

        return $data;
    }
}
