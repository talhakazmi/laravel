<?php

namespace App\Filters;

use Kyslik\LaravelFilterable\Generic\Filter;

class ShopFilter extends Filter
{
    /**
     * Defines columns that end-user may filter by.
     *
     * @var array
     */
    protected $filterables = ['name_en', 'name_ar'];

    /**
     * Define allowed generics, and for which fields.
     * Read more in the documentation https://github.com/Kyslik/laravel-filterable#additional-configuration
     *
     * @return void
     */
    protected function settings()
    {
        //
    }
}
