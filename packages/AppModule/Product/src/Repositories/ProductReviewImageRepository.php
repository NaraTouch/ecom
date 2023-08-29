<?php

namespace AppModule\Product\Repositories;

use Illuminate\Http\UploadedFile;
use AppModule\Core\Eloquent\Repository;

class ProductReviewImageRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'AppModule\Product\Contracts\ProductReviewImage';
    }

    /**
     * @param  array  $data
     * @param  \AppModule\Product\Contracts\ProductReview  $review
     * @return void
     */
    public function uploadImages($data, $review)
    {
        if (! isset($data['attachments'])) {
            return;
        }

        foreach ($data['attachments'] as $imageId => $image) {
            $file = 'attachments.' . $imageId;
            
            $dir = 'review/' . $review->id;

            if (
                $image instanceof UploadedFile
                && request()->hasFile($file)
            ) {
                $this->create([
                    'path'      => request()->file($file)->store($dir),
                    'review_id' => $review->id,
                ]);
            }
        }
    }
}