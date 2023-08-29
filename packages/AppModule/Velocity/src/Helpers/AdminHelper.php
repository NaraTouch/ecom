<?php

namespace AppModule\Velocity\Helpers;

use Illuminate\Support\Facades\Storage;
use AppModule\Category\Repositories\CategoryRepository;
use AppModule\Category\Contracts\Category;

class AdminHelper
{
    /**
     * Create a new helper instance.
     *
     * @param  \AppModule\Category\Repositories\CategoryRepository  $categoryRepository
     * @return void
     */
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    /**
     * Store category icon.
     *
     * @param  \AppModule\Category\Contracts\Category  $category
     * @return \AppModule\Category\Contracts\Category
     */
    public function storeCategoryIcon($category)
    {
        $data = request()->all();

        if (! $category instanceof Category) {
            $category = $this->categoryRepository->findOrFail($category);
        }

        $category = $this->uploadImage($category, $data, 'category_icon_path');

        return $category;
    }

    /**
     * Store slider details.
     *
     * @param  \AppModule\Core\Contracts\Slider  $slider
     * @return bool
     */
    public function storeSliderDetails($slider)
    {
        $slider->slider_path = request()->get('slider_path');

        $slider->save();

        return true;
    }

    /**
     * Upload image.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $slider
     * @param  array  $data
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function uploadImage($model, $data, $type)
    {
        if (isset($data[$type])) {
            $request = request();

            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'velocity/' . $type . '/' . $model->id;

                if ($request->hasFile($file)) {
                    if ($model->{$type}) {
                        Storage::delete($model->{$type});
                    }

                    $model->{$type} = $request->file($file)->store($dir);
                    $model->save();
                }
            }
        } else {
            if ($model->{$type}) {
                Storage::delete($model->{$type});
            }

            $model->{$type} = null;
            $model->save();
        }

        return $model;
    }
}
