<?php

namespace AppModule\Sales\Database\Factories;

use AppModule\Customer\Models\Customer;
use AppModule\Customer\Models\CustomerAddress;
use AppModule\Sales\Models\Order;
use AppModule\Sales\Models\OrderAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderAddress::class;

    /**
     * @var string[]
     */
    protected $states = [
        'shipping',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $customer = Customer::factory()->create();

        $customerAddress = CustomerAddress::factory()->make();

        return [
            'first_name'   => $customer->first_name,
            'last_name'    => $customer->last_name,
            'email'        => $customer->email,
            'address1'     => $customerAddress->address1,
            'country'      => $customerAddress->country,
            'state'        => $customerAddress->state,
            'city'         => $customerAddress->city,
            'postcode'     => $customerAddress->postcode,
            'phone'        => $customerAddress->phone,
            'address_type' => OrderAddress::ADDRESS_TYPE_BILLING,
            'order_id'     => Order::factory(),
        ];
    }

    public function shipping(): void
    {
        $this->state(function (array $attributes) {
            return [
                'address_type' => OrderAddress::ADDRESS_TYPE_SHIPPING,
            ];
        });
    }
}