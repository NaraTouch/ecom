<?php

namespace AppModule\Admin\Listeners;

use Illuminate\Support\Facades\Mail;
use AppModule\User\Notifications\AdminUpdatePassword;
use AppModule\Customer\Notifications\CustomerUpdatePassword;
use AppModule\Customer\Models\Customer;
use AppModule\User\Models\Admin;

class PasswordChange
{
    /**
     * Send mail on updating password.
     *
     * @param  \AppModule\Customer\Models\Customer|\AppModule\User\Models\Admin  $adminOrCustomer
     * @return void
     */
    public function sendUpdatePasswordMail($adminOrCustomer)
    {
        try {
            if ($adminOrCustomer instanceof Customer) {
                Mail::queue(new CustomerUpdatePassword($adminOrCustomer));
            } elseif ($adminOrCustomer instanceof Admin) {
                Mail::queue(new AdminUpdatePassword($adminOrCustomer));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }
}