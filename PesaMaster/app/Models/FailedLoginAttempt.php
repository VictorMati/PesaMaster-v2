<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedLoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'attempt_time', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
