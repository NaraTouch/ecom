<?php

namespace AppModule\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewInventorySourceNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  \AppModule\Customer\Contracts\Shipment  $shipment
     * @return void
     */
    public function __construct(public $shipment)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->shipment->order;
        
        $inventory = $this->shipment->inventory_source;

        return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
            ->to($inventory->contact_email, $inventory->name)
            ->subject(trans('shop::app.mail.shipment.subject', ['order_id' => $order->increment_id]))
            ->view('shop::emails.sales.new-inventorysource-shipment');
    }
}
