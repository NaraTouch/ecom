<?php

namespace AppModule\Payment\Payment;

class MoneyTransfer extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'moneytransfer';

    public function getRedirectUrl()
    {
        
    }

    /**
     * Returns payment method additional information
     *
     * @return array
     */
    public function getAdditionalDetails()
    {
        if (empty($this->getConfigData('mailing_address'))) {
            return [];
        }

        return [
            'title' => trans('admin::app.admin.system.mailing-address'),
            'value' => $this->getConfigData('mailing_address'),
        ];
    }
}