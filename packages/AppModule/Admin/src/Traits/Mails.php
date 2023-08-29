<?php

namespace AppModule\Admin\Traits;

use Illuminate\Support\Facades\Mail;
use AppModule\Admin\Mail\CancelOrderAdminNotification;
use AppModule\Admin\Mail\CancelOrderNotification;
use AppModule\Admin\Mail\DuplicateInvoiceNotification;
use AppModule\Admin\Mail\NewAdminNotification;
use AppModule\Admin\Mail\NewInventorySourceNotification;
use AppModule\Admin\Mail\NewInvoiceNotification;
use AppModule\Admin\Mail\NewOrderNotification;
use AppModule\Admin\Mail\NewRefundNotification;
use AppModule\Admin\Mail\NewShipmentNotification;
use AppModule\Admin\Mail\OrderCommentNotification;

trait Mails
{
    /**
     * Send new order Mail to the customer and admin.
     *
     * @param  \AppModule\Sales\Contracts\Order  $order
     * @return void
     */
    public function sendNewOrderMail($order)
    {
        $customerLocale = $this->getLocale($order);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-order';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new NewOrderNotification($order));
            }

            /**
             * Email to admin.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-admin';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail(config('app.locale'), new NewAdminNotification($order));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send new invoice mail to the customer.
     *
     * @param  \AppModule\Sales\Contracts\Invoice  $invoice
     * @return void
     */
    public function sendNewInvoiceMail($invoice)
    {
        $customerLocale = $this->getLocale($invoice);

        try {
            if ($invoice->email_sent) {
                return;
            }

            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-invoice';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new NewInvoiceNotification($invoice));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send duplicate invoice mail to the customer.
     *
     * @param  \AppModule\Sales\Contracts\Invoice  $invoice
     * @param  string  $customerEmail
     * @return void
     */
    public function sendDuplicateInvoiceMail($invoice, $customerEmail)
    {
        $customerLocale = $this->getLocale($invoice);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-invoice';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new DuplicateInvoiceNotification($invoice, $customerEmail));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send new refund mail to the customer.
     *
     * @param  \AppModule\Sales\Contracts\Refund  $refund
     * @return void
     */
    public function sendNewRefundMail($refund)
    {
        $customerLocale = $this->getLocale($refund);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-refund';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new NewRefundNotification($refund));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send new shipment mail to the customer.
     *
     * @param  \AppModule\Sales\Contracts\Shipment  $shipment
     * @return void
     */
    public function sendNewShipmentMail($shipment)
    {
        $customerLocale = $this->getLocale($shipment);
        
        try {
            if ($shipment->email_sent) {
                return;
            }

            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-shipment';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new NewShipmentNotification($shipment));
            }

            /**
             * Email to inventory source.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-inventory-source';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail(config('app.locale'), new NewInventorySourceNotification($shipment));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send cancel order mail.
     *
     * @param  \AppModule\Sales\Contracts\Order  $order
     * @return void
     */
    public function sendCancelOrderMail($order)
    {
        $customerLocale = $this->getLocale($order);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.cancel-order';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new CancelOrderNotification($order));
            }

            /**
             * Email to admin.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-admin';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail(config('app.locale'), new CancelOrderAdminNotification($order));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send order comment mail.
     *
     * @param  \AppModule\Sales\Contracts\OrderComment  $comment
     * @return void
     */
    public function sendOrderCommentMail($comment)
    {
        $customerLocale = $this->getLocale($comment);

        if (! $comment->customer_notified) {
            return;
        }

        try {
            /**
             * Email to customer.
             */
            $this->prepareMail($customerLocale, new OrderCommentNotification($comment));
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Get the locale of the customer if somehow item name changes then the english locale will pe provided.
     *
     * @param object \AppModule\Sales\Contracts\Order|\AppModule\Sales\Contracts\Invoice|\AppModule\Sales\Contracts\Refund|\AppModule\Sales\Contracts\Shipment|\AppModule\Sales\Contracts\OrderComment
     * @return string
     */
    private function getLocale($object)
    {
        if ($object instanceof \AppModule\Sales\Contracts\OrderComment) {
            $object = $object->order;
        }

        $objectFirstItem = $object->items->first();

        return $objectFirstItem->additional['locale'] ?? 'en';
    }

    /**
     * Prepare mail.
     *
     * @return void
     */
    private function prepareMail($locale, $notification)
    {
        $previousLocale = core()->getCurrentLocale()->code;

        app()->setLocale($locale);

        try {
            Mail::queue($notification);
        } catch(\Exception $e) {
            app()->setLocale($previousLocale);
            
            \Log::error(
                'prepareMail' . $e->getMessage()
            );
        }

        app()->setLocale($previousLocale);
    }
}
