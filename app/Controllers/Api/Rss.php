<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\RssImporter;

class Rss extends BaseController
{
    public function import()
    {
        // POST params (optional)
        $url = trim((string)($this->request->getPost('url') ?? ''));
        if ($url === '') $url = 'https://thanhnien.vn/rss/the-thao.rss';

        $sourceName = trim((string)($this->request->getPost('source_name') ?? 'rss'));
        $categoryId = (int)($this->request->getPost('category_id') ?? 1);
        $limit      = (int)($this->request->getPost('limit') ?? 20);

        // slug: auto => baseSlug-id (id ở cuối) | hash => baseSlug-hash
        $slugSuffix  = (string)($this->request->getPost('slug_suffix') ?? 'auto');
        // content_mode: link | empty | summary
        $contentMode = (string)($this->request->getPost('content_mode') ?? 'link');

        $importer = new RssImporter();

        $result = $importer->import($url, [
            'source_name'         => $sourceName,
            'default_category_id' => $categoryId,
            'created_by'          => 1,
            'status'              => 'published',
            'limit'               => max(1, min(50, $limit)),
            'slug_suffix'         => in_array($slugSuffix, ['auto','hash'], true) ? $slugSuffix : 'auto',
            'content_mode'        => in_array($contentMode, ['link','empty','summary'], true) ? $contentMode : 'link',
        ]);

        if (!$result['ok']) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Import failed',
                'error'   => $result['error'],
            ]);
        }

        return $this->response->setJSON([
            'success'  => true,
            'feed_url' => $url,
            'data'     => $result,
        ]);
    }
}
