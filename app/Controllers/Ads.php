<?php

namespace App\Controllers;

use App\Models\AdModel;
use App\Models\AdStatModel;

class Ads extends BaseController
{
    protected $adModel;
    protected $statModel;

    public function __construct()
    {
        $this->adModel  = new AdModel();
        $this->statModel = new AdStatModel();
    }

    /**
     * Đếm click và redirect sang link thật
     */
    public function click($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return redirect()->to('/');
        }

        $ad = $this->adModel->find($id);
        if (!$ad || empty($ad['link'])) {
            return redirect()->to('/');
        }

        // tăng click
        $this->statModel->incrementClick($ad['id']);

        return redirect()->to($ad['link']);
    }
}
