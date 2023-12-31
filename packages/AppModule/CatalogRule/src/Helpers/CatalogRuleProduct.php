<?php

namespace AppModule\CatalogRule\Helpers;

use Carbon\Carbon;
use AppModule\Attribute\Repositories\AttributeRepository;
use AppModule\Product\Repositories\ProductRepository;
use AppModule\CatalogRule\Repositories\CatalogRuleProductRepository;
use AppModule\Rule\Helpers\Validator;

class CatalogRuleProduct
{
    /**
     * Create a new helper instance.
     *
     * @param  \AppModule\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \AppModule\Product\Repositories\ProductRepository  $productRepository
     * @param  \AppModule\CatalogRule\Repositories\CatalogRuleProductRepository  $catalogRuleProductRepository
     * @param  \AppModule\Rule\Helpers\Validator  $validator
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected ProductRepository $productRepository,
        protected CatalogRuleProductRepository $catalogRuleProductRepository,
        protected Validator $validator
    )
    {
    }

    /**
     * Collect discount on cart
     *
     * @param \AppModule\CatalogRule\Contracts\CatalogRule  $rule
     * @param int  $batchCount
     * @return void
     */
    public function insertRuleProduct($rule, $batchCount = 1000, $product = null)
    {
        if (! (float) $rule->discount_amount) {
            return;
        }

        $productIds = $this->getMatchingProductIds($rule, $product);

        $rows = [];

        $startsFrom = $rule->starts_from ? Carbon::createFromTimeString($rule->starts_from . " 00:00:01") : null;

        $endsTill = $rule->ends_till ? Carbon::createFromTimeString($rule->ends_till . " 23:59:59") : null;

        foreach ($productIds as $productId) {
            foreach ($rule->channels()->pluck('id') as $channelId) {
                foreach ($rule->customer_groups()->pluck('id') as $customerGroupId) {
                    $rows[] = [
                        'starts_from'       => $startsFrom,
                        'ends_till'         => $endsTill,
                        'catalog_rule_id'   => $rule->id,
                        'channel_id'        => $channelId,
                        'customer_group_id' => $customerGroupId,
                        'product_id'        => $productId,
                        'discount_amount'   => $rule->discount_amount,
                        'action_type'       => $rule->action_type,
                        'end_other_rules'   => $rule->end_other_rules,
                        'sort_order'        => $rule->sort_order,
                    ];

                    if (count($rows) == $batchCount) {
                        $this->catalogRuleProductRepository->getModel()->insert($rows);

                        $rows = [];
                    }
                }
            }
        }

        if (! empty($rows)) {
            $this->catalogRuleProductRepository->getModel()->insert($rows);
        }
    }

    /**
     * Get array of product ids which are matched by rule
     *
     * @param  \AppModule\CatalogRule\Contracts\CatalogRule  $rule
     * @param  \AppModule\Product\Contracts\Product  $product
     * @return array
     */
    public function getMatchingProductIds($rule, $product = null)
    {
        $qb = $this->productRepository->scopeQuery(function($query) use($rule, $product) {
            $qb = $query->distinct()
                ->addSelect('products.*')
                ->leftJoin('product_flat', 'products.id', '=', 'product_flat.product_id')
                ->leftJoin('channels', 'product_flat.channel', '=', 'channels.code')
                ->whereIn('channels.id', $rule->channels()->pluck('id')->toArray());

            if ($product) {
                $qb->where('products.id', $product->id);
            }

            if (! $rule->conditions) {
                return $qb;
            }

            $appliedAttributes = [];

            foreach ($rule->conditions as $condition) {
                if (
                    ! $condition['attribute']
                    || empty($condition['value'])
                    || in_array($condition['attribute'], $appliedAttributes)
                ) {
                    continue;
                }
                
                $appliedAttributes[] = $condition['attribute'];

                $chunks = explode('|', $condition['attribute']);

                $qb = $this->addAttributeToSelect(end($chunks), $qb);
            }

            return $qb;
        });

        $validatedProductIds = [];

        foreach ($qb->get() as $product) {
            if (! $product->getTypeInstance()->priceRuleCanBeApplied()) {
                continue;
            }

            if ($this->validator->validate($rule, $product)) {
                if ($product->getTypeInstance()->isComposite()) {
                    $validatedProductIds = array_merge($validatedProductIds, $product->getTypeInstance()->getChildrenIds());
                } else {
                    $validatedProductIds[] = $product->id;
                }
            }
        }

        return array_unique($validatedProductIds);
    }
    
    /**
     * Add product attribute condition to query
     *
     * @param  string  $attributeCode
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function addAttributeToSelect($attributeCode, $query)
    {
        $attribute = $this->attributeRepository->findOneByField('code', $attributeCode);

        if (! $attribute) {
            return $query;
        }

        $query = $query->leftJoin('product_attribute_values as ' . 'pav_' . $attribute->code, function($qb) use($attribute) {
            $qb = $qb->where('pav_' . $attribute->code . '.channel', $attribute->value_per_channel ? core()->getDefaultChannelCode() : null)
                ->where('pav_' . $attribute->code . '.locale', $attribute->value_per_locale ? app()->getLocale() : null);
            
            $qb->on('products.id', 'pav_' . $attribute->code . '.product_id')
               ->where('pav_' . $attribute->code . '.attribute_id', $attribute->id);
        });

        $query = $query->addSelect('pav_' . $attribute->code . '.' . $attribute->column_name . ' as ' . $attribute->code);

        return $query;
    }

    /**
     * Returns catalog rule products
     *
     * @param  \AppModule\Product\Contracts\Product  $product
     * @return \Illuminate\Support\Collection
     */
    public function getCatalogRuleProducts($product = null)
    {
        $results = $this->catalogRuleProductRepository->scopeQuery(function($query) use($product) {
            $qb = $query->distinct()
                ->select('catalog_rule_products.*')
                ->leftJoin('products', 'catalog_rule_products.product_id', '=', 'products.id')
                ->orderBy('channel_id', 'asc')
                ->orderBy('customer_group_id', 'asc')
                ->orderBy('product_id', 'asc')
                ->orderBy('sort_order', 'asc')
                ->orderBy('catalog_rule_id', 'asc');

            $qb = $this->addAttributeToSelect('price', $qb);

            if ($product) {
                if (! $product->getTypeInstance()->priceRuleCanBeApplied()) {
                    return $qb;
                }

                if ($product->getTypeInstance()->isComposite()) {
                    $qb->whereIn('catalog_rule_products.product_id', $product->getTypeInstance()->getChildrenIds());
                } else {
                    $qb->where('catalog_rule_products.product_id', $product->id);
                }
            }

            return $qb;
        })->get();

        return $results;
    }

    /**
     * Returns catalog rules
     *
     * @param  \AppModule\CatalogRule\Contracts\CatalogRule  $rule
     * @return void
     */
    public function cleanProductIndex($productIds = [])
    {
        if (count($productIds)) {
            $this->catalogRuleProductRepository->getModel()->whereIn('product_id', $productIds)->delete();
        } else {
            $this->catalogRuleProductRepository->deleteWhere([
                ['product_id', 'like', '%%']
            ]);
        }
    }
}