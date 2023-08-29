<?php

namespace AppModule\Product\Database\Factories;

use AppModule\Product\Models\Product;
use AppModule\Product\Models\ProductAttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAttributeValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'locale'  => 'en',
            'channel' => 'default',
        ];
    }
}