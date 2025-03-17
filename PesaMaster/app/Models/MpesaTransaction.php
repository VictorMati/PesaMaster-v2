<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id', 'user_id', 'phone_number', 'amount',
        'status', 'receipt_number', 'date', 'response_code', 'response_message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
