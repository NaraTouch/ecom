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
use AppModule\Product\Repositories\ProductBundleOptionRepository;
use AppModule\Product\Repositories\ProductBundleOptionProductRepository;
use AppModule\Product\Helpers\BundleOption;
use AppModule\Checkout\Models\CartItem;
use AppModule\Product\DataTypes\CartItemValidationResult;
use AppModule\Product\Helpers\Indexers\Price\Bundle as BundleIndexer;

class Bundle extends AbstractType
{
    /**
     * Skip attribute for Bundle product type.
     *
     * @var array
     */
    protected $skipAttributes = [
        'price',
        'cost',
        'special_price',
        'special_price_from',
        'special_price_to',
        'length',
        'width',
        'height',
        'weight',
        'depth',
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
        'admin::catalog.products.accordians.bundle-items',
        'admin::catalog.products.accordians.channels',
        'admin::catalog.products.accordians.product-links',
    ];

    /**
     * Is a composite product type.
     *
     * @var bool
     */
    protected $isComposite = true;

    /**
     * Product children price can be calculated or not.
     *
     * @var bool
     */
    protected $isChildrenCalculated = true;

    /**
     * Create a new product type instance.
     *
     * @param  \AppModule\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \AppModule\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \AppModule\Product\Repositories\ProductRepository  $productRepository
     * @param  \AppModule\Product\Repositories\ProductAttributeValueRepository  $attributeValueRepository
     * @param  \AppModule\Product\Repositories\ProductInventoryRepository  $productInventoryRepository
     * @param  \AppModule\Product\Repositories\ProductImageRepository  $productImageRepository
     * @param \AppModule\Product\Repositories\ProductVideoRepository  $productVideoRepository
     * @param  \AppModule\Product\Repositories\ProductCustomerGroupPriceRepository  $productCustomerGroupPriceRepository
     * @param  \AppModule\Tax\Repositories\TaxCategoryRepository  $taxCategoryRepository
     * @param  \AppModule\Product\Repositories\ProductBundleOptionRepository  $productBundleOptionRepository
     * @param  \AppModule\Product\Repositories\ProductBundleOptionProductRepository  $productBundleOptionProductRepository
     * @param  \AppModule\Product\Helpers\BundleOption  $bundleOptionHelper
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        AttributeRepository $attributeRepository,
        ProductRepository $productRepository,
        ProductAttributeValueRepository $attributeValueRepository,
        ProductInventoryRepository $productInventoryRepository,
        ProductImageRepository $productImageRepository,
        ProductVideoRepository $productVideoRepository,
        ProductCustomerGroupPriceRepository $productCustomerGroupPriceRepository,
        TaxCategoryRepository $taxCategoryRepository,
        protected ProductBundleOptionRepository $productBundleOptionRepository,
        protected ProductBundleOptionProductRepository $productBundleOptionProductRepository,
        protected BundleOption $bundleOptionHelper
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

        $this->productBundleOptionRepository->saveBundleOptions($data, $product);

        return $product;
    }

    /**
     * Copy relationships.
     *
     * @param  \AppModule\Product\Models\Product  $product
     * @return void
     */
    protected function copyRelationships($product)
    {
        parent::copyRelationships($product);

        $attributesToSkip = config('products.skipAttributesOnCopy') ?? [];

        if (in_array('bundle_options', $attributesToSkip)) {
            return;
        }

        foreach ($this->product->bundle_options as $bundleOption) {
            $product->bundle_options()->save($bundleOption->replicate());
        }
    }

    /**
     * Returns children ids.
     *
     * @return array
     */
    public function getChildrenIds()
    {
        return array_unique($this->product->bundle_options()->pluck('product_id')->toArray());
    }

    /**
     * Check if catalog rule can be applied.
     *
     * @return bool
     */
    public function priceRuleCanBeApplied()
    {
        return false;
    }

    /**
     * Get product minimal price.
     *
     * @param  int  $qty
     * @return float
     */
    public function getFinalPrice($qty = null)
    {
        return round(0, 2);
    }

    /**
     * Returns product prices.
     *
     * @return array
     */
    public function getProductPrices()
    {
        return [
            'from' => [
                'regular_price' => [
                    'price'           => core()->convertPrice($this->evaluatePrice($regularMinimalPrice = $this->getRegularMinimalPrice())),
                    'formatted_price' => core()->currency($this->evaluatePrice($regularMinimalPrice)),
                ],
                'final_price'   => [
                    'price'           => core()->convertPrice($this->evaluatePrice($minimalPrice = $this->getMinimalPrice())),
                    'formatted_price' => core()->currency($this->evaluatePrice($minimalPrice)),
                ],
            ],

            'to' => [
                'regular_price' => [
                    'price'           => core()->convertPrice($this->evaluatePrice($regularMaximumPrice = $this->getRegularMaximumPrice())),
                    'formatted_price' => core()->currency($this->evaluatePrice($regularMaximumPrice)),
                ],
                'final_price'   => [
                    'price'           => core()->convertPrice($this->evaluatePrice($maximumPrice = $this->getMaximumPrice())),
                    'formatted_price' => core()->currency($this->evaluatePrice($maximumPrice)),
                ],
            ],
        ];
    }

    /**
     * Get product minimal price.
     *
     * @return string
     */
    public function getPriceHtml()
    {
        $prices = $this->getProductPrices();

        $priceHtml = '';

        if ($this->haveDiscount()) {
            $priceHtml .= '<div class="sticker sale">' . trans('shop::app.products.sale') . '</div>';
        }

        $priceHtml .= '<div class="price-from">';

        if ($prices['from']['regular_price']['price'] != $prices['from']['final_price']['price']) {
            $priceHtml .= '<span class="bundle-regular-price">' . $prices['from']['regular_price']['formatted_price'] . '</span>'
                . '<span class="bundle-special-price">' . $prices['from']['final_price']['formatted_price'] . '</span>';
        } else {
            $priceHtml .= '<span>' . $prices['from']['regular_price']['formatted_price'] . '</span>';
        }

        if ($prices['from']['regular_price']['price'] != $prices['to']['regular_price']['price']
            || $prices['from']['final_price']['price'] != $prices['to']['final_price']['price']
        ) {
            $priceHtml .= '<span class="bundle-to">To</span>';

            if ($prices['to']['regular_price']['price'] != $prices['to']['final_price']['price']) {
                $priceHtml .= '<span class="bundle-regular-price">' . $prices['to']['regular_price']['formatted_price'] . '</span>'
                    . '<span class="bundle-special-price">' . $prices['to']['final_price']['formatted_price'] . '</span>';
            } else {
                $priceHtml .= '<span>' . $prices['to']['regular_price']['formatted_price'] . '</span>';
            }
        }

        $priceHtml .= '</div>';

        return $priceHtml;
    }

    /**
     * Add product. Returns error message if can't prepare product.
     *
     * @param  array  $data
     * @return array
     */
    public function prepareForCart($data)
    {
        $bundleQuantity = parent::handleQuantity((int) $data['quantity']);

        if (empty($data['bundle_options'])) {
            return trans('shop::app.checkout.cart.integrity.missing_options');
        }

        $data['bundle_options'] = array_filter($this->validateBundleOptionForCart($data['bundle_options']));

        if (empty($data['bundle_options'])) {
            return trans('shop::app.checkout.cart.integrity.missing_options');
        }

        if (! $this->haveSufficientQuantity($data['quantity'])) {
            return trans('shop::app.checkout.cart.quantity.inventory_warning');
        }

        $products = parent::prepareForCart($data);

        foreach ($this->getCartChildProducts($data) as $productId => $data) {
            $product = $this->productRepository->find($productId);

            /* need to check each individual quantity as well if don't have then show error */
            if (! $product->getTypeInstance()->haveSufficientQuantity($data['quantity'] * $bundleQuantity)) {
                return trans('shop::app.checkout.cart.quantity.inventory_warning');
            }

            if (! $product->getTypeInstance()->isSaleable()) {
                continue;
            }

            $cartProduct = $product->getTypeInstance()->prepareForCart(array_merge($data, [
                'parent_id' => $this->product->id
            ]));

            if (is_string($cartProduct)) {
                return $cartProduct;
            }

            $cartProduct[0]['parent_id'] = $this->product->id;
            $cartProduct[0]['quantity'] = $data['quantity'];
            $cartProduct[0]['total_weight'] = $cartProduct[0]['weight'] * $data['quantity'];
            $cartProduct[0]['base_total_weight'] = $cartProduct[0]['weight'] * $data['quantity'];

            $products = array_merge($products, $cartProduct);

            $products[0]['price'] += $cartProduct[0]['total'];
            $products[0]['base_price'] += $cartProduct[0]['base_total'];
            $products[0]['total'] += $cartProduct[0]['total'];
            $products[0]['base_total'] += $cartProduct[0]['base_total'];
            $products[0]['weight'] += ($cartProduct[0]['weight'] * $products[0]['quantity']);
            $products[0]['total_weight'] += ($cartProduct[0]['total_weight'] * $products[0]['quantity']);
            $products[0]['base_total_weight'] += ($cartProduct[0]['base_total_weight'] * $products[0]['quantity']);
        }

        return $products;
    }

    /**
     * Add product. Returns error message if can't prepare product.
     *
     * @param  array  $data
     * @return array
     */
    public function getCartChildProducts($data)
    {
        $products = [];

        foreach ($data['bundle_options'] as $optionId => $optionProductIds) {
            foreach ($optionProductIds as $optionProductId) {
                if (! $optionProductId) {
                    continue;
                }

                $optionProduct = $this->productBundleOptionProductRepository->findOneWhere([
                    'id'                       => $optionProductId,
                    'product_bundle_option_id' => $optionId,
                ]);

                if (! $optionProduct->product->getTypeInstance()->isSaleable()) {
                    continue;
                }

                $qty = $data['bundle_option_qty'][$optionId] ?? $optionProduct->qty;

                if (! isset($products[$optionProduct->product_id])) {
                    $products[$optionProduct->product_id] = [
                        'product_id' => $optionProduct->product_id,
                        'quantity'   => $qty,
                    ];
                } else {
                    $products[$optionProduct->product_id] = array_merge($products[$optionProduct->product_id], [
                        'quantity' => $products[$optionProduct->product_id]['quantity'] + $qty,
                    ]);
                }
            }
        }

        return $products;
    }

    /**
     * Compare options.
     *
     * @param  array  $options1
     * @param  array  $options2
     * @return boolean
     */
    public function compareOptions($options1, $options2)
    {
        if (
            isset($options2['product_id'])
            && $this->product->id != $options2['product_id']
        ) {
            return false;
        }

        if (
            isset($options1['bundle_options'])
            && isset($options2['bundle_options'])
        ) {
            return $options1['bundle_options'] == $options2['bundle_options']
                && $options1['bundle_option_qty'] == $this->getOptionQuantities($options2);
        }

        if (! isset($options1['bundle_options'])) {
            return false;
        }

        if (! isset($options2['bundle_options'])) {
            return false;
        }
    }

    /**
     * Remove invalid options from add to cart request.
     *
     * @param  array  $data
     * @return array
     */
    public function validateBundleOptionForCart($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->validateBundleOptionForCart($value);
            } elseif ($value) {
                $data[$key] = (int) $value;
            } else {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * Returns additional information for items.
     *
     * @param  array  $data
     * @return array
     */
    public function getAdditionalOptions($data)
    {
        $bundleOptionQuantities = $data['bundle_option_qty'] ?? [];

        $productBundleOptions = $this->productBundleOptionRepository
            ->whereIn('id', array_keys($data['bundle_options']))
            ->orderBy('sort_order')
            ->get();

        foreach ($productBundleOptions as $option) {
            $labels = [];

            foreach ($data['bundle_options'][$option->id] as $optionProductId) {
                if (! $optionProductId) {
                    continue;
                }

                $optionProduct = $this->productBundleOptionProductRepository->find($optionProductId);

                $qty = $data['bundle_option_qty'][$option->id] ?? $optionProduct->qty;

                if (! isset($data['bundle_option_qty'][$option->id])) {
                    $bundleOptionQuantities[$option->id] = $qty;
                }

                $label = $qty . ' x ' . $optionProduct->product->name;

                $price = $optionProduct->product->getTypeInstance()->getMinimalPrice();
                if ($price != 0) {
                    $label .= ' ' . core()->currency($price);
                }

                $labels[] = $label;
            }

            if (count($labels)) {
                $data['attributes'][] = [
                    'attribute_name' => $option->label,
                    'option_id'      => $option->id,
                    'option_label'   => implode(', ', $labels),
                ];
            }
        }

        $data['bundle_option_qty'] = $bundleOptionQuantities;

        return $data;
    }

    /**
     * Returns additional information for items.
     *
     * @param  array  $data
     * @return array
     */
    public function getOptionQuantities($data)
    {
        $optionQuantities = [];

        foreach ($data['bundle_options'] as $optionId => $optionProductIds) {
            foreach ($optionProductIds as $optionProductId) {
                if (! $optionProductId) {
                    continue;
                }

                if (isset($data['bundle_option_qty'][$optionId])) {
                    $optionQuantities[$optionId] = $data['bundle_option_qty'][$optionId];

                    continue;
                }

                $optionProduct = $this->productBundleOptionProductRepository->find($optionProductId);

                $optionQuantities[$optionId] = $optionProduct->qty;
            }
        }

        return $optionQuantities;
    }

    /**
     * Validate cart item product price and other things.
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

        $price = 0;

        foreach ($item->children as $childItem) {
            $childResult = $childItem->product->getTypeInstance()->validateCartItem($childItem);

            if ($childResult->isItemInactive()) {
                $result->itemIsInactive();
            }

            if ($childResult->isCartInvalid()) {
                $result->cartIsInvalid();
            }

            $price += $childItem->base_price * $childItem->quantity;
        }

        $price = round($price, 2);

        if ($price == $item->base_price) {
            return $result;
        }

        $item->base_price = $price;
        $item->price = core()->convertPrice($price);

        $item->base_total = $price * $item->quantity;
        $item->total = core()->convertPrice($price * $item->quantity);

        $item->additional = $this->getAdditionalOptions($item->additional);

        $item->save();

        return $result;
    }

    /**
     * Have sufficient quantity.
     *
     * @param  int  $qty
     * @return bool
     */
    public function haveSufficientQuantity(int $qty): bool
    {
        # to consider a bundle in stock we need to check that at least one product from each required group is available for the given quantity
        foreach ($this->product->bundle_options as $option) {
            if ($option->is_required) {
                foreach ($option->bundle_option_products as $bundleOptionProduct) {
                    # as long as at least one product in the required group is available we can continue checking other groups
                    if ($bundleOptionProduct->product->haveSufficientQuantity($bundleOptionProduct->qty * $qty)) {
                        continue 2;
                    }
                }

                # if any required option does not have any in-stock product option we will get here.
                return false;
            }
        }

        return true;
    }

    /**
     * Returns price indexer class for a specific product type
     *
     * @return string
     */
    public function getPriceIndexer()
    {
        return app(BundleIndexer::class);
    }
}
