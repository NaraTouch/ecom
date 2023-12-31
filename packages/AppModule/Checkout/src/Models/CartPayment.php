<?php

namespace AppModule\Checkout\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AppModule\Checkout\Database\Factories\CartPaymentFactory;
use AppModule\Checkout\Contracts\CartPayment as CartPaymentContract;

class CartPayment extends Model implements CartPaymentContract
{
    use HasFactory;

    protected $table = 'cart_payment';

    /**
     * Create a new factory instance for the model
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return CartPaymentFactory::new();
    }
}