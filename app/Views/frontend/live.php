<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h5 class="border-bottom pb-1 mb-3">Trực tiếp</h5>

<table class="table table-sm" id="live-table">
    <thead>
        <tr>
            <th>Thời gian</th>
            <th>Trận đấu</th>
            <th>Tỷ số</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($matches)): ?>
            <?php foreach ($matches as $m): ?>
                <tr>
                    <td><?= date('d/m H:i', strtotime($m['kickoff'])) ?></td>
                    <td><?= esc($m['home_name']) ?> vs <?= esc($m['away_name']) ?></td>
                    <td><?= $m['home_score'] ?> - <?= $m['away_score'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">Hiện chưa có trận nào đang diễn ra.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
setInterval(function() {
    fetch('/live/matches')
        .then(r => r.json())
        .then(data => {
            const tbody = document.querySelector('#live-table tbody');
            tbody.innerHTML = '';
            if (!data.length) {
                tbody.innerHTML = '<tr><td colspan="3">Hiện chưa có trận nào đang diễn ra.</td></tr>';
                return;
            }
            data.forEach(function(m) {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td>'+m.kickoff+'</td><td>'+m.home_name+' vs '+m.away_name+'</td><td>'+m.home_score+' - '+m.away_score+'</td>';
                tbody.appendChild(tr);
            });
        });
}, 30000);
</script>

<?= $this->endSection() ?>
