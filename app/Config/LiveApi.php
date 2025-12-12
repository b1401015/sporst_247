<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class LiveApi extends BaseConfig
{
    public bool $enabled = false; // bật true nếu bạn cấu hình API thật
    public string $baseUrl = 'https://example-livescore-api.com'; // TODO: thay bằng API thật
    public string $apiKey  = 'YOUR_API_KEY_HERE';
}
