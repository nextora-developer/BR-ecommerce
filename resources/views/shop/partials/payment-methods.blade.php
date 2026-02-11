<section class="relative">
    <div class="mx-auto max-w-7xl5 px-4 sm:px-6 lg:px-8 pb-6 py-10">

        {{-- marquee --}}
        <div class="relative">

            {{-- fade edges --}}
            <div
                class="pointer-events-none absolute left-0 top-0 bottom-0 w-14
                       bg-gradient-to-r from-[#F9F7F2] to-transparent z-10">
            </div>
            <div
                class="pointer-events-none absolute right-0 top-0 bottom-0 w-14
                       bg-gradient-to-l from-[#F9F7F2] to-transparent z-10">
            </div>

            <div class="overflow-hidden" data-pay-marquee>
                <div class="flex items-center gap-10 sm:gap-14 will-change-transform" data-pay-track>

                    @php
                        $payments = [
                            ['alt' => 'FPX', 'src' => asset('images/payments/fpx.png')],
                            ['alt' => 'Visa', 'src' => asset('images/payments/visa.png')],
                            ['alt' => 'Mastercard', 'src' => asset('images/payments/mastercard.png')],
                            ['alt' => 'TNG eWallet', 'src' => asset('images/payments/tng.png')],
                            ['alt' => 'GrabPay', 'src' => asset('images/payments/grabpay.png')],
                            ['alt' => 'Boost', 'src' => asset('images/payments/boost.png')],
                            ['alt' => 'ShopeePay', 'src' => asset('images/payments/shopeepay.png')],
                            ['alt' => 'AliPay', 'src' => asset('images/payments/alipay.png')],
                            ['alt' => 'WeChatPay', 'src' => asset('images/payments/wechatpay.png')],
                            ['alt' => 'MAE', 'src' => asset('images/payments/mae.png')],
                            ['alt' => 'MCash', 'src' => asset('images/payments/mcash.png')],
                        ];
                    @endphp

                    @foreach ($payments as $p)
                        <div class="shrink-0">
                            <img src="{{ $p['src'] }}" alt="{{ $p['alt'] }}"
                                class="h-14 sm:h-16 lg:h-20 w-auto object-contain
                                       rounded-xl sm:rounded-2xl
                                       hover:opacity-90 transition"
                                draggable="false">
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrap = document.querySelector('[data-pay-marquee]');
        const track = document.querySelector('[data-pay-track]');
        if (!wrap || !track) return;

        // 复制一份内容，实现无缝循环
        track.innerHTML = track.innerHTML + track.innerHTML;

        let x = 0;
        let speed = 0.55; // ✅ 速度：0.35 慢 / 0.55 默认 / 0.8 快
        let paused = false;

        // track 一半宽度（因为复制了两份）
        function getHalfWidth() {
            return track.scrollWidth / 2;
        }

        function tick() {
            if (!paused) {
                x += speed;
                const half = getHalfWidth();

                // 滑到一半就重置（无缝）
                if (x >= half) x = 0;

                track.style.transform = `translateX(${-x}px)`;
            }
            requestAnimationFrame(tick);
        }
        tick();

        // hover 暂停（桌面）
        wrap.addEventListener('mouseenter', () => paused = true);
        wrap.addEventListener('mouseleave', () => paused = false);

        // touch 暂停（手机）
        wrap.addEventListener('touchstart', () => paused = true, {
            passive: true
        });
        wrap.addEventListener('touchend', () => paused = false, {
            passive: true
        });

        // 可选：根据用户滚动方向微调速度（更“顺”）
        wrap.addEventListener('wheel', (e) => {
            // 鼠标滚轮时短暂加速/减速（不阻止默认）
            const delta = Math.max(-12, Math.min(12, e.deltaY));
            speed = Math.max(0.25, Math.min(1.2, 0.55 + delta * 0.01));
            clearTimeout(wrap._paySpeedTimer);
            wrap._paySpeedTimer = setTimeout(() => speed = 0.55, 500);
        }, {
            passive: true
        });
    });
</script>
