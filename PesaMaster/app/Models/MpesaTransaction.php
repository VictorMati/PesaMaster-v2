<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id', 'user_id', 'phone_number', 'amount',
        'status', 'receipt_number', 'transaction_date', 'response_code', 'response_message'
    ];

    // In your MpesaTransaction model
    const STATUSES = [
        'pending' => 'Pending',
        'completed' => 'Completed',
        'failed' => 'Failed',
        'reversed' => 'Reversed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // MpesaTransaction.php
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
