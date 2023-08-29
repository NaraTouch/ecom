<?php

namespace AppModule\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AppModule\Product\Models\Product;
use AppModule\Product\Models\ProductOrderedInventory;

class ProductOrderedInventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOrderedInventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'qty'        => $this->faker->numberBetween(100, 200),
            'product_id' => Product::factory(),
            'channel_id' => 1,
        ];
    }
}
