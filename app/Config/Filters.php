<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'    => \CodeIgniter\Filters\CSRF::class,
        'toolbar' => \CodeIgniter\Filters\DebugToolbar::class,
        'auth'    => \App\Filters\AuthFilter::class,
    ];

    public $globals = [
        'before' => [
            // Bật CSRF nhưng loại trừ API để Postman/curl gọi được
            'csrf' => [
                'except' => [
                    'api/*',
                ],
            ],
        ],
        'after'  => [
            'toolbar',
        ],
    ];

    public $methods = [];

    public $filters = [
        'auth' => [
            'before' => [
                'admin',
                'admin/*',
            ],
        ],
    ];
}
