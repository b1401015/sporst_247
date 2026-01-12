<?php

namespace App\Libraries;

use App\Models\PostModel;

class RssImporter
{
    public function import(string $feedUrl, array $options = []): array
    {
        $opts = array_merge([
            'source_name'         => 'rss',
            'default_category_id' => 1,
            'created_by'          => 1,
            'status'              => 'published',
            'limit'               => 20,
            'slug_suffix'         => 'auto', // auto => id | hash => shortHash(link)
            'content_mode'        => 'link', // link | empty | summary
        ], $options);

        $xmlString = $this->httpGet($feedUrl);
        if (!$xmlString) {
            return ['ok' => false, 'inserted' => 0, 'skipped' => 0, 'error' => 'fetch_failed'];
        }

        $items = $this->parseRss($xmlString);
        if (empty($items)) {
            return ['ok' => true, 'inserted' => 0, 'skipped' => 0, 'error' => null];
        }

        $items = array_slice($items, 0, (int)$opts['limit']);
        $postModel = new PostModel();

        $inserted = 0;
        $skipped  = 0;

        $hasSourceUrl  = $this->hasColumn($postModel->table, 'source_url');
        $hasSourceName = $this->hasColumn($postModel->table, 'source_name');

        foreach ($items as $it) {
            $title = trim($it['title'] ?? '');
            $link  = trim($it['link'] ?? '');
            $desc  = $it['description'] ?? '';
            $pub   = $it['pubDate'] ?? null;

            if ($title === '' || $link === '') { $skipped++; continue; }

            // chống trùng theo source_url nếu có
            if ($hasSourceUrl && $postModel->where('source_url', $link)->first()) {
                $skipped++; continue;
            }

            [$thumbnail, $summaryText] = $this->extractThumbAndText($desc);
            $publishedAt = $pub ? $this->toMySqlDatetime($pub) : date('Y-m-d H:i:s');

            $baseSlug = $this->slugify($title);

            // slug tạm để insert lấy id (tránh UNIQUE đụng nhau)
            $tempSlug = $baseSlug . '-' . time() . '-tmp';

            $data = [
                'category_id'  => (int)$opts['default_category_id'],
                'title'        => $title,
                'slug'         => $tempSlug,
                'summary'      => $summaryText,
                'content'      => $this->buildContent($opts['content_mode'], $link, $summaryText),
                'thumbnail'    => $thumbnail,
                'status'       => $opts['status'],
                'is_featured'  => 0,
                'is_hot'       => 0,
                'view_count'   => 0,
                'published_at' => $publishedAt,
                'created_by'   => (int)$opts['created_by'],
            ];

            if ($hasSourceUrl)  $data['source_url']  = $link;
            if ($hasSourceName) $data['source_name'] = $opts['source_name'];

            try {
                $newId = $postModel->insert($data, true);
                if (!$newId) { $skipped++; continue; }

                $suffix = ($opts['slug_suffix'] === 'hash')
                    ? $this->shortHash($link)
                    : (string)$newId;

                // slug cuối cùng: baseSlug-id (id ở cuối)
                $finalSlug = $baseSlug . '-' . $suffix;
                $postModel->update($newId, ['slug' => $finalSlug]);

                $inserted++;
            } catch (\Throwable $e) {
                $skipped++;
            }
        }

        return ['ok' => true, 'inserted' => $inserted, 'skipped' => $skipped, 'error' => null];
    }

    private function buildContent(string $mode, string $link, string $summary): string
    {
        if ($mode === 'empty') return '';
        if ($mode === 'summary') {
            return '<p>' . esc($summary) . '</p><p><a href="'.esc($link).'" target="_blank" rel="nofollow noopener">Đọc bài gốc</a></p>';
        }
        return '<p><a href="'.esc($link).'" target="_blank" rel="nofollow noopener">Đọc bài gốc</a></p>';
    }

    private function httpGet(string $url): ?string
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT => 'SportNewsCI4Bot/1.0 (+rss import)',
        ]);
        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($res === false || $code >= 400) return null;
        return $res;
    }

    private function parseRss(string $xmlString): array
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!$xml || empty($xml->channel->item)) return [];

        $items = [];
        foreach ($xml->channel->item as $item) {
            $items[] = [
                'title'       => (string)$item->title,
                'link'        => (string)$item->link,
                'pubDate'     => (string)$item->pubDate,
                'description' => (string)$item->description,
            ];
        }
        return $items;
    }

    private function extractThumbAndText(string $descHtml): array
    {
        $thumb = null;
        if (preg_match('/<img[^>]+src="([^"]+)"/i', $descHtml, $m)) $thumb = $m[1];

        $text = trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode($descHtml, ENT_QUOTES|ENT_HTML5, 'UTF-8'))));
        if (mb_strlen($text) > 300) $text = mb_substr($text, 0, 300) . '...';

        return [$thumb, $text];
    }

    private function toMySqlDatetime(string $rssPubDate): string
    {
        $ts = strtotime($rssPubDate);
        if (!$ts) $ts = time();
        return date('Y-m-d H:i:s', $ts);
    }

    private function slugify(string $text): string
    {
        $text = mb_strtolower(trim($text), 'UTF-8');
        $map = [
            'à'=>'a','á'=>'a','ạ'=>'a','ả'=>'a','ã'=>'a','â'=>'a','ầ'=>'a','ấ'=>'a','ậ'=>'a','ẩ'=>'a','ẫ'=>'a','ă'=>'a','ằ'=>'a','ắ'=>'a','ặ'=>'a','ẳ'=>'a','ẵ'=>'a',
            'è'=>'e','é'=>'e','ẹ'=>'e','ẻ'=>'e','ẽ'=>'e','ê'=>'e','ề'=>'e','ế'=>'e','ệ'=>'e','ể'=>'e','ễ'=>'e',
            'ì'=>'i','í'=>'i','ị'=>'i','ỉ'=>'i','ĩ'=>'i',
            'ò'=>'o','ó'=>'o','ọ'=>'o','ỏ'=>'o','õ'=>'o','ô'=>'o','ồ'=>'o','ố'=>'o','ộ'=>'o','ổ'=>'o','ỗ'=>'o','ơ'=>'o','ờ'=>'o','ớ'=>'o','ợ'=>'o','ở'=>'o','ỡ'=>'o',
            'ù'=>'u','ú'=>'u','ụ'=>'u','ủ'=>'u','ũ'=>'u','ư'=>'u','ừ'=>'u','ứ'=>'u','ự'=>'u','ử'=>'u','ữ'=>'u',
            'ỳ'=>'y','ý'=>'y','ỵ'=>'y','ỷ'=>'y','ỹ'=>'y',
            'đ'=>'d'
        ];
        $text = strtr($text, $map);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-') ?: ('post-' . time());
    }

    private function shortHash(string $input): string
    {
        return substr(sha1($input), 0, 8);
    }

    private function hasColumn(string $table, string $column): bool
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames($table);
        return in_array($column, $fields, true);
    }
}
