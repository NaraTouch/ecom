<?php

namespace AppModule\Product\Repositories;

use AppModule\Core\Eloquent\Repository;
use AppModule\Product\Repositories\ProductRepository;
use Illuminate\Support\Str;

class ProductGroupedProductRepository extends Repository
{
    /**
     * Specify model.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Product\Contracts\ProductGroupedProduct';
    }

    /**
     * @param  array  $data
     * @param  \AppModule\Product\Contracts\Product  $product
     * @return void
     */
    public function saveGroupedProducts($data, $product)
    {
        $previousGroupedProductIds = $product->grouped_products()->pluck('id');

        if (isset($data['links'])) {
            foreach ($data['links'] as $linkId => $linkInputs) {
                if (Str::contains($linkId, 'link_')) {
                    $this->create(array_merge([
                        'product_id' => $product->id,
                    ], $linkInputs));
                } else {
                    if (is_numeric($index = $previousGroupedProductIds->search($linkId))) {
                        $previousGroupedProductIds->forget($index);
                    }

                    $this->update($linkInputs, $linkId);
                }
            }
        }

        foreach ($previousGroupedProductIds as $previousGroupedProductId) {
            $this->delete($previousGroupedProductId);
        }
    }
}