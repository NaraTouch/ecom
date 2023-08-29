<?php

namespace AppModule\Velocity\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\Product\Models\ProductProxy;
use AppModule\Customer\Models\CustomerProxy;
use AppModule\Velocity\Contracts\VelocityCustomerCompareProduct as VelocityCustomerCompareProductContract;

class VelocityCustomerCompareProduct extends Model implements VelocityCustomerCompareProductContract
{
    protected $guarded = [];

    /**
     * The product that belong to the compare product.
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass(), 'product_id');
    }

    /**
     * The customer that belong to the compare product.
     */
    public function customer()
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id');
    }
}