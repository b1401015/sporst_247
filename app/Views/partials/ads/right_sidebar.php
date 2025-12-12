<?php if (!empty($ads)): ?>
<div class="sn-banner sn-banner--sidebar" id="sn-sidebar-ads">
    <button class="sn-banner-close" type="button"
            onclick="document.getElementById('sn-sidebar-ads').style.display='none'">
        ×
    </button>

    <?php foreach ($ads as $ad): ?>
        <div class="sn-banner-item">
            <?php if (!empty($ad['html'])): ?>
                <?= $ad['html'] ?>
            <?php elseif (!empty($ad['image'])): ?>
                <a href="<?= site_url('ads/click/' . $ad['id']) ?>"
                   class="sn-banner-link"
                   target="_blank" rel="nofollow">
                    <img src="<?= base_url($ad['image']) ?>"
                         alt="<?= esc($ad['title'] ?? '') ?>">
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
