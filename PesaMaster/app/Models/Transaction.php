<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_id', 'amount', 'type', 'transaction_date',
        'status', 'description', 'payment_method', 'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function mpesaTransaction()
    {
        return $this->hasOne(MpesaTransaction::class);
    }
}
