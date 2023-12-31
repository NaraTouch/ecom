<?php

namespace AppModule\Customer\Database\Factories;

use AppModule\Customer\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        $name = ucfirst($this->faker->word);

        return [
            'name'            => $name,
            'is_user_defined' => $this->faker->boolean,
            'code'            => lcfirst($name),
        ];
    }
}