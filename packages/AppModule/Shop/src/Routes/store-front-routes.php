<?php

use Illuminate\Support\Facades\Route;
use AppModule\CMS\Http\Controllers\Shop\PagePresenterController;
use AppModule\Core\Http\Controllers\CountryStateController;
use AppModule\Shop\Http\Controllers\CategoryController;
use AppModule\Shop\Http\Controllers\HomeController;
use AppModule\Shop\Http\Controllers\ProductController;
use AppModule\Shop\Http\Controllers\ReviewController;
use AppModule\Shop\Http\Controllers\SearchController;
use AppModule\Shop\Http\Controllers\SubscriptionController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function () {
    /**
     * Cart merger middleware. This middleware will take care of the items
     * which are deactivated at the time of buy now functionality. If somehow
     * user redirects without completing the checkout then this will merge
     * full cart.
     *
     * If some routes are not able to merge the cart, then place the route in this
     * group.
     */
    Route::group(['middleware' => ['cart.merger']], function () {
        /**
         * CMS pages.
         */
        Route::get('page/{slug}', [PagePresenterController::class, 'presenter'])->name('shop.cms.page');

        /**
         * Fallback route.
         */
        Route::fallback(\AppModule\Shop\Http\Controllers\ProductsCategoriesProxyController::class . '@index')
            ->defaults('_config', [
                'product_view'  => 'shop::products.view',
                'category_view' => 'shop::products.index',
            ])
            ->name('shop.productOrCategory.index');
    });

    /**
     * Store front home.
     */
    Route::get('/', [HomeController::class, 'index'])->defaults('_config', [
        'view' => 'shop::home.index',
    ])->name('shop.home.index');

    /**
     * Store front search.
     */
    Route::get('search', [SearchController::class, 'index'])->defaults('_config', [
        'view' => 'shop::search.search',
    ])->name('shop.search.index');

    Route::post('upload-search-image', [HomeController::class, 'upload'])->name('shop.image.search.upload');

    /**
     * Countries and states.
     */
    Route::get('countries', [CountryStateController::class, 'getCountries'])->name('shop.countries');
    Route::get('countries/states', [CountryStateController::class, 'getStates'])->name('shop.countries.states');

    /**
     * Subscription routes.
     */
    Route::get('subscribe', [SubscriptionController::class, 'subscribe'])->name('shop.subscribe');

    Route::get('unsubscribe/{token}', [SubscriptionController::class, 'unsubscribe'])->name('shop.unsubscribe');

    /**
     * Product and categories routes.
     */
    Route::get('reviews/{slug}', [ReviewController::class, 'show'])->defaults('_config', [
        'view' => 'shop::products.reviews.index',
    ])->name('shop.reviews.index');

    Route::get('product/{slug}/review', [ReviewController::class, 'create'])->defaults('_config', [
        'view' => 'shop::products.reviews.create',
    ])->name('shop.reviews.create');

    Route::post('product/{slug}/review', [ReviewController::class, 'store'])->defaults('_config', [
        'redirect' => 'shop.home.index',
    ])->name('shop.reviews.store');

    Route::get('downloadable/download-sample/{type}/{id}', [ProductController::class, 'downloadSample'])->name('shop.downloadable.download_sample');

    Route::get('product/{id}/{attribute_id}', [ProductController::class, 'download'])->defaults('_config', [
        'view' => 'shop.products.index',
    ])->name('shop.product.file.download');

    Route::get('categories/filterable-attributes/{categoryId?}', [CategoryController::class, 'getFilterableAttributes'])->name('shop.catalog.categories.filterable_attributes');

    Route::get('categories/maximum-price/{categoryId?}', [CategoryController::class, 'getCategoryProductMaximumPrice'])->name('shop.catalog.categories.maximum_price');
});
