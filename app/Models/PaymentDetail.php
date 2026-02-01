<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 */
class PaymentDetail extends Model
{
    protected $fillable = [
        'user_id',
        'payment_status',
        'payment_type',
        'stripe_token',
        'user_address',
    ];
}
