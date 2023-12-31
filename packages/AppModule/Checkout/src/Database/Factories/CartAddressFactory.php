<?php

namespace AppModule\Checkout\Database\Factories;

use AppModule\Checkout\Models\CartAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'first_name'   => $this->faker->firstName(),
            'last_name'    => $this->faker->lastName,
            'email'        => $this->faker->email,
            'address_type' => CartAddress::ADDRESS_TYPE_BILLING,
        ];
    }
}
