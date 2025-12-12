<?php

namespace App\Controllers;

use App\Models\MedalModel;
use App\Models\CountryModel;
use App\Models\CategoryModel;

class Medals extends BaseController
{
    public function index()
    {
        $medalM   = new MedalModel();
        $countryM = new CountryModel();
        $catM     = new CategoryModel();

        $rows = $medalM->select('medals.*, countries.name, countries.code')
            ->join('countries','countries.id = medals.country_id')
            ->orderBy('gold','DESC')
            ->orderBy('silver','DESC')
            ->orderBy('bronze','DESC')
            ->get()->getResultArray();

        $data = [
            'title'           => 'Bảng huy chương',
            'meta_title'      => 'Bảng huy chương',
            'meta_description'=> 'Bảng tổng sắp huy chương cập nhật.',
            'rows'            => $rows,
            'categories'      => $catM->getActive(),
        ];

        return view('frontend/medals', $data);
    }
}
