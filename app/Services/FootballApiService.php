<?php

namespace App\Services;

class FootballApiService
{
    private string $baseUrl = 'https://v3.football.api-sports.io';
    private string $apiKey  = FOOTBALL_API_KEY;

    private function request(string $path, array $query, int $ttl = 900): array
    {
        if (!$this->apiKey) return [];

        $cacheKey = 'af_' . md5($path . '|' . json_encode($query));
        $cached   = cache($cacheKey);
        if (is_array($cached)) return $cached;

        $client = service('curlrequest', [
            'timeout'     => 15,
            'http_errors' => false,
        ]);

        $res = $client->get($this->baseUrl . $path, [
            'headers' => ['x-apisports-key' => $this->apiKey],
            'query'   => $query,
        ]);

        if ($res->getStatusCode() !== 200) return [];

        $json = json_decode($res->getBody(), true);
        $data = $json['response'] ?? [];

        cache()->save($cacheKey, $data, $ttl);
        return $data;
    }

    public function fixturesByDate(string $date, string $tz = 'Asia/Ho_Chi_Minh'): array
    {
        // fixtures thay đổi liên tục -> cache 5-15 phút là hợp lý (đừng 86400)
        return $this->request('/fixtures', [
            'date'     => $date,
            'timezone' => $tz,
        ], 900);
    }

    public function todaysMatches(): array
    {
        return $this->fixturesByDate(date('Y-m-d'));
    }

    public function todaysResults(): array
    {
        // Kết quả thường là hôm nay + có thể có trận đã FT
        // API-Football không có filter "only finished" theo date đơn giản bằng 1 param,
        // nên lấy theo date rồi lọc status ở view/controller.
        return $this->fixturesByDate(date('Y-m-d'));
    }

    public function yesterdayResults(): array
    {
        return $this->fixturesByDate(date('Y-m-d', strtotime('-1 day')));
    }
}
