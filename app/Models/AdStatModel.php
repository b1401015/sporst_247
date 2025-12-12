<?php

namespace App\Models;

use CodeIgniter\Model;

class AdStatModel extends Model
{
    protected $table      = 'ad_stats';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['ad_id', 'views', 'clicks', 'stat_date'];

    protected $useTimestamps = false;

    protected function upsertRow(int $adId): array
    {
        $today = date('Y-m-d');

        $row = $this->where([
            'ad_id'     => $adId,
            'stat_date' => $today,
        ])->first();

        if (!$row) {
            $id = $this->insert([
                'ad_id'     => $adId,
                'views'     => 0,
                'clicks'    => 0,
                'stat_date' => $today,
            ]);
            $row = $this->find($id);
        }

        return $row;
    }

    public function incrementView(int $adId): void
    {
        $row = $this->upsertRow($adId);
        $this->update($row['id'], ['views' => $row['views'] + 1]);
    }

    public function incrementClick(int $adId): void
    {
        $row = $this->upsertRow($adId);
        $this->update($row['id'], ['clicks' => $row['clicks'] + 1]);
    }
}
