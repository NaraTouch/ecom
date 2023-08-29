<?php

namespace AppModule\Product\Repositories;

use Illuminate\Container\Container;
use AppModule\Core\Eloquent\Repository;
use Illuminate\Support\Str;

class ProductBundleOptionRepository extends Repository
{
    /**
     * Create a new repository instance.
     *
     * @param  AppModule\Product\Repositories\ProductBundleOptionProductRepository  $productBundleOptionProductRepository
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(
        protected ProductBundleOptionProductRepository $productBundleOptionProductRepository,
        Container $container
    )
    {
        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Product\Contracts\ProductBundleOption';
    }

    /**
     * @param  array  $data
     * @param  \AppModule\Product\Contracts\Product  $product
     * @return void
     */
    public function saveBundleOptions($data, $product)
    {
        $previousBundleOptionIds = $product->bundle_options()->pluck('id');

        if (isset($data['bundle_options'])) {
            foreach ($data['bundle_options'] as $bundleOptionId => $bundleOptionInputs) {
                if (Str::contains($bundleOptionId, 'option_')) {
                    $productBundleOption = $this->create(array_merge([
                        'product_id' => $product->id,
                    ], $bundleOptionInputs));
                } else {
                    $productBundleOption = $this->find($bundleOptionId);

                    if (is_numeric($index = $previousBundleOptionIds->search($bundleOptionId))) {
                        $previousBundleOptionIds->forget($index);
                    }

                    $this->update($bundleOptionInputs, $bundleOptionId);
                }

                $this->productBundleOptionProductRepository->saveBundleOptionProducts($bundleOptionInputs, $productBundleOption);
            }
        }

        foreach ($previousBundleOptionIds as $previousBundleOptionId) {
            $this->delete($previousBundleOptionId);
        }
    }
}