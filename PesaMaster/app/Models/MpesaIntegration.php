<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_shortcode',
        'consumer_key',
        'consumer_secret',
        'passkey',
        'callback_url',
        'environment',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
