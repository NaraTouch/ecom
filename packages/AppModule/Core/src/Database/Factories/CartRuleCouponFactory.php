<?php

namespace AppModule\Core\Database\Factories;

use Illuminate\Support\Str;
use AppModule\CartRule\Models\CartRule;
use AppModule\CartRule\Models\CartRuleCoupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartRuleCouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartRuleCoupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code'               => Str::uuid(),
            'usage_limit'        => 100,
            'usage_per_customer' => 100,
            'type'               => 0,
            'is_primary'         => 1,
            'cart_rule_id'       => CartRule::factory(),
        ];
    }
}
