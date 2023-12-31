<?php

namespace AppModule\Product\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AppModule\Product\Database\Factories\ProductDownloadableLinkTranslationFactory;
use AppModule\Product\Contracts\ProductDownloadableLinkTranslation as ProductDownloadableLinkTranslationContract;

class ProductDownloadableLinkTranslation extends Model implements ProductDownloadableLinkTranslationContract
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['title'];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return ProductDownloadableLinkTranslationFactory::new();
    }
}