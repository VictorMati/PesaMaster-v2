<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'budget_limit',
        'current_expense',
        'status',
        'period',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExceeded()
    {
        return $this->current_expense > $this->budget_limit;
    }
}
