{!! view_render_event('module.shop.products.buy_now.before', ['product' => $product]) !!}

<button
    type="submit"
    class="btn btn-lg btn-primary buynow"
    {{ ! $product->isSaleable(1) ? 'disabled' : '' }}
>
    {{ __('shop::app.products.buy-now') }}
</button>

{!! view_render_event('module.shop.products.buy_now.after', ['product' => $product]) !!}
