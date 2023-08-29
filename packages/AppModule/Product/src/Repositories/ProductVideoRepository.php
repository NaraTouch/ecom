<?php

namespace AppModule\Product\Repositories;

class ProductVideoRepository extends ProductMediaRepository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Product\Contracts\ProductVideo';
    }

    /**
     * Upload videos.
     *
     * @param  array  $data
     * @param  \AppModule\Product\Contracts\Product  $product
     * @return void
     */
    public function uploadVideos($data, $product)
    {
        $this->upload($data, $product, 'videos');
    }
}
