<?php

namespace AppModule\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use AppModule\Product\Contracts\ProductCustomerGroupPrice as ProductCustomerGroupPriceContract;
use AppModule\Customer\Models\CustomerGroupProxy;

class ProductCustomerGroupPrice extends Model implements ProductCustomerGroupPriceContract
{
    protected $fillable = [
        'qty',
        'value_type',
        'value',
        'product_id',
        'customer_group_id',
    ];

    /**
     * Get the product that owns the customer group price.
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }

    /**
     * Get the product that owns the customer group price.
     */
    public function customer_group()
    {
        return $this->belongsTo(CustomerGroupProxy::modelClass());
    }
}