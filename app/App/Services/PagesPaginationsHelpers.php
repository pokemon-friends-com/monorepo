<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator;

if (!function_exists('pages_pagination')) {
    /**
     * Display the pagination of AdminLte theme.
     *
     * @return string
     */
    function pages_pagination(
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
            ->render('partials.pages.default.pagination');
    }
}
