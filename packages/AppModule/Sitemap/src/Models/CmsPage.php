<?php

namespace AppModule\Sitemap\Models;

use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use AppModule\CMS\Models\CmsPage as BaseCmsPage;

class CmsPage extends BaseCmsPage implements Sitemapable
{
    /**
     * @return mixed
     */
    public function toSitemapTag(): Url | string | array
    {
        if (! $this->url_key) {
            return [];
        }

        return route('shop.cms.page', $this->url_key);
    }
}