<?php

namespace AppModule\Product\Type;

use AppModule\Customer\Repositories\CustomerRepository;
use AppModule\Attribute\Repositories\AttributeRepository;
use AppModule\Product\Repositories\ProductRepository;
use AppModule\Product\Repositories\ProductAttributeValueRepository;
use AppModule\Product\Repositories\ProductInventoryRepository;
use AppModule\Product\Repositories\ProductImageRepository;
use AppModule\Product\Repositories\ProductVideoRepository;
use AppModule\Product\Repositories\ProductCustomerGroupPriceRepository;
use AppModule\Tax\Repositories\TaxCategoryRepository;
use AppModule\Product\Repositories\ProductDownloadableLinkRepository;
use AppModule\Product\Repositories\ProductDownloadableSampleRepository;
use AppModule\Checkout\Models\CartItem;
use AppModule\Product\DataTypes\CartItemValidationResult;
use AppModule\Product\Helpers\Indexers\Price\Downloadable as DownloadableIndexer;

class Downloadable extends AbstractType
{
    /**
     * Skip attribute for downloadable product type.
     *
     * @var array
     */
    protected $skipAttributes = [
        'length',
        'width',
        'height',
        'weight',
        'depth',
        'guest_checkout',
    ];

    /**
     * These blade files will be included in product edit page.
     *
     * @var array
     */
    protected $additionalViews = [
        'admin::catalog.products.accordians.images',
        'admin::catalog.products.accordians.videos',
        'admin::catalog.products.accordians.categories',
        'admin::catalog.products.accordians.downloadable',
        'admin::catalog.products.accordians.channels',
        'admin::catalog.products.accordians.product-links',
    ];

    /**
     * Is a stokable product type.
     *
     * @var bool
     */
    protected $isStockable = false;

    /**
     * Show quantity box.
     *
     * @var bool
     */
    protected $allowMultipleQty = false;

    /**
     * Create a new product type instance.
     *
     * @param  \AppModule\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \AppModule\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \AppModule\Product\Repositories\ProductRepository  $productRepository
     * @param  \AppModule\Product\Repositories\ProductAttributeValueRepository  $attributeValueRepository
     * @param  \AppModule\Product\Repositories\ProductInventoryRepository  $productInventoryRepository
     * @param  \AppModule\Product\Repositories\ProductImageRepository  $productImageRepository
     * @param  \AppModule\Product\Repositories\ProductCustomerGroupPriceRepository  $productCustomerGroupPriceRepository
     * @param  \AppModule\Tax\Repositories\TaxCategoryRepository  $taxCategoryRepository
     * @param  \AppModule\Product\Repositories\ProductDownloadableLinkRepository  $productDownloadableLinkRepository
     * @param  \AppModule\Product\Repositories\ProductDownloadableSampleRepository  $productDownloadableSampleRepository
     * @param  \AppModule\Product\Repositories\ProductVideoRepository  $productVideoRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        AttributeRepository $attributeRepository,
        ProductRepository $productRepository,
        ProductAttributeValueRepository $attributeValueRepository,
        ProductInventoryRepository $productInventoryRepository,
        productImageRepository $productImageRepository,
        ProductVideoRepository $productVideoRepository,
        ProductCustomerGroupPriceRepository $productCustomerGroupPriceRepository,
        TaxCategoryRepository $taxCategoryRepository,
        protected ProductDownloadableLinkRepository $productDownloadableLinkRepository,
        protected ProductDownloadableSampleRepository $productDownloadableSampleRepository
    )
    {
        parent::__construct(
            $customerRepository,
            $attributeRepository,
            $productRepository,
            $attributeValueRepository,
            $productInventoryRepository,
            $productImageRepository,
            $productVideoRepository,
            $productCustomerGroupPriceRepository,
            $taxCategoryRepository
        );
    }

    /**
     * Update.
     *
     * @param  array  $data
     * @param  int  $id
     * @param  string  $attribute
     * @return \AppModule\Product\Contracts\Product
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        $product = parent::update($data, $id, $attribute);

        if (request()->route()?->getName() == 'admin.catalog.products.mass_update') {
            return $product;
        }

        $this->productDownloadableLinkRepository->saveLinks($data, $product);

        $this->productDownloadableSampleRepository->saveSamples($data, $product);

        return $product;
    }

    /**
     * Return true if this product type is saleable.
     *
     * @return bool
     */
    public function isSaleable()
    {
        if (! $this->product->status) {
            return false;
        }

        if (
            is_callable(config('products.isSaleable'))
            && call_user_func(config('products.isSaleable'), $this->product) === false
        ) {
            return false;
        }

        if ($this->product->downloadable_links()->count()) {
            return true;
        }

        return false;
    }

    /**
     * Returns validation rules.
     *
     * @return array
     */
    public function getTypeValidationRules()
    {
        return [
            'downloadable_links.*.type'       => 'required',
            'downloadable_links.*.file'       => 'required_if:type,==,file',
            'downloadable_links.*.file_name'  => 'required_if:type,==,file',
            'downloadable_links.*.url'        => 'required_if:type,==,url',
            'downloadable_links.*.downloads'  => 'required',
            'downloadable_links.*.sort_order' => 'required',
        ];
    }

    /**
     * Add product. Returns error message if can't prepare product.
     *
     * @param  array  $data
     * @return array
     */
    public function prepareForCart($data)
    {
        if (empty($data['links'])) {
            return trans('shop::app.checkout.cart.integrity.missing_links');
        }

        $products = parent::prepareForCart($data);

        foreach ($this->product->downloadable_links as $link) {
            if (! in_array($link->id, $data['links'])) {
                continue;
            }

            $products[0]['price'] += core()->convertPrice($link->price);
            $products[0]['base_price'] += $link->price;
            $products[0]['total'] += (core()->convertPrice($link->price) * $products[0]['quantity']);
            $products[0]['base_total'] += ($link->price * $products[0]['quantity']);
        }

        return $products;
    }

    /**
     * Compare options.
     *
     * @param  array  $options1
     * @param  array  $options2
     * @return bool
     */
    public function compareOptions($options1, $options2)
    {
        if ($this->product->id != $options2['product_id']) {
            return false;
        }

        if (
            isset($options1['links'])
            && isset($options2['links'])
        ) {
            return $options1['links'] === $options2['links'];
        }

        if (! isset($options1['links'])) {
            return false;
        }

        if (! isset($options2['links'])) {
            return false;
        }
    }

    /**
     * Returns additional information for items.
     *
     * @param  array  $data
     * @return array
     */
    public function getAdditionalOptions($data)
    {
        $labels = [];

        foreach ($this->product->downloadable_links as $link) {
            if (in_array($link->id, $data['links'])) {
                $labels[] = $link->title;
            }
        }

        $data['attributes'][0] = [
            'attribute_name' => 'Downloads',
            'option_id'      => 0,
            'option_label'   => implode(', ', $labels),
        ];

        return $data;
    }

    /**
     * Validate cart item product price
     *
     * @param  \AppModule\Checkout\Models\CartItem  $item
     * @return \AppModule\Product\DataTypes\CartItemValidationResult
     */
    public function validateCartItem(CartItem $item): CartItemValidationResult
    {
        $result = new CartItemValidationResult();

        if (parent::isCartItemInactive($item)) {
            $result->itemIsInactive();

            return $result;
        }

        $price = $item->product->getTypeInstance()->getFinalPrice($item->quantity);

        foreach ($item->product->downloadable_links as $link) {
            if (! in_array($link->id, $item->additional['links'])) {
                continue;
            }

            $price += $link->price;
        }

        $price = round($price, 2);

        if ($price == $item->base_price) {
            return $result;
        }

        $item->base_price = $price;
        $item->price = core()->convertPrice($price);

        $item->base_total = $price * $item->quantity;
        $item->total = core()->convertPrice($price * $item->quantity);

        $item->save();

        return $result;
    }

    /**
     * Get product maximum price
     *
     * @return float
     */
    public function getMaximumPrice()
    {
        return $this->product->price;
    }

    /**
     * Returns price indexer class for a specific product type
     *
     * @return string
     */
    public function getPriceIndexer()
    {
        return app(DownloadableIndexer::class);
    }
}
