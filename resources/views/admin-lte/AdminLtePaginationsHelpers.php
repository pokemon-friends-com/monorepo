<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

if (!function_exists('adminlte_pagination')) {
    /**
     * Display the pagination of AdminLte theme.
     *
     * @return string
     */
    function adminlte_pagination(
        $nb_rows,
        $total_row,
        $current_page,
        $per_page = 15,
        $page_name = 'page'
    ) {
        $paginator = new LengthAwarePaginator(
            $nb_rows,
            $total_row,
            $per_page,
            $current_page,
            [
                'path' => Request::url(),
                'query' => Request::query(),
            ]
        );

        return $paginator
            ->setPageName($page_name)
            ->render('admin-lte.pagination');
    }
}
