<?php

namespace AppModule\Shop\Http\Controllers;

use AppModule\Attribute\Repositories\AttributeRepository;
use AppModule\Category\Repositories\CategoryRepository;
use AppModule\Product\Repositories\ProductRepository;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \AppModule\Category\Repositories\CategoryRepository  $categoryRepository
     * @param  \AppModule\Product\Repositories\ProductRepository  $productRepository
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected CategoryRepository $categoryRepository,
        protected ProductRepository $productRepository
        
    )
    {
        parent::__construct();
    }

    /**
     * Get filterable attributes for category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilterableAttributes($categoryId)
    {
        $category = $this->categoryRepository->findOrFail($categoryId);

        if (empty($filterableAttributes = $category->filterableAttributes)) {
            $filterableAttributes = $this->attributeRepository->getFilterableAttributes();
        }

        return response()->json([
            'filter_attributes' => $filterableAttributes,
        ]);
    }

    /**
     * Get category product maximum price.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoryProductMaximumPrice($categoryId)
    {
        $maxPrice = $this->productRepository->getCategoryProductMaximumPrice($categoryId);

        return response()->json([
            'max_price' => core()->convertPrice($maxPrice),
        ]);
    }
}
