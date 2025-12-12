<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= esc($baseUrl) ?></loc>
    </url>

    <?php foreach ($categories as $c): ?>
        <url>
            <loc><?= esc($baseUrl.'/category/'.$c['slug']) ?></loc>
        </url>
    <?php endforeach; ?>

    <?php foreach ($posts as $p): ?>
        <url>
            <loc><?= esc($baseUrl.'/post/'.$p['slug']) ?></loc>
        </url>
    <?php endforeach; ?>

    <?php foreach ($leagues as $l): ?>
        <url>
            <loc><?= esc($baseUrl.'/league/'.$l['slug']) ?></loc>
        </url>
    <?php endforeach; ?>

    <?php foreach ($videos as $v): ?>
        <url>
            <loc><?= esc($baseUrl.'/video/'.$v['slug']) ?></loc>
        </url>
    <?php endforeach; ?>
</urlset>
