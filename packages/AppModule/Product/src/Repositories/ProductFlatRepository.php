<?php

namespace AppModule\Product\Repositories;

use Illuminate\Support\Facades\DB;
use AppModule\Core\Eloquent\Repository;
use AppModule\Attribute\Models\Attribute;
use AppModule\Product\Listeners\ProductFlat;

class ProductFlatRepository extends Repository
{
    /**
     * Specify model.
     *
     * @return string
     */
    public function model(): string
    {
        return 'AppModule\Product\Contracts\ProductFlat';
    }

    /**
     * Update `product_flat` custom column.
     *
     * @param  \AppModule\Attribute\Models\Attribute  $attribute
     * @return mixed
     */
    public function updateAttributeColumn(Attribute $attribute)
    {
        return $this->model
            ->leftJoin('product_attribute_values as v', function ($join) use ($attribute) {
                $join->on('product_flat.id', '=', 'v.product_id')
                    ->on('v.attribute_id', '=', DB::raw($attribute->id));
            })->update(['product_flat.' . $attribute->code => DB::raw($attribute->column_name)]);
    }
}
