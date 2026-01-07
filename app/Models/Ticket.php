<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'order_id', 'ticket_type_id', 'code', 'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'code'; // route model binding cez /tickets/{ticket}
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function checkin()
    {
        return $this->hasOne(Checkin::class);
    }

    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }
}
