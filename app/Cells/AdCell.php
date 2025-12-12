<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;
use App\Models\AdModel;
use App\Models\AdStatModel;

class AdCell extends Cell
{
    protected $adModel;
    protected $statModel;

    public function __construct()
    {
        $this->adModel  = new AdModel();
        $this->statModel = new AdStatModel();
    }

    /**
     * Banner top ngang trên cùng
     */
    public function topBanner(int $limit = 1)
    {
        $ads = $this->adModel->getActiveByPosition('top_banner', $limit);

        foreach ($ads as $ad) {
            $this->statModel->incrementView($ad['id']);
        }

        return view('partials/ads/top_banner', ['ads' => $ads]);
    }

    /**
     * Banner sidebar bên phải (dưới tin nóng / tin đọc nhiều)
     */
    public function rightSidebar(int $limit = 2)
    {
        $ads = $this->adModel->getActiveByPosition('right_sidebar', $limit);

        foreach ($ads as $ad) {
            $this->statModel->incrementView($ad['id']);
        }

        return view('partials/ads/right_sidebar', ['ads' => $ads]);
    }
}
