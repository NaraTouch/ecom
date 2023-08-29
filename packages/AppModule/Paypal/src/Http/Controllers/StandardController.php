<?php

namespace AppModule\Paypal\Http\Controllers;

use AppModule\Paypal\Helpers\Ipn;
use AppModule\Checkout\Facades\Cart;
use AppModule\Sales\Repositories\OrderRepository;

class StandardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \AppModule\Attribute\Repositories\OrderRepository  $orderRepository
     * @param  \AppModule\Paypal\Helpers\Ipn  $ipnHelper
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected Ipn $ipnHelper
    )
    {
    }

    /**
     * Redirects to the paypal.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        return view('paypal::standard-redirect');
    }

    /**
     * Cancel payment from paypal.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('error', trans('shop::app.checkout.cart.paypal-payment-canceled'));

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Success payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        Cart::deActivateCart();

        session()->flash('order', $order);

        return redirect()->route('shop.checkout.success');
    }

    /**
     * Paypal IPN listener.
     *
     * @return \Illuminate\Http\Response
     */
    public function ipn()
    {
        $this->ipnHelper->processIpn(request()->all());
    }
}