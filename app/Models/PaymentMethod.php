<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'pay_name',
        'bank_name',
        'bank_account_no',
        'bank_account_name',
        'bank_account_type',
        'bank_ifsc',
        'razorpay_key',
        'razorpay_secret',
        'salt',
        'merchant_id',
        'merchant_key',
        'status'
    ];
}
