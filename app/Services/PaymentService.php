<?php

namespace App\Services;

use Stripe\Charge;
use Stripe\Stripe;

class PaymentService
{
    public function charge(array $data): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        Charge::create([
            'amount'      => ($data['totalAmount'] + $data['fee']) * 100,
            'currency'    => 'usd',
            'source'      => $data['stripeToken'],
            'description' => 'Payment from Ticket Booking System.',
        ]);
    }
}
