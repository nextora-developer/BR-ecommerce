<x-app-layout>
    @php
        $items = $rewards;
        $n = max(1, $items->count());

        // 更“街机”的高饱和配色（霓虹）
        $palette = [
            '#22c55e', // neon green
            '#facc15', // neon yellow
            '#38bdf8', // cyan
            '#fb7185', // pink
            '#a78bfa', // purple
            '#fb923c', // orange
            '#f43f5e', // rose/red
            '#2dd4bf', // teal
        ];

        $step = 360 / $n;

        $stops = [];
        for ($i = 0; $i < $n; $i++) {
            $start = $i * $step;
            $end = ($i + 1) * $step;
            $color = $palette[$i % count($palette)];
            $stops[] = "{$color} {$start}deg {$end}deg";
        }
        $conic = implode(",\n", $stops);

        $credits = (int) (auth()->user()?->spin_credits ?? 0);
    @endphp

    <style>
        /* =========================
           ARCADE NEON GRID PATTERN
           ========================= */
        .arcade-page {
            min-height: calc(100vh - 64px);
            padding: 22px 16px 180px;
            display: grid;
            place-items: center;

            /* base */
            background:
                radial-gradient(1200px 700px at 50% -10%, rgba(168, 85, 247, .45), transparent 60%),
                radial-gradient(900px 600px at 10% 20%, rgba(56, 189, 248, .28), transparent 55%),
                linear-gradient(180deg, #05060a 0%, #090a12 50%, #05060a 100%);
            position: relative;
            overflow: hidden;
        }

        /* neon grid */
        .arcade-page::before {
            content: "";
            position: absolute;
            inset: -40px;
            background:
                repeating-linear-gradient(0deg,
                    rgba(56, 189, 248, .14) 0px,
                    rgba(56, 189, 248, .14) 1px,
                    transparent 1px,
                    transparent 40px),
                repeating-linear-gradient(90deg,
                    rgba(168, 85, 247, .12) 0px,
                    rgba(168, 85, 247, .12) 1px,
                    transparent 1px,
                    transparent 40px);
            opacity: .35;
            transform: perspective(900px) rotateX(58deg) translateY(140px);
            transform-origin: top center;
            pointer-events: none;
            filter: drop-shadow(0 0 22px rgba(56, 189, 248, .22));
        }

        /* scanline */
        .arcade-page::after {
            content: "";
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(180deg,
                    rgba(255, 255, 255, .00) 0px,
                    rgba(255, 255, 255, .00) 5px,
                    rgba(255, 255, 255, .045) 6px);
            opacity: .18;
            pointer-events: none;
            mix-blend-mode: overlay;
            animation: scan 3.2s linear infinite;
        }

        @keyframes scan {
            0% {
                transform: translateY(-18px);
            }

            100% {
                transform: translateY(18px);
            }
        }

        /* floating glow blobs */
        .blob {
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 999px;
            filter: blur(50px);
            opacity: .35;
            pointer-events: none;
        }

        .blob.a {
            left: -180px;
            top: -140px;
            background: radial-gradient(circle at 30% 30%, rgba(56, 189, 248, .8), transparent 55%);
            animation: driftA 10s ease-in-out infinite;
        }

        .blob.b {
            right: -200px;
            top: 60px;
            background: radial-gradient(circle at 30% 30%, rgba(168, 85, 247, .8), transparent 55%);
            animation: driftB 12s ease-in-out infinite;
        }

        .blob.c {
            left: 10%;
            bottom: -260px;
            background: radial-gradient(circle at 30% 30%, rgba(250, 204, 21, .55), transparent 55%);
            animation: driftC 14s ease-in-out infinite;
        }

        @keyframes driftA {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(60px, 30px) scale(1.05);
            }
        }

        @keyframes driftB {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(-70px, 40px) scale(1.06);
            }
        }

        @keyframes driftC {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(50px, -40px) scale(1.04);
            }
        }

        /* =========================
           LAYOUT SHELL
           ========================= */
        .arcade-shell {
            position: relative;
            z-index: 5;
            width: min(980px, 100%);
            display: grid;
            gap: 14px;
        }

        .arcade-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .92);
            font-weight: 1000;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-size: 11px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .25);
        }

        .brand-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #facc15;
            box-shadow: 0 0 18px rgba(250, 204, 21, .75);
        }

        .credits-box {
            padding: 10px 14px;
            border-radius: 18px;
            background: rgba(0, 0, 0, .35);
            border: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .9);
            text-align: right;
            line-height: 1.1;
            box-shadow: 0 18px 55px rgba(0, 0, 0, .28);
        }

        .credits-box .sub {
            font-size: 12px;
            opacity: .70;
        }

        .credits-box .num {
            margin-top: 4px;
            font-size: 30px;
            font-weight: 1000;
            color: #facc15;
            text-shadow: 0 14px 40px rgba(0, 0, 0, .55);
        }

        /* content grid */
        .arcade-grid {
            display: grid;
            gap: 14px;
        }

        @media (min-width: 1024px) {
            .arcade-grid {
                grid-template-columns: 1.1fr .9fr;
                align-items: start;
            }
        }

        /* glass panel */
        .panel {
            border-radius: 22px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            box-shadow: 0 30px 90px rgba(0, 0, 0, .35);
            backdrop-filter: blur(10px);
            overflow: hidden;
            position: relative;
        }

        .panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(700px 250px at 25% 0%, rgba(56, 189, 248, .12), transparent 60%);
            pointer-events: none;
        }

        .panel-hd {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, .10);
        }

        .panel-title {
            font-size: 15px;
            font-weight: 1000;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .82);
        }

        .panel-body {
            padding: 14px 16px 16px;
            color: rgba(255, 255, 255, .92);
        }

        /* =========================
           WHEEL
           ========================= */
        .wheel-stage {
            padding: 16px;
        }

        .wheel-wrap {
            position: relative;
            width: 320px;
            height: 320px;
            margin: 8px auto 4px;
        }

        @media (min-width: 640px) {
            .wheel-wrap {
                width: 420px;
                height: 420px;
            }
        }

        /* pointer: neon */
        .pointer {
            position: absolute;
            left: 50%;
            top: -10px;
            transform: translateX(-50%);
            z-index: 40;
            width: 0;
            height: 0;
            border-left: 22px solid transparent;
            border-right: 22px solid transparent;
            border-top: 46px solid #facc15;
            filter:
                drop-shadow(0 18px 28px rgba(0, 0, 0, .45)) drop-shadow(0 0 18px rgba(250, 204, 21, .35));
        }

        .pointer::after {
            content: "";
            position: absolute;
            left: 50%;
            top: -34px;
            transform: translateX(-50%);
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #0b1220;
            border: 3px solid rgba(255, 255, 255, .85);
            box-shadow: 0 0 22px rgba(56, 189, 248, .25);
        }

        /* outer neon ring */
        .wheel-ring {
            position: absolute;
            inset: 0;
            border-radius: 999px;
            padding: 16px;
            background:
                radial-gradient(circle at 35% 25%, rgba(255, 255, 255, .18), rgba(255, 255, 255, .05) 40%, rgba(0, 0, 0, .25) 78%),
                linear-gradient(135deg, rgba(56, 189, 248, .20), rgba(168, 85, 247, .18));
            box-shadow:
                0 30px 90px rgba(0, 0, 0, .42),
                0 0 0 1px rgba(255, 255, 255, .10) inset;
        }

        .wheel {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 999px;
            background: conic-gradient({!! $conic !!});
            overflow: hidden;
            transition: transform 4s cubic-bezier(.15, .85, .22, 1);
            will-change: transform;
        }

        /* highlight + vignette */
        .wheel::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 999px;
            background:
                radial-gradient(circle at 28% 18%, rgba(255, 255, 255, .30), rgba(255, 255, 255, 0) 46%),
                radial-gradient(circle at 55% 60%, rgba(0, 0, 0, .35), rgba(0, 0, 0, 0) 60%),
                radial-gradient(circle at 50% 50%, rgba(0, 0, 0, 0), rgba(0, 0, 0, .22) 72%);
            pointer-events: none;
        }

        /* bulbs */
        .bulbs {
            position: absolute;
            inset: 8px;
            border-radius: 999px;
            pointer-events: none;
            z-index: 30;
        }

        .bulb {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 0 12px rgba(255, 255, 255, .85);
            opacity: .95;
        }

        .bulb.dim {
            opacity: .35;
            box-shadow: 0 0 8px rgba(255, 255, 255, .28);
        }

        /* labels */
        .labels {
            position: absolute;
            inset: 0;
            z-index: 20;
            pointer-events: none;
        }

        .label {
            position: absolute;
            left: 50%;
            top: 50%;
            translate: -50% -50%;
            font-weight: 1000;
            font-size: clamp(12px, 2.6vw, 16px);
            letter-spacing: .02em;
            color: rgba(255, 255, 255, .96);
            text-shadow: 0 12px 22px rgba(0, 0, 0, .45);
            white-space: nowrap;
            text-align: center;
            user-select: none;
        }

        /* center button */
        .center {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            z-index: 35;
        }

        .spin-btn {
            width: 98px;
            height: 98px;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 30%, rgba(56, 189, 248, .55), rgba(11, 18, 32, .9) 55%, rgba(0, 0, 0, .9) 100%);
            border: 10px solid rgba(255, 255, 255, .88);
            box-shadow:
                0 24px 55px rgba(0, 0, 0, .50),
                0 0 0 1px rgba(56, 189, 248, .25) inset,
                0 0 30px rgba(56, 189, 248, .20);
            color: white;
            font-weight: 1000;
            font-size: 20px;
            letter-spacing: .08em;
            cursor: pointer;
            transition: transform .12s ease, filter .12s ease;
        }

        .spin-btn:hover {
            filter: brightness(1.06);
        }

        .spin-btn:active {
            transform: scale(.98);
        }

        .spin-btn:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        /* =========================
           RIGHT PANEL (RESULT / INFO)
           ========================= */
        .big-value {
            font-size: 24px;
            font-weight: 1000;
            margin-top: 6px;
        }

        .muted {
            margin-top: 6px;
            font-size: 12px;
            opacity: .72;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(0, 0, 0, .30);
            color: rgba(255, 255, 255, .88);
            font-size: 12px;
            font-weight: 800;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: rgba(250, 204, 21, .95);
            box-shadow: 0 0 14px rgba(250, 204, 21, .55);
        }

        /* =========================
           MODAL
           ========================= */
        .modal {
            position: fixed;
            inset: 0;
            z-index: 200;
            display: none;
        }

        .modal.show {
            display: block;
        }

        .modal .bg {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .78);
            backdrop-filter: blur(8px);
        }

        .modal .box {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: min(420px, 92%);
            border-radius: 24px;
            background: rgba(8, 10, 18, .96);
            border: 1px solid rgba(255, 255, 255, .14);
            box-shadow: 0 35px 110px rgba(0, 0, 0, .70);
            padding: 18px;
            color: white;
            overflow: hidden;
        }

        .modal .box::before {
            content: "";
            position: absolute;
            inset: -2px;
            background: radial-gradient(700px 280px at 30% 0%, rgba(56, 189, 248, .18), transparent 60%);
            pointer-events: none;
        }

        .modal .kicker {
            position: relative;
            z-index: 2;
            font-size: 11px;
            font-weight: 1000;
            letter-spacing: .14em;
            text-transform: uppercase;
            opacity: .70;
        }

        .modal .headline {
            position: relative;
            z-index: 2;
            margin-top: 10px;
            font-size: 28px;
            font-weight: 1000;
            line-height: 1.05;
        }

        .modal .sub {
            position: relative;
            z-index: 2;
            margin-top: 8px;
            font-size: 14px;
            opacity: .80;
        }

        .modal .ok {
            position: relative;
            z-index: 2;
            margin-top: 14px;
            width: 100%;
            border-radius: 16px;
            padding: 12px 14px;
            font-weight: 1000;
            background: #facc15;
            color: #111827;
            border: none;
            cursor: pointer;
            transition: transform .12s ease;
        }

        .modal .ok:active {
            transform: scale(.99);
        }
    </style>

    <div class="arcade-page">
        <div class="blob a"></div>
        <div class="blob b"></div>
        <div class="blob c"></div>

        <div class="arcade-shell">

            <div class="arcade-top">
                <div class="brand-pill">
                    <span class="brand-dot"></span>
                    BRIF SPIN WHEEL
                </div>

                <div class="credits-box">
                    <div class="sub">Available Spins</div>
                    <div id="remainUI" class="num">{{ $credits }}</div>
                </div>
            </div>

            <div class="arcade-grid">
                {{-- LEFT: WHEEL --}}
                <div class="panel">
                    <div class="panel-hd">
                        <div class="panel-title">Spin Wheel</div>
                        <div class="status-pill">
                            <span class="status-dot"></span>
                            <span id="status">Ready</span>
                        </div>
                    </div>

                    <div class="panel-body wheel-stage">
                        <div class="wheel-wrap">
                            <div class="pointer"></div>

                            <div class="wheel-ring">
                                <div id="wheel" class="wheel" style="transform: rotate(0deg);">

                                    {{-- labels --}}
                                    <div class="labels">
                                        @foreach ($items as $i => $r)
                                            @php
                                                $angle = $i * $step;
                                                $mid = $angle + $step / 2;
                                            @endphp

                                            <div class="label"
                                                style="
                                                    transform:
                                                        rotate({{ $mid }}deg)
                                                        translateY(calc(-1 * clamp(92px, 12vw, 140px)))
                                                        rotate(-{{ $mid }}deg);
                                                ">
                                                {{ $r->points }} pts
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- bulbs --}}
                                    <div id="bulbs" class="bulbs"></div>

                                    {{-- center --}}
                                    <div class="center">
                                        <button id="spinBtn" class="spin-btn">SPIN</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="muted" style="text-align:center; font-size: 13px;">
                            Tip: More purchases = more spins. Rewards are credited instantly.
                        </div>
                    </div>
                </div>

                {{-- RIGHT: RESULT / FEED --}}
                <div class="grid gap-3">
                    {{-- Card 1: Result --}}
                    <div class="panel">
                        <div class="panel-hd">
                            <div class="panel-title">Result Panel</div>
                            <div class="panel-title" style="opacity:.65;">Live</div>
                        </div>

                        <div class="panel-body">
                            <div class="panel-title" style="opacity:.75;">Latest Result</div>
                            <div id="result" class="big-value">—</div>
                            <div class="muted" id="hint" style="font-size: 13px;">
                                Press SPIN to play. Your credits are verified by server.
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Rules --}}
                    <div class="panel">
                        <div class="panel-hd">
                            <div class="panel-title">Rules</div>
                        </div>

                        <div class="panel-body">
                            <div class="muted" style="line-height:1.6; font-size:13px;">
                                🎟️ <strong>Every spin consumes 1 chance.</strong><br>
                                🎯 Watch the wheel stop to see what you win!<br>
                                🔄 If something goes wrong, just try again.<br>
                                <br>
                                <strong>How to get chances:</strong> <br>
                                Complete purchases or special activities to earn
                                more spin chances.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- modal --}}
    <div id="modal" class="modal">
        <div class="bg"></div>
        <div class="box">
            <div class="kicker">Congratulations</div>
            <div id="modalTitle" class="headline">—</div>
            <div id="modalSub" class="sub">—</div>
            <button id="modalOk" class="ok">OK</button>
        </div>
    </div>

    <script>
        (function() {
            const wheel = document.getElementById('wheel');
            const bulbs = document.getElementById('bulbs');
            const btn = document.getElementById('spinBtn');
            const status = document.getElementById('status');
            const result = document.getElementById('result');
            const remainUI = document.getElementById('remainUI');

            const modal = document.getElementById('modal');
            const modalTitle = document.getElementById('modalTitle');
            const modalSub = document.getElementById('modalSub');
            const modalOk = document.getElementById('modalOk');

            const n = {{ $items->count() }};
            const step = 360 / n;

            let spinning = false;
            let rotation = 0;

            // ✅ credits 由 server 扣；前端只显示
            let credits = Number({{ (int) ($credits ?? 0) }});

            function buildBulbs(count = 22) {
                if (!bulbs) return;
                bulbs.innerHTML = '';
                const rect = bulbs.getBoundingClientRect();
                const cx = rect.width / 2;
                const cy = rect.height / 2;
                const radius = Math.min(cx, cy) - 6;

                for (let i = 0; i < count; i++) {
                    const ang = (i / count) * Math.PI * 2;
                    const x = cx + Math.cos(ang - Math.PI / 2) * radius;
                    const y = cy + Math.sin(ang - Math.PI / 2) * radius;

                    const d = document.createElement('div');
                    d.className = 'bulb' + (i % 2 === 0 ? '' : ' dim');
                    d.style.left = (x - 6) + 'px';
                    d.style.top = (y - 6) + 'px';
                    bulbs.appendChild(d);
                }
            }

            let blinkOn = false;
            setInterval(() => {
                if (!bulbs) return;
                const all = bulbs.querySelectorAll('.bulb');
                blinkOn = !blinkOn;
                all.forEach((b, i) => {
                    b.classList.toggle('dim', blinkOn ? (i % 2 === 0) : (i % 2 !== 0));
                });
            }, 260);

            function openModal(title, sub) {
                if (!modal) return;
                modalTitle.textContent = title;
                modalSub.textContent = sub;
                modal.classList.add('show');
            }

            function closeModal() {
                modal?.classList.remove('show');
            }

            modalOk?.addEventListener('click', closeModal);
            modal?.querySelector('.bg')?.addEventListener('click', closeModal);

            setTimeout(() => buildBulbs(22), 30);
            window.addEventListener('resize', () => buildBulbs(22));

            function setCredits(next) {
                credits = Math.max(0, Number(next || 0));
                if (remainUI) remainUI.textContent = String(credits);
            }

            async function spin() {
                if (spinning) return;

                if (credits <= 0) {
                    status.textContent = 'No spins available';
                    result.textContent = '—';
                    return;
                }

                spinning = true;
                btn.disabled = true;
                status.textContent = 'Spinning...';
                result.textContent = '—';

                try {
                    const res = await fetch("{{ route('games.spin.play') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                        },
                        body: JSON.stringify({})
                    });

                    const data = await res.json().catch(() => ({}));

                    if (!res.ok || !data.ok) {
                        throw new Error(data.message || `Request failed (${res.status})`);
                    }

                    const idx = Number(data.landing_index ?? 0);

                    // pointer 在 top，目标：把 idx 对应那块的中线转到 pointer
                    const target = 360 - (idx * step + step / 2);

                    const spins = 7;
                    const cur = ((rotation % 360) + 360) % 360;

                    let diff = target - cur;
                    diff = ((diff % 360) + 360) % 360;

                    rotation += spins * 360 + diff;
                    wheel.style.transform = `rotate(${rotation}deg)`;

                    setTimeout(() => {
                        status.textContent = 'Done';
                        result.textContent = `${data.reward.name} (+${data.reward.points} pts)`;

                        if (data.credits_left != null) {
                            setCredits(data.credits_left);
                        } else {
                            setCredits(credits - 1);
                        }

                        openModal(data.reward.name, `You got +${data.reward.points} points.`);
                        spinning = false;
                        btn.disabled = false;
                    }, 4050);

                } catch (e) {
                    status.textContent = 'Error';
                    result.textContent = e?.message || 'Something went wrong';
                    spinning = false;
                    btn.disabled = false;
                }
            }

            btn?.addEventListener('click', spin);
        })();
    </script>
</x-app-layout>
