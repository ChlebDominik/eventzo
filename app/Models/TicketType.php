<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = [
        'event_id', 'name', 'price_cents', 'quantity',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /** How many tickets of this type have been sold */
    public function soldCount(): int
    {
        return $this->tickets()->count();
    }

    /** How many are still available */
    public function availableCount(): int
    {
        return max(0, $this->quantity - $this->soldCount());
    }
}