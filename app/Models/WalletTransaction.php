<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'user_id', 'type', 'amount_cents', 'description',
        'reference_type', 'reference_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    /** Display-friendly signed euro amount, e.g. "+10.00 €" or "-5.50 €" */
    public function formattedAmount(): string
    {
        $sign = $this->amount_cents >= 0 ? '+' : '-';
        return $sign . number_format(abs($this->amount_cents) / 100, 2) . ' €';
    }
}