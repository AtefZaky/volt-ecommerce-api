<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'city',
        'address',
        'postal_code',
        'phone_number',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
