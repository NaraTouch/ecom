<?php

namespace AppModule\Sitemap\Models;

use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use AppModule\Category\Models\Category as BaseCategory;

class Category extends BaseCategory implements Sitemapable
{
    /**
     * @return mixed
     */
    public function toSitemapTag(): Url | string | array
    {
        if (
            ! $this->slug
            || ! $this->status
        ) {
            return [];
        }

        return route('shop.productOrCategory.index', $this->slug);
    }
}