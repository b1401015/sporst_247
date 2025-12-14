<?php

namespace App\Cells;

class MenuCell
{
    public function render(): string
    {
        $db = db_connect();

        $categories = $db->table('categories')
            ->select('id, name, slug, parent_id')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->get()->getResultArray();

        return view('partials/menu', [
            'categories' => $categories,
        ]);
    }
}
