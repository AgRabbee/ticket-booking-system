<?php

namespace App\Repositories\Payment;

use App\Models\PaymentDetail;

class PaymentRepository
{
    public function create(array $data): PaymentDetail
    {
        return PaymentDetail::create($data);
    }
}
