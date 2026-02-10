<x-app-layout>
    @php
        $items = $rewards;
        $n = max(1, $items->count());

        // 游戏风配色（饱和、像你那张图）
        $palette = [
            '#22c55e', // green
            '#facc15', // yellow
            '#0ea5e9', // sky
            '#ec4899', // pink
            '#a855f7', // purple
            '#f97316', // orange
            '#ef4444', // red
            '#14b8a6', // teal
        ];

        $step = 360 / $n;

        // 生成 conic-gradient 字符串：每个 reward 一块纯色
        $stops = [];
        for ($i = 0; $i < $n; $i++) {
            $start = $i * $step;
            $end = ($i + 1) * $step;
            $color = $palette[$i % count($palette)];
            $stops[] = "{$color} {$start}deg {$end}deg";
        }
        $conic = implode(",\n", $stops);
    @endphp

    <style>
        .spin-page {
            min-height: calc(100vh - 64px);
            display: grid;
            place-items: center;
            padding: 28px 16px 200px;
            background: radial-gradient(circle at 50% 0%, #b96cff 0%, #7c3aed 45%, #5b21b6 100%);
        }

        .spin-shell {
            width: min(520px, 100%);
            display: grid;
            gap: 14px;
            justify-items: center;
        }

        .spin-topbar {
            width: 100%;
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
        }

        .spin-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.20);
            color: rgba(255, 255, 255, 0.92);
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-size: 11px;
        }

        .spin-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #ffe07a;
            box-shadow: 0 0 16px rgba(250, 204, 21, .6);
        }

        .spin-remaining {
            padding: 10px 14px;
            border-radius: 16px;
            background: rgba(0, 0, 0, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: rgba(255, 255, 255, 0.9);
            text-align: right;
            line-height: 1.1;
        }

        .spin-remaining .num {
            font-size: 28px;
            font-weight: 1000;
            color: #ffe07a;
            text-shadow: 0 8px 28px rgba(0, 0, 0, .45);
        }

        .spin-remaining .sub {
            font-size: 12px;
            opacity: .75;
            margin-top: 4px;
        }

        .wheel-wrap {
            position: relative;
            width: 340px;
            height: 340px;
            margin-top: 10px;
        }

        @media (min-width: 640px) {
            .wheel-wrap {
                width: 420px;
                height: 420px;
            }
        }

        /* Pointer */
        .pointer {
            position: absolute;
            left: 50%;
            top: -6px;
            transform: translateX(-50%);
            z-index: 30;
            width: 0;
            height: 0;
            border-left: 22px solid transparent;
            border-right: 22px solid transparent;
            border-top: 44px solid #facc15;
            filter: drop-shadow(0 16px 22px rgba(0, 0, 0, .45));
        }

        .pointer::after {
            content: "";
            position: absolute;
            left: 50%;
            top: -32px;
            transform: translateX(-50%);
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #1f2937;
            border: 3px solid rgba(255, 255, 255, .8);
        }



        /* Wheel outer ring */
        .wheel-ring {
            position: absolute;
            inset: 0;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 20%, rgba(255, 255, 255, .35), rgba(255, 255, 255, .08) 40%, rgba(0, 0, 0, .18) 70%);
            box-shadow: 0 22px 60px rgba(0, 0, 0, .38);
            padding: 16px;
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

        /* Inner shading to give "3D" feel */
        .wheel::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 999px;
            background:
                radial-gradient(circle at 30% 20%, rgba(255, 255, 255, .35), rgba(255, 255, 255, 0) 45%),
                radial-gradient(circle at 50% 55%, rgba(0, 0, 0, .20), rgba(0, 0, 0, 0) 55%);
            pointer-events: none;
        }

        /* Bulbs ring */
        .bulbs {
            position: absolute;
            inset: 8px;
            border-radius: 999px;
            pointer-events: none;
            z-index: 20;
        }

        .bulb {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .95);
            box-shadow: 0 0 10px rgba(255, 255, 255, .9);
            opacity: .95;
        }

        .bulb.dim {
            opacity: .35;
            box-shadow: 0 0 6px rgba(255, 255, 255, .35);
        }

        /* Labels layer */
        .labels {
            position: absolute;
            inset: 0;
            z-index: 10;
            pointer-events: none;
        }

        .label {
            position: absolute;
            left: 50%;
            top: 50%;

            transform-origin: center center;
            /* ✅ 改这里 */
            translate: -50% -50%;
            /* ✅ 让元素中心对准转盘中心 */

            font-weight: 1000;
            font-size: 15px;
            letter-spacing: .02em;
            color: rgba(255, 255, 255, .95);
            text-shadow: 0 10px 18px rgba(0, 0, 0, .38);
            white-space: nowrap;
            text-align: center;
        }


        /* Center button */
        .center {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            z-index: 25;
        }

        .spin-btn {
            width: 96px;
            height: 96px;
            border-radius: 999px;
            background: #0b2a7a;
            border: 10px solid rgba(255, 255, 255, .9);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .45);
            color: white;
            font-weight: 1000;
            font-size: 20px;
            letter-spacing: .06em;
            cursor: pointer;
            transition: transform .12s ease;
        }

        .spin-btn:active {
            transform: scale(.98);
        }

        .spin-btn:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        /* Footer card */
        .spin-card {
            width: 100%;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.16);
            padding: 14px 16px;
            color: rgba(255, 255, 255, .92);
        }

        .spin-card .title {
            font-size: 11px;
            font-weight: 1000;
            letter-spacing: .14em;
            text-transform: uppercase;
            opacity: .8;
        }

        .spin-card .value {
            margin-top: 8px;
            font-size: 22px;
            font-weight: 1000;
        }

        .spin-card .hint {
            margin-top: 6px;
            font-size: 12px;
            opacity: .7;
        }

        /* Modal */
        .modal {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: none;
        }

        .modal.show {
            display: block;
        }

        .modal .bg {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .75);
            backdrop-filter: blur(6px);
        }

        .modal .box {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: min(380px, 92%);
            border-radius: 22px;
            background: rgba(20, 20, 24, .96);
            border: 1px solid rgba(255, 255, 255, .14);
            box-shadow: 0 30px 90px rgba(0, 0, 0, .65);
            padding: 18px;
            color: white;
        }

        .modal .box .kicker {
            font-size: 11px;
            font-weight: 1000;
            letter-spacing: .14em;
            text-transform: uppercase;
            opacity: .7;
        }

        .modal .box .headline {
            margin-top: 10px;
            font-size: 26px;
            font-weight: 1000;
            line-height: 1.1;
        }

        .modal .box .sub {
            margin-top: 8px;
            font-size: 14px;
            opacity: .78;
        }

        .modal .box .ok {
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

        .modal .box .ok:active {
            transform: scale(.99);
        }
    </style>


    <div class="spin-page">
        <div class="spin-shell">
            <div class="spin-topbar">
                <div class="spin-badge">
                    <span class="spin-badge-dot"></span>
                    BRIF SPIN
                </div>

                @php
                    $credits = (int) (auth()->user()?->spin_credits ?? 0);
                @endphp

                <div class="spin-remaining">
                    <div class="sub">Available Spins</div>
                    <div id="remainUI" class="num">{{ $credits }}</div>
                </div>

            </div>

            <div class="wheel-wrap">
                <div class="pointer"></div>

                <div class="wheel-ring">
                    <div id="wheel" class="wheel" style="transform: rotate(0deg);">
                        {{-- labels --}}
                        <div class="labels">
                            @php
                                $labelRadius = 120; // will be adjusted in JS for responsive if needed
                            @endphp

                            @foreach ($items as $i => $r)
                                @php
                                    $angle = $i * $step;
                                    $mid = $angle + $step / 2;
                                @endphp
                                <div class="label"
                                    style="
                                        transform:
                                        rotate({{ $mid }}deg)
                                        translateY(-110px)
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

            <div class="spin-card">
                <div class="title">Result</div>
                <div id="result" class="value">—</div>
                <div id="status" class="hint">Ready</div>
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

            // ✅ credits 模式：前端只显示，不自己决定扣多少
            let credits = Number({{ (int) ($credits ?? 0) }});

            // ===== bulbs ring =====
            function buildBulbs(count = 20) {
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
            }, 280);

            function openModal(title, sub) {
                if (!modal) return;
                modalTitle.textContent = title;
                modalSub.textContent = sub;
                modal.classList.add('show');
            }

            function closeModal() {
                if (!modal) return;
                modal.classList.remove('show');
            }

            modalOk?.addEventListener('click', closeModal);
            modal?.querySelector('.bg')?.addEventListener('click', closeModal);

            setTimeout(() => buildBulbs(20), 30);
            window.addEventListener('resize', () => buildBulbs(20));

            function setCredits(next) {
                credits = Math.max(0, Number(next || 0));
                if (remainUI) remainUI.textContent = String(credits);
            }

            async function spin() {
                if (spinning) return;

                // ✅ 体验提示：没有 credits 就别打 API
                if (credits <= 0) {
                    status.textContent = 'No spins available. Complete a purchase to earn a spin.';
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

                    // ❗不 ok：把 server message 显示出来
                    if (!res.ok || !data.ok) {
                        throw new Error(data.message || `Request failed (${res.status})`);
                    }

                    const idx = Number(data.landing_index ?? 0);
                    const target = 360 - (idx * step + step / 2); // 你的目标余数角度（0~360）

                    const spins = 7;

                    // ✅ 当前已经转到的余数（0~360）
                    const cur = ((rotation % 360) + 360) % 360;

                    let diff = target - cur;
                    diff = ((diff % 360) + 360) % 360;

                    rotation += spins * 360 + diff;

                    wheel.style.transform = `rotate(${rotation}deg)`;

                    setTimeout(() => {
                        status.textContent = 'Done';
                        result.textContent = `${data.reward.name} (+${data.reward.points} pts)`;

                        // ✅ 用 server 回来的 credits_left
                        if (data.credits_left != null) {
                            setCredits(data.credits_left);
                        } else {
                            // fallback：没有返回就前端减 1（不建议，但防炸）
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

            btn.addEventListener('click', spin);
        })();
    </script>

</x-app-layout>
