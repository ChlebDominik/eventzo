<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tvoje lístky — {{ $order->event->title }}</title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #07070f; font-family: 'Helvetica Neue', Arial, sans-serif; color: #f0eeff; -webkit-font-smoothing: antialiased; }
    .wrap { max-width: 580px; margin: 0 auto; padding: 2rem 1rem; }
    .header { background: #0f0f1a; border: 1px solid rgba(255,255,255,0.07); border-radius: 14px 14px 0 0; padding: 2rem 2.5rem 1.75rem; text-align: center; }
    .brand { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; color: #f0eeff; }
    .body { background: #0f0f1a; border-left: 1px solid rgba(255,255,255,0.07); border-right: 1px solid rgba(255,255,255,0.07); padding: 2rem 2.5rem; }
    .hero-label { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #9b7dff; margin-bottom: 0.5rem; }
    .event-title { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.5rem; }
    .meta { font-size: 0.85rem; color: rgba(240,238,255,0.5); margin-bottom: 2rem; }
    .meta span { margin-right: 1rem; }
    .summary { background: #16162a; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 1.25rem 1.5rem; margin-bottom: 2rem; }
    .summary-row { display: flex; justify-content: space-between; padding: 0.35rem 0; }
    .summary-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; color: rgba(240,238,255,0.4); }
    .summary-value { font-size: 0.9rem; font-weight: 600; color: #f0eeff; }
    .tickets-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(240,238,255,0.4); margin-bottom: 0.75rem; }
    .ticket-card { background: #16162a; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 1.5rem; margin-bottom: 0.75rem; text-align: center; }
    .ticket-type { font-size: 1rem; font-weight: 700; margin-bottom: 0.25rem; }
    .ticket-code { font-family: monospace; font-size: 0.68rem; color: rgba(240,238,255,0.3); margin-bottom: 1.25rem; word-break: break-all; }
    .qr-wrap { background: #ffffff; display: inline-block; padding: 1rem; border-radius: 10px; margin-bottom: 0.75rem; }
    .cta-wrap { text-align: center; margin: 2rem 0; }
    .cta { display: inline-block; background: #7c5cfc; color: #fff; font-size: 0.9rem; font-weight: 700; padding: 0.85rem 2rem; border-radius: 8px; text-decoration: none; }
    .divider { border: none; border-top: 1px solid rgba(255,255,255,0.07); margin: 1.75rem 0; }
    .footer { background: #0a0a14; border: 1px solid rgba(255,255,255,0.07); border-radius: 0 0 14px 14px; padding: 1.5rem 2.5rem; text-align: center; }
    .footer p { font-size: 0.78rem; color: rgba(240,238,255,0.3); line-height: 1.7; }
    .amount { color: #9b7dff; font-weight: 700; }
</style>
</head>
<body>
<div class="wrap">

    <div class="header">
        <div class="brand">● EventZo</div>
        <p style="font-size:0.82rem;color:rgba(240,238,255,0.4);margin-top:0.4rem;">Potvrdenie objednávky</p>
    </div>

    <div class="body">
        <p class="hero-label">Nákup úspešný 🎉</p>
        <h1 class="event-title">{{ $order->event->title }}</h1>
        <p class="meta">
            <span>📍 {{ $order->event->location }}</span>
            <span>📅 {{ $order->event->start_date->format('d.m.Y H:i') }}</span>
        </p>

        <div class="summary">
            <div class="summary-row">
                <span class="summary-label">Objednávka</span>
                <span class="summary-value">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Zaplatená suma</span>
                <span class="summary-value amount">{{ number_format($order->total_cents / 100, 2) }} €</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Počet lístkov</span>
                <span class="summary-value">{{ $order->tickets->count() }} ks</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Dátum nákupu</span>
                <span class="summary-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
            </div>
        </div>

        <p class="tickets-label">Tvoje lístky</p>

        @foreach($order->tickets as $ticket)
        <div class="ticket-card">
            <div class="ticket-type">{{ $ticket->ticketType->name }}</div>
            <div class="ticket-code">{{ $ticket->code }}</div>
            @if(isset($ticketQrUrls[$ticket->code]))
                <div class="qr-wrap">
                    <img src="{{ $ticketQrUrls[$ticket->code] }}"
                         width="200" height="200" alt="QR kód">
                </div>
            @endif
            <div style="font-size:0.75rem;color:rgba(240,238,255,0.35);">Lístok {{ $loop->iteration }} z {{ $loop->count }}</div>
        </div>
        @endforeach

        <div class="cta-wrap">
            <a href="{{ route('orders.show', $order) }}" class="cta">Zobraziť objednávku →</a>
        </div>

        <hr class="divider">
        <p style="font-size:0.83rem;color:rgba(240,238,255,0.45);line-height:1.7;">
            Ukáž QR kód pri vstupe na event. Lístky sú viazané na účet <strong style="color:rgba(240,238,255,0.7);">{{ $order->user->email }}</strong>.
        </p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} EventZo — Toto je automaticky generovaný email, neodpovedaj naň.</p>
    </div>

</div>
</body>
</html>