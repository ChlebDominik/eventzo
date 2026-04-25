@extends('layouts.app')
@section('title','Check-in — '.$event->title)
@section('content')
<div style="max-width:620px;margin:0 auto;">

    <a href="{{ route('events.show', $event) }}" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:var(--muted);text-decoration:none;margin-bottom:1.75rem;transition:color 0.2s;" onmouseenter="this.style.color='var(--text)'" onmouseleave="this.style.color='var(--muted)'">
        ← Späť na event
    </a>

    <div class="fade-up" style="margin-bottom:2rem;">
        <span class="badge badge-violet" style="margin-bottom:0.75rem;">Check-in skener</span>
        <h1 class="heading" style="font-size:2rem;">{{ $event->title }}</h1>
    </div>

    {{-- RESULT BANNER --}}
    <div id="resultBanner" style="display:none;padding:1rem 1.25rem;border-radius:var(--radius-sm);font-size:0.95rem;font-weight:600;margin-bottom:1.5rem;text-align:center;border:1px solid;transition:all 0.3s;"></div>

    @if(session('checkin_success'))
        <div class="alert alert-success fade-up" style="margin-bottom:1.5rem;">{{ session('checkin_success') }}</div>
    @endif
    @if(session('checkin_error'))
        <div class="alert alert-error fade-up" style="margin-bottom:1.5rem;">{{ session('checkin_error') }}</div>
    @endif

    {{-- CAMERA SCANNER --}}
    <div class="card-glass fade-up fade-up-1" style="padding:1.75rem;margin-bottom:1rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:0.75rem;">
            <div>
                <p class="label" style="margin-bottom:0.2rem;">Kamera</p>
                <p style="font-size:0.8rem;color:var(--muted);">Namier kameru na QR kód lístka</p>
            </div>
            <button id="toggleCamera" class="btn btn-primary btn-sm">📷 Spustiť kameru</button>
        </div>

        {{-- Camera viewport --}}
        <div id="cameraWrap" style="display:none;position:relative;border-radius:var(--radius-sm);overflow:hidden;background:#000;aspect-ratio:4/3;">
            <video id="video" style="width:100%;height:100%;object-fit:cover;" playsinline muted></video>
            <canvas id="canvas" style="display:none;"></canvas>

            {{-- Scan frame overlay --}}
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
                <div style="width:200px;height:200px;position:relative;">
                    <div style="position:absolute;top:0;left:0;width:28px;height:28px;border-top:3px solid var(--violet2);border-left:3px solid var(--violet2);border-radius:3px 0 0 0;"></div>
                    <div style="position:absolute;top:0;right:0;width:28px;height:28px;border-top:3px solid var(--violet2);border-right:3px solid var(--violet2);border-radius:0 3px 0 0;"></div>
                    <div style="position:absolute;bottom:0;left:0;width:28px;height:28px;border-bottom:3px solid var(--violet2);border-left:3px solid var(--violet2);border-radius:0 0 0 3px;"></div>
                    <div style="position:absolute;bottom:0;right:0;width:28px;height:28px;border-bottom:3px solid var(--violet2);border-right:3px solid var(--violet2);border-radius:0 0 3px 0;"></div>
                    <div id="scanLine" style="position:absolute;top:0;left:4px;right:4px;height:2px;background:linear-gradient(90deg,transparent,var(--violet),transparent);animation:scanAnim 2s linear infinite;"></div>
                </div>
            </div>

            <div id="cameraStatus" style="position:absolute;bottom:0;left:0;right:0;padding:0.6rem;background:rgba(0,0,0,0.6);text-align:center;font-size:0.78rem;color:rgba(255,255,255,0.6);">
                Inicializujem kameru…
            </div>
        </div>
    </div>

    {{-- MANUAL ENTRY --}}
    <div class="card fade-up fade-up-2" style="padding:1.75rem;">
        <p class="label" style="margin-bottom:1rem;">Manuálne zadanie kódu</p>
        <form method="POST" action="{{ route('checkin.check', $event) }}" style="display:flex;gap:0.75rem;flex-wrap:wrap;">
            @csrf
            <input name="code" class="input" placeholder="UUID kód lístka…"
                   style="flex:1;min-width:200px;font-family:monospace;font-size:0.85rem;" autofocus autocomplete="off">
            <button class="btn btn-primary">Overiť →</button>
        </form>
    </div>

</div>

<style>
@keyframes scanAnim {
    0%   { top: 4px; opacity: 0.8; }
    50%  { opacity: 1; }
    100% { top: calc(100% - 6px); opacity: 0.8; }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
(function () {
    const toggleBtn    = document.getElementById('toggleCamera');
    const cameraWrap   = document.getElementById('cameraWrap');
    const video        = document.getElementById('video');
    const canvas       = document.getElementById('canvas');
    const cameraStatus = document.getElementById('cameraStatus');
    const resultBanner = document.getElementById('resultBanner');
    const ctx          = canvas.getContext('2d');

    const scanUrl  = @json(route('checkin.scan', $event));
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                   || '{{ csrf_token() }}';

    let stream = null;
    let scanning = false;
    let cooldown = false;

    toggleBtn.addEventListener('click', async () => {
        if (stream) {
            stopCamera();
        } else {
            await startCamera();
        }
    });

    async function startCamera() {
        cameraWrap.style.display = 'block';
        toggleBtn.textContent = '⏹ Zastaviť kameru';
        cameraStatus.textContent = 'Inicializujem kameru…';

        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' }
            });
            video.srcObject = stream;
            await video.play();
            scanning = true;
            cameraStatus.textContent = 'Namier na QR kód…';
            requestAnimationFrame(tick);
        } catch (e) {
            cameraStatus.textContent = '❌ Kamera nie je dostupná: ' + e.message;
        }
    }

    function stopCamera() {
        scanning = false;
        if (stream) {
            stream.getTracks().forEach(t => t.stop());
            stream = null;
        }
        video.srcObject = null;
        cameraWrap.style.display = 'none';
        toggleBtn.textContent = '📷 Spustiť kameru';
    }

    function tick() {
        if (!scanning) return;

        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert',
            });

            if (code && !cooldown) {
                cooldown = true;
                cameraStatus.textContent = '⏳ Overujem…';
                sendCode(code.data);
            }
        }

        requestAnimationFrame(tick);
    }

    async function sendCode(code) {
        try {
            const res = await fetch(scanUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ code }),
            });

            const data = await res.json();
            showResult(data.ok, data.message);
            cameraStatus.textContent = data.ok ? '✅ Overené! Namier na ďalší kód…' : '❌ Neplatný. Namier na ďalší kód…';

        } catch (e) {
            showResult(false, '❌ Chyba spojenia.');
            cameraStatus.textContent = 'Chyba. Skús znova.';
        }

        // Wait 3 seconds before scanning next code
        setTimeout(() => { cooldown = false; }, 3000);
    }

    function showResult(ok, message) {
        resultBanner.style.display = 'block';
        resultBanner.textContent = message;

        if (ok) {
            resultBanner.style.background = 'var(--green-dim)';
            resultBanner.style.borderColor = 'rgba(34,211,165,0.3)';
            resultBanner.style.color = 'var(--green)';
        } else {
            resultBanner.style.background = 'var(--red-dim)';
            resultBanner.style.borderColor = 'rgba(255,94,125,0.3)';
            resultBanner.style.color = 'var(--red)';
        }

        // Auto-hide after 4 seconds
        setTimeout(() => { resultBanner.style.display = 'none'; }, 4000);
    }
})();
</script>

{{-- CSRF meta tag needed for fetch --}}
@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@endsection