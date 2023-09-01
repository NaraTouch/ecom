{!! view_render_event('module.shop.products.price.before', ['product' => $product]) !!}

<div class="product-price">
    {!! $product->getTypeInstance()->getPriceHtml() !!}
</div>

{!! view_render_event('module.shop.products.price.after', ['product' => $product]) !!}