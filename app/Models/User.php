<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'balance_cents',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Role helpers ────────────────────────────────────────────────────────

    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class)->latest();
    }

    // ── Wallet helpers ───────────────────────────────────────────────────────

    /** Formatted balance for display, e.g. "12.50 €" */
    public function formattedBalance(): string
    {
        return number_format($this->balance_cents / 100, 2) . ' €';
    }

    /** Whether the user can afford the given cent amount */
    public function canAfford(int $cents): bool
    {
        return $this->balance_cents >= $cents;
    }

    /**
     * Add funds to the wallet (top-up).
     * Returns the created WalletTransaction.
     */
    public function topUp(int $cents, string $description = 'Dobíjanie kreditu'): WalletTransaction
    {
        return DB::transaction(function () use ($cents, $description) {
            $this->increment('balance_cents', $cents);

            return $this->walletTransactions()->create([
                'type'         => 'topup',
                'amount_cents' => $cents,
                'description'  => $description,
            ]);
        });
    }

    /**
     * Deduct funds from the wallet (purchase).
     * Throws \RuntimeException if balance is insufficient.
     * Returns the created WalletTransaction.
     */
    public function deduct(int $cents, string $description = 'Nákup lístka', ?Order $order = null): WalletTransaction
    {
        return DB::transaction(function () use ($cents, $description, $order) {
            $this->refresh()->lockForUpdate();

            if ($this->balance_cents < $cents) {
                throw new \RuntimeException('Nedostatok kreditu na peňaženke.');
            }

            $this->decrement('balance_cents', $cents);

            $data = [
                'type'         => 'purchase',
                'amount_cents' => -$cents,
                'description'  => $description,
            ];

            if ($order) {
                $data['reference_type'] = Order::class;
                $data['reference_id']   = $order->id;
            }

            return $this->walletTransactions()->create($data);
        });
    }
}