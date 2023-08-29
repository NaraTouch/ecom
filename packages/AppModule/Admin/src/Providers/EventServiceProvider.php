<?php

namespace AppModule\Admin\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'user.admin.update-password' => [
            'AppModule\Admin\Listeners\PasswordChange@sendUpdatePasswordMail'
        ],
        'checkout.order.save.after' => [
            'AppModule\Admin\Listeners\Order@sendNewOrderMail'
        ],
        'sales.invoice.save.after' => [
            'AppModule\Admin\Listeners\Order@sendNewInvoiceMail'
        ],
        'sales.shipment.save.after' => [
            'AppModule\Admin\Listeners\Order@sendNewShipmentMail'
        ],
        'sales.order.cancel.after' => [
            'AppModule\Admin\Listeners\Order@sendCancelOrderMail'
        ],
        'sales.refund.save.after' => [
            'AppModule\Admin\Listeners\Order@refundOrder',
            'AppModule\Admin\Listeners\Order@sendNewRefundMail',
        ],
        'sales.order.comment.create.after' => [
            'AppModule\Admin\Listeners\Order@sendOrderCommentMail'
        ],
        'core.channel.update.after' => [
            'AppModule\Admin\Listeners\ChannelSettingsChange@checkForMaintenanceMode'
        ],
    ];
}
