@extends('layouts.app')
@section('title', $event->title)
@section('content')

<div style="display:grid;grid-template-columns:1fr 360px;gap:2.5rem;align-items:start;">

    {{-- LEFT --}}
    <div>
        <a href="{{ route('events.index') }}" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:var(--muted);text-decoration:none;margin-bottom:1.75rem;transition:color 0.2s;" onmouseenter="this.style.color='var(--text)'" onmouseleave="this.style.color='var(--muted)'">
            ← Všetky eventy
        </a>

        @if($event->image)
            <img src="{{ asset('storage/'.$event->image) }}"
                 class="fade-up"
                 style="width:100%;max-height:420px;object-fit:cover;border-radius:var(--radius);margin-bottom:2rem;border:1px solid var(--border);">
        @endif

        <div class="fade-up" style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:0.6rem;">
            <h1 class="heading" style="font-size:2.5rem;">{{ $event->title }}</h1>
            @if($event->ticketTypes->count())
                @if($event->totalAvailable() === 0)
                    <span class="badge badge-red">Vypredané</span>
                @else
                    <span class="badge badge-green">{{ $event->totalAvailable() }} dostupných</span>
                @endif
            @endif
        </div>

        <div class="stat-row fade-up fade-up-1" style="margin-bottom:2rem;">
            <span>📍 {{ $event->location }}</span>
            <span style="color:var(--border2);">·</span>
            <span>📅 {{ $event->start_date->format('d.m.Y o H:i') }}</span>
            <span style="color:var(--border2);">·</span>
            <span>👤 {{ $event->organizer->name ?? '-' }}</span>
            @if($event->ticketTypes->count())
                <span style="color:var(--border2);">·</span>
                <span>🎟 {{ $event->totalCapacity() }} miest celkom</span>
            @endif
        </div>

        @if($event->description)
        <div class="card fade-up fade-up-2" style="margin-bottom:2rem;">
            <div class="card-body">
                <p style="color:var(--muted2);line-height:1.85;font-size:0.95rem;margin:0;">{{ $event->description }}</p>
            </div>
        </div>
        @endif

        {{-- MUSICIANS --}}
        @if($event->musicians->count())
        <div class="fade-up fade-up-3" style="margin-bottom:2rem;">
            <p class="label" style="margin-bottom:1rem;">Vystupujúci hudobníci</p>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:0.75rem;">
                @foreach($event->musicians as $musician)
                <div style="display:flex;align-items:center;gap:0.85rem;padding:0.9rem 1.1rem;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);transition:border-color 0.2s;" onmouseenter="this.style.borderColor='var(--border2)'" onmouseleave="this.style.borderColor='var(--border)'">
                    <div style="width:38px;height:38px;border-radius:50%;background:var(--violet-dim);border:1px solid rgba(124,92,252,0.3);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">🎵</div>
                    <div>
                        <p style="font-weight:600;font-size:0.9rem;margin-bottom:0.15rem;">{{ $musician->name }}</p>
                        @if($musician->genre)
                            <p style="font-size:0.75rem;color:var(--muted);">{{ $musician->genre }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($event->ticketTypes->count())
        <div class="fade-up fade-up-3">
            <p class="label" style="margin-bottom:1rem;">Typy lístkov</p>
            <div style="display:flex;flex-direction:column;gap:0.625rem;">
                @foreach($event->ticketTypes as $type)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);transition:border-color 0.2s;" onmouseenter="this.style.borderColor='var(--border2)'" onmouseleave="this.style.borderColor='var(--border)'">
                    <div>
                        <span style="font-weight:600;font-size:0.95rem;">{{ $type->name }}</span>
                        <div style="font-size:0.78rem;color:var(--muted);margin-top:0.2rem;">
                            {{ $type->availableCount() }} / {{ $type->quantity }} k dispozícii
                            @if($type->availableCount() === 0) <span class="badge badge-red" style="margin-left:0.4rem;">Vypredané</span> @endif
                        </div>
                    </div>
                    <span style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:700;color:{{ $type->price_cents === 0 ? 'var(--green)' : 'var(--violet2)' }};">
                        {{ $type->price_cents === 0 ? 'Zadarmo' : number_format($type->price_cents/100,2).' €' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- RIGHT --}}
    <div style="position:sticky;top:calc(var(--nav-h) + 1.5rem);">
        <div class="card-glass fade-up fade-up-1" style="padding:1.75rem;">

            @guest
                <p style="font-size:0.88rem;color:var(--muted);margin-bottom:1.5rem;line-height:1.7;">Prihlás sa a kúp si lístok na tento event.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-full" style="margin-bottom:0.6rem;">Prihlásiť sa</a>
                <a href="{{ route('register') }}" class="btn btn-ghost btn-full">Vytvoriť účet</a>

            @else
                @can('update', $event)
                    <p class="label" style="margin-bottom:1rem;">Správa eventu</p>
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-primary btn-full" style="margin-bottom:0.6rem;">✏️ Upraviť event</a>
                    <a href="{{ route('checkin.index', $event) }}" class="btn btn-ghost btn-full" style="margin-bottom:0.6rem;">✅ Check-in skener</a>
                    <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Naozaj vymazať?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-full">🗑 Vymazať event</button>
                    </form>

                @else
                    @if($event->ticketTypes && $event->ticketTypes->count())

                        {{-- Balance --}}
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 1rem;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:1.5rem;">
                            <span style="font-size:0.78rem;color:var(--muted);">Tvoj kredit</span>
                            <a href="{{ route('wallet.topup') }}" style="font-size:0.9rem;font-weight:700;color:var(--violet2);text-decoration:none;">
                                {{ auth()->user()->formattedBalance() }}
                                <span style="font-size:0.7rem;opacity:0.5;margin-left:0.3rem;">+ dobiť</span>
                            </a>
                        </div>

                        <form method="POST" action="{{ route('tickets.buy', $event) }}">
                            @csrf
                            <div class="field">
                                <label class="label">Typ lístka</label>
                                <select name="ticket_type_id" id="typeSelect" class="input">
                                    @foreach($event->ticketTypes as $type)
                                        <option value="{{ $type->id }}" data-price="{{ $type->price_cents }}" @if($type->availableCount()===0) disabled @endif>
                                            {{ $type->name }} — {{ $type->price_cents===0 ? 'Zadarmo' : number_format($type->price_cents/100,2).' €' }}
                                            @if($type->availableCount()===0) (vypredané) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label class="label">Počet lístkov</label>
                                <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="10" class="input">
                            </div>

                            <div id="totalBox" style="font-size:0.82rem;color:var(--muted);margin-bottom:0.75rem;min-height:1.2em;"></div>
                            <div id="balWarn" style="display:none;font-size:0.82rem;padding:0.65rem 0.9rem;background:var(--red-dim);border:1px solid rgba(255,94,125,0.2);border-radius:var(--radius-sm);color:var(--red);margin-bottom:0.75rem;">
                                Nedostatok kreditu. <a href="{{ route('wallet.topup') }}" style="color:var(--red);font-weight:700;">Dobiť →</a>
                            </div>

                            <button id="buyBtn" class="btn btn-primary btn-full btn-lg">Kúpiť lístok</button>
                        </form>

                        <script>
                        (function(){
                            const bal = {{ auth()->user()->balance_cents }};
                            const sel = document.getElementById('typeSelect');
                            const qty = document.getElementById('qtyInput');
                            const box = document.getElementById('totalBox');
                            const warn = document.getElementById('balWarn');
                            const btn = document.getElementById('buyBtn');
                            function upd(){
                                const price = parseInt(sel.selectedOptions[0]?.dataset.price)||0;
                                const q = parseInt(qty.value)||1;
                                const total = price*q;
                                box.textContent = total===0 ? '🎉 Zadarmo!' : 'Celkom: '+(total/100).toFixed(2)+' €';
                                const poor = total > bal;
                                warn.style.display = poor ? 'block' : 'none';
                                btn.disabled = poor;
                                btn.style.opacity = poor ? '0.45' : '1';
                            }
                            sel.addEventListener('change',upd);
                            qty.addEventListener('input',upd);
                            upd();
                        })();
                        </script>

                    @else
                        <div style="text-align:center;padding:2rem 0;color:var(--muted);font-size:0.88rem;">🎫 Lístky nie sú ešte nastavené.</div>
                    @endif
                @endcan
            @endguest
        </div>
    </div>

</div>
@endsection