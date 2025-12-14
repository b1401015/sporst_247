<?php

namespace Config;

use CodeIgniter\Database\Config as BaseConfig;

class Database extends BaseConfig
{
    /**
     * Danh sách file cấu hình DB bổ sung (không dùng trong demo này).
     *
     * @var list<string>
     */
    public array $files = [];

    /**
     * Nhóm kết nối mặc định.
     */
    public string $defaultGroup = 'default';

    /**
     * Kết nối DB chính.
     *
     * Lưu ý: bạn cần chỉnh lại username/password/database cho đúng môi trường.
     */
    public array $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'sport_247_1',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_unicode_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    /**
     * Cấu hình DB cho môi trường test (không bắt buộc dùng).
     */
    public array $tests = [
        'DSN'      => '',
        'hostname' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'database' => 'sportnews_ci4_demo_test',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => 'test_',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_unicode_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    /**
     * Lưu query để debug.
     */
    public bool $saveQueries = true;
}
