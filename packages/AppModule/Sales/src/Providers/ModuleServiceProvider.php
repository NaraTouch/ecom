<?php

namespace AppModule\Sales\Providers;

use AppModule\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \AppModule\Sales\Models\Order::class,
        \AppModule\Sales\Models\OrderItem::class,
        \AppModule\Sales\Models\DownloadableLinkPurchased::class,
        \AppModule\Sales\Models\OrderAddress::class,
        \AppModule\Sales\Models\OrderPayment::class,
        \AppModule\Sales\Models\OrderComment::class,
        \AppModule\Sales\Models\Invoice::class,
        \AppModule\Sales\Models\InvoiceItem::class,
        \AppModule\Sales\Models\Shipment::class,
        \AppModule\Sales\Models\ShipmentItem::class,
        \AppModule\Sales\Models\Refund::class,
        \AppModule\Sales\Models\RefundItem::class,
        \AppModule\Sales\Models\OrderTransaction::class,
    ];
}