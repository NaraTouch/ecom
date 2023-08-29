<?php

namespace AppModule\Customer\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use AppModule\Core\Models\Channel;
use AppModule\Customer\Models\Customer;
use AppModule\Customer\Models\Wishlist;
use AppModule\Product\Models\Product;

class CustomerWishlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wishlist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'channel_id'  => Channel::factory(),
            'product_id'  => Product::factory(),
            'customer_id' => Customer::factory(),
        ];
    }
}
