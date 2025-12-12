<?php

namespace App\Models;

use CodeIgniter\Model;

class AdModel extends Model
{
    protected $table      = 'ads';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'title',
        'position',
        'image',
        'link',
        'html',
        'is_active',
        'sort_order',
        'started_at',
        'ended_at',
    ];

    /**
     * Lấy banner đang chạy theo vị trí (dùng cho frontend)
     */
    public function getByPosition(string $position, int $limit = 5): array
    {
        $now = date('Y-m-d H:i:s');

        return $this->where('position', $position)
            ->where('is_active', 1)
            ->groupStart()
                ->where('started_at', null)
                ->orWhere('started_at <=', $now)
            ->groupEnd()
            ->groupStart()
                ->where('ended_at', null)
                ->orWhere('ended_at >=', $now)
            ->groupEnd()
            ->orderBy('sort_order', 'ASC')
            ->findAll($limit);
    }

    /**
     * Giữ lại cho tương thích nếu bạn đã dùng tên này ở chỗ khác
     */
    public function getActiveByPosition(string $position, int $limit = 5): array
    {
        return $this->getByPosition($position, $limit);
    }
}
