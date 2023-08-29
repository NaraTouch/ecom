<?php

namespace AppModule\Sitemap\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\Sitemap\Contracts\Sitemap as SitemapContract;

class Sitemap extends Model implements SitemapContract
{
    protected $fillable = [
        'file_name',
        'path',
        'generated_at',
    ];
}