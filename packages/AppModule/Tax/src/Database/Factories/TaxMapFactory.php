<?php

namespace AppModule\Tax\Database\Factories;

use AppModule\Tax\Models\TaxMap;
use AppModule\Tax\Models\TaxRate;
use AppModule\Tax\Models\TaxCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxMapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxMap::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'tax_category_id' => TaxCategory::factory(),
            'tax_rate_id'     => TaxRate::factory(),
        ];
    }
}

