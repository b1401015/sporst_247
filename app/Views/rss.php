<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<rss version="2.0">
<channel>
    <title><?= esc($siteName) ?></title>
    <link><?= esc($siteUrl) ?></link>
    <description>Tin thể thao mới nhất</description>

    <?php foreach ($posts as $p): ?>
    <item>
        <title><?= esc($p['title']) ?></title>
        <link><?= esc($siteUrl.'/post/'.$p['slug']) ?></link>
        <description><?= esc($p['summary']) ?></description>
        <?php if (!empty($p['published_at'])): ?>
        <pubDate><?= date(DATE_RSS, strtotime($p['published_at'])) ?></pubDate>
        <?php endif; ?>
    </item>
    <?php endforeach; ?>
</channel>
</rss>
