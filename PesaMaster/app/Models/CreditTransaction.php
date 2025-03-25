<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_account_id',
        'type',
        'amount',
        'description',
    ];

    public function creditAccount()
    {
        return $this->belongsTo(CreditAccount::class);
    }
}
