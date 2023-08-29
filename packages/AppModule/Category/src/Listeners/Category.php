<?php

namespace AppModule\Category\Listeners;

class Category
{
    /**
     * After create.
     *
     * @param  \AppModule\Category\Models\Category  $category
     * @return void
     */
    public function afterCreate($category)
    {
        $category->updateFullSlug();
    }

    /**
     * After update.
     *
     * @param  \AppModule\Category\Models\Category  $category
     * @return void
     */
    public function afterUpdate($category)
    {
        $category->updateFullSlug();
    }
}
