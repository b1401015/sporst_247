<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Libraries\RssImporter;

class RssImport extends BaseCommand
{
    protected $group       = 'Cron';
    protected $name        = 'rss:import';
    protected $description = 'Import RSS feeds into posts table';

    public function run(array $params)
    {
        // bạn có thể chuyển sang file config để dễ quản lý
        $feeds = [
            [
                'url' => 'https://thanhnien.vn/rss/the-thao.rss',
                'source_name' => 'thanhnien',
                'default_category_id' => 1,
            ],
            // [
            //     'url' => 'https://vnexpress.net/rss/the-thao.rss',
            //     'source_name' => 'vnexpress',
            //     'default_category_id' => 1,
            // ],
            // thêm feed khác ở đây...
        ];

        $importer = new RssImporter();
        $totalInserted = 0;
        $totalSkipped  = 0;

        foreach ($feeds as $f) {
            CLI::write("Feed: {$f['source_name']} | {$f['url']}", 'yellow');

            $result = $importer->import($f['url'], [
                'source_name' => $f['source_name'],
                'default_category_id' => $f['default_category_id'],
                'created_by' => 1,
                'status' => 'published',
                'limit' => 20,
                'slug_suffix' => 'auto', // auto => dùng ID; hash => dùng hash(link)
                'content_mode' => 'link',
            ]);

            if (!$result['ok']) {
                CLI::error("Error: {$result['error']}");
                continue;
            }

            CLI::write("Inserted={$result['inserted']} Skipped={$result['skipped']}", 'green');

            $totalInserted += $result['inserted'];
            $totalSkipped  += $result['skipped'];
        }

        CLI::write("DONE. Total Inserted={$totalInserted}, Total Skipped={$totalSkipped}", 'cyan');
    }
}
