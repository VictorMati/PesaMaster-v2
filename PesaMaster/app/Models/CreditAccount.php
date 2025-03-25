<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'credit_limit',
        'current_balance',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }
}
