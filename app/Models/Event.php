<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'location',
        'start_date',
        'image',
    ];

    protected $casts = [
        'start_date' => 'datetime',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /** Total capacity = sum of all ticket type quantities */
    public function totalCapacity(): int
    {
        return $this->ticketTypes->sum('quantity');
    }

    /** Total tickets sold across all ticket types */
    public function totalSold(): int
    {
        return $this->ticketTypes->sum(fn($t) => $t->soldCount());
    }

    /** Remaining tickets available for purchase */
    public function totalAvailable(): int
    {
        return max(0, $this->totalCapacity() - $this->totalSold());
    }
}