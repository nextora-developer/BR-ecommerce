<x-app-layout>
    <div class="brif-rm-v2">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

            .brif-rm-v2,
            .brif-rm-v2 * {
                box-sizing: border-box;
            }

            .brif-rm-v2 {
                --rm-navy: #07111f;
                --rm-navy-2: #0b1730;
                --rm-navy-3: #102448;
                --rm-blue: #00aeef;
                --rm-blue-2: #1f8fff;
                --rm-cyan: #2ce6d3;
                --rm-pink: #e91e63;
                --rm-white: #ffffff;
                --rm-bg: #f7fbff;
                --rm-bg-2: #eef5fb;
                --rm-bg-3: #f9fcff;
                --rm-text: #0f172a;
                --rm-text-soft: #5b6b84;
                --rm-text-muted: #8a98ad;
                --rm-line: rgba(15, 23, 42, 0.08);
                --rm-line-strong: rgba(15, 23, 42, 0.12);
                --rm-shadow-xs: 0 6px 16px rgba(15, 23, 42, 0.04);
                --rm-shadow-sm: 0 12px 32px rgba(15, 23, 42, 0.05);
                --rm-shadow-md: 0 18px 52px rgba(15, 23, 42, 0.08);
                --rm-shadow-lg: 0 30px 90px rgba(15, 23, 42, 0.12);
                --rm-shadow-dark: 0 30px 90px rgba(0, 0, 0, 0.32);
                --rm-radius-lg: 20px;
                --rm-radius-xl: 28px;
                --rm-radius-2xl: 36px;
                --rm-max: 1280px;
                position: relative;
                width: 100%;
                overflow: hidden;
                font-family: 'Inter', sans-serif;
                color: var(--rm-text);
                background:
                    radial-gradient(circle at 8% 10%, rgba(0, 174, 239, .12), transparent 28%),
                    radial-gradient(circle at 92% 8%, rgba(233, 30, 99, .08), transparent 24%),
                    radial-gradient(circle at 14% 82%, rgba(44, 230, 211, .08), transparent 20%),
                    linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
            }

            .brif-rm-v2 a {
                text-decoration: none;
            }

            .brif-rm-v2 img {
                max-width: 100%;
                display: block;
            }

            .brif-rm-v2 .rm-container {
                width: 100%;
                max-width: var(--rm-max);
                margin: 0 auto;
                padding-left: 24px;
                padding-right: 24px;
                position: relative;
                z-index: 2;
            }

            .brif-rm-v2 .rm-section {
                position: relative;
                padding: 96px 0;
                scroll-margin-top: 100px;
            }

            .brif-rm-v2 .rm-divider {
                width: 100%;
                height: 1px;
                background: linear-gradient(to right, transparent, rgba(148, 163, 184, .35), transparent);
            }

            .brif-rm-v2 .rm-grid {
                display: grid;
                gap: 28px;
            }

            .brif-rm-v2 .rm-grid-2 {
                grid-template-columns: 1.08fr .92fr;
                align-items: center;
            }

            .brif-rm-v2 .rm-grid-2-even {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                align-items: stretch;
            }

            .brif-rm-v2 .rm-grid-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .brif-rm-v2 .rm-grid-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .brif-rm-v2 .rm-center {
                text-align: center;
            }

            .brif-rm-v2 .rm-badge {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 10px 16px;
                border-radius: 999px;
                font-size: 11px;
                font-weight: 800;
                letter-spacing: .16em;
                text-transform: uppercase;
                color: #5a677b;
                background: rgba(255, 255, 255, .9);
                border: 1px solid rgba(255, 255, 255, .96);
                box-shadow: var(--rm-shadow-sm);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
            }

            .brif-rm-v2 .rm-badge-dark {
                background: rgba(255, 255, 255, .08);
                color: #fff;
                border-color: rgba(255, 255, 255, .12);
            }

            .brif-rm-v2 .rm-badge-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: var(--rm-blue);
                box-shadow: 0 0 0 0 rgba(0, 174, 239, .45);
                animation: rmPulse 2s infinite;
                flex: 0 0 auto;
            }

            @keyframes rmPulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(0, 174, 239, .45);
                }

                70% {
                    box-shadow: 0 0 0 14px rgba(0, 174, 239, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(0, 174, 239, 0);
                }
            }

            .brif-rm-v2 .rm-title {
                margin: 0 0 18px;
                font-size: clamp(2.4rem, 5vw, 5rem);
                line-height: .95;
                font-weight: 900;
                letter-spacing: -.06em;
                color: var(--rm-text);
            }

            .brif-rm-v2 .rm-title-md {
                margin: 0 0 16px;
                font-size: clamp(2rem, 4vw, 3.5rem);
                line-height: 1.02;
                font-weight: 850;
                letter-spacing: -.045em;
                color: var(--rm-text);
            }

            .brif-rm-v2 .rm-title-sm {
                margin: 0 0 8px;
                font-size: 20px;
                line-height: 1.2;
                font-weight: 800;
                letter-spacing: -.02em;
                color: var(--rm-text);
            }

            .brif-rm-v2 .rm-title-dark,
            .brif-rm-v2 .rm-title-md-dark {
                color: #fff;
            }

            .brif-rm-v2 .rm-text {
                margin: 0;
                font-size: 17px;
                line-height: 1.9;
                color: var(--rm-text-soft);
            }

            .brif-rm-v2 .rm-text-sm {
                margin: 0;
                font-size: 14px;
                line-height: 1.78;
                color: var(--rm-text-soft);
            }

            .brif-rm-v2 .rm-text-dark {
                color: #c8d5e5;
            }

            .brif-rm-v2 .rm-gradient {
                background: linear-gradient(135deg, var(--rm-blue) 0%, #1f8fff 50%, var(--rm-pink) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                color: transparent;
            }

            .brif-rm-v2 .rm-blue-gradient {
                background: linear-gradient(135deg, #1f8fff 0%, #00aeef 55%, #34d5ff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                color: transparent;
            }

            .brif-rm-v2 .rm-kicker {
                font-size: 12px;
                font-weight: 800;
                letter-spacing: .16em;
                text-transform: uppercase;
                color: #94a3b8;
            }

            .brif-rm-v2 .rm-note {
                color: #94a3b8;
                font-size: 11px;
                font-weight: 800;
                letter-spacing: .16em;
                text-transform: uppercase;
                margin-bottom: 6px;
            }

            .brif-rm-v2 .rm-btn-row {
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
            }

            .brif-rm-v2 .rm-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                min-height: 54px;
                padding: 15px 24px;
                border-radius: 999px;
                font-size: 15px;
                font-weight: 800;
                line-height: 1;
                transition: all .3s ease;
                position: relative;
                overflow: hidden;
            }

            .brif-rm-v2 .rm-btn-primary {
                color: #fff;
                background: linear-gradient(135deg, #0f172a 0%, #172554 100%);
                box-shadow: var(--rm-shadow-md);
            }

            .brif-rm-v2 .rm-btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 22px 60px rgba(15, 23, 42, .16);
            }

            .brif-rm-v2 .rm-btn-secondary {
                color: #0f172a;
                background: rgba(255, 255, 255, .94);
                border: 1px solid rgba(226, 232, 240, 1);
                box-shadow: var(--rm-shadow-sm);
            }

            .brif-rm-v2 .rm-btn-secondary:hover {
                transform: translateY(-2px);
                background: #fff;
            }

            .brif-rm-v2 .rm-btn-light {
                color: #0f172a;
                background: #fff;
                box-shadow: 0 0 40px rgba(0, 174, 239, .16);
            }

            .brif-rm-v2 .rm-btn-light:hover {
                transform: translateY(-2px);
                background: #f8fbff;
            }

            .brif-rm-v2 .rm-btn-outline {
                color: #fff;
                background: transparent;
                border: 1px solid rgba(255, 255, 255, .18);
            }

            .brif-rm-v2 .rm-btn-outline:hover {
                background: rgba(255, 255, 255, .06);
            }

            .brif-rm-v2 .rm-btn-arrow {
                width: 18px;
                height: 18px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: transform .3s ease;
            }

            .brif-rm-v2 .rm-btn:hover .rm-btn-arrow {
                transform: translateX(3px);
            }

            .brif-rm-v2 .rm-card,
            .brif-rm-v2 .rm-card-dark,
            .brif-rm-v2 .rm-hero-panel,
            .brif-rm-v2 .rm-info-panel {
                position: relative;
                overflow: hidden;
            }

            .brif-rm-v2 .rm-card {
                height: 100%;
                background: rgba(255, 255, 255, .94);
                border: 1px solid rgba(226, 232, 240, .9);
                border-radius: var(--rm-radius-xl);
                box-shadow: var(--rm-shadow-sm);
                transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
            }

            .brif-rm-v2 .rm-card:hover {
                transform: translateY(-6px);
                box-shadow: var(--rm-shadow-lg);
                border-color: rgba(0, 174, 239, .18);
            }

            .brif-rm-v2 .rm-card-glow::before {
                content: "";
                position: absolute;
                width: 180px;
                height: 180px;
                top: -60px;
                right: -60px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(0, 174, 239, .12), transparent 68%);
                pointer-events: none;
            }

            .brif-rm-v2 .rm-card-dark,
            .brif-rm-v2 .rm-dark-block {
                height: 100%;
                background: linear-gradient(180deg, rgba(11, 23, 48, .98), rgba(7, 17, 31, .98));
                border: 1px solid rgba(255, 255, 255, .08);
                border-radius: var(--rm-radius-xl);
                color: #fff;
                box-shadow: var(--rm-shadow-dark);
                transition: transform .35s ease, border-color .35s ease;
            }

            .brif-rm-v2 .rm-card-dark:hover {
                transform: translateY(-6px);
                border-color: rgba(44, 230, 211, .18);
            }

            .brif-rm-v2 .rm-card-dark::before,
            .brif-rm-v2 .rm-dark-block::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 15% 10%, rgba(0, 174, 239, .20), transparent 26%),
                    radial-gradient(circle at 85% 15%, rgba(233, 30, 99, .12), transparent 22%);
                pointer-events: none;
            }

            .brif-rm-v2 .rm-card-pad {
                padding: 30px;
                position: relative;
                z-index: 2;
            }

            .brif-rm-v2 .rm-mini-card {
                border-radius: 18px;
                background: #fff;
                border: 1px solid rgba(241, 245, 249, 1);
                padding: 18px;
                transition: all .3s ease;
                box-shadow: var(--rm-shadow-xs);
            }

            .brif-rm-v2 .rm-mini-card:hover {
                background: #fbfdff;
                border-color: rgba(125, 211, 252, .55);
                transform: translateY(-2px);
            }

            .brif-rm-v2 .rm-icon {
                width: 52px;
                height: 52px;
                border-radius: 18px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
                background: rgba(0, 174, 239, .10);
                color: var(--rm-blue);
                box-shadow: inset 0 0 0 1px rgba(0, 174, 239, .10);
                animation: rmFloat 4s ease-in-out infinite;
            }

            .brif-rm-v2 .rm-icon svg {
                width: 24px;
                height: 24px;
                stroke: currentColor;
                fill: none;
                stroke-width: 2;
                stroke-linecap: round;
                stroke-linejoin: round;
            }

            .brif-rm-v2 .rm-icon-green {
                background: rgba(16, 185, 129, .12);
                color: #10b981;
            }

            .brif-rm-v2 .rm-icon-dark {
                background: rgba(255, 255, 255, .08);
                color: var(--rm-cyan);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .06);
            }

            @keyframes rmFloat {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-4px);
                }
            }

            .brif-rm-v2 .rm-chip-row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .rm-chip-row,
            .rm-trust-row {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .brif-rm-v2 .rm-chip {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 10px 14px;
                border-radius: 999px;
                font-size: 12px;
                font-weight: 700;
                color: #53627b;
                background: rgba(248, 250, 252, .96);
                border: 1px solid rgba(226, 232, 240, 1);
            }

            .brif-rm-v2 .rm-hero {
                padding-top: 88px;
                padding-bottom: 72px;
            }

            .brif-rm-v2 .rm-partner-logo-row {
                display: flex;
                align-items: center;
                gap: 18px;
                margin-bottom: 24px;
                flex-wrap: wrap;
            }

            .brif-rm-v2 .rm-brand-box {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 76px;
                padding: 14px 20px;
                border-radius: 20px;
                background: rgba(255, 255, 255, .92);
                border: 1px solid rgba(255, 255, 255, .95);
                box-shadow: var(--rm-shadow-sm);
            }

            .brif-rm-v2 .rm-brand-box img {
                max-height: 42px;
                width: auto;
                object-fit: contain;
            }

            .brif-rm-v2 .rm-brand-box.br-box-br img {
                max-height: 34px;
            }

            .brif-rm-v2 .rm-brand-box.br-box-rm img {
                max-height: 40px;
            }

            .brif-rm-v2 .rm-separator {
                width: 1px;
                height: 42px;
                background: rgba(226, 232, 240, 1);
            }

            .brif-rm-v2 .rm-trust-row {
                display: flex;
                flex-wrap: wrap;
                gap: 14px;
                margin-top: 28px;
            }

            .brif-rm-v2 .rm-trust-pill {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 12px 16px;
                border-radius: 999px;
                font-size: 13px;
                font-weight: 700;
                color: #425166;
                background: rgba(255, 255, 255, .85);
                border: 1px solid rgba(226, 232, 240, .95);
                box-shadow: var(--rm-shadow-xs);
            }

            .brif-rm-v2 .rm-trust-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--rm-blue), var(--rm-cyan));
                flex: 0 0 auto;
            }

            .brif-rm-v2 .rm-hero-panel {
                border-radius: var(--rm-radius-2xl);
                background: rgba(255, 255, 255, .78);
                border: 1px solid rgba(226, 232, 240, .75);
                box-shadow: var(--rm-shadow-lg);
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                padding: 24px;
            }

            .brif-rm-v2 .rm-hero-panel::before {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: inherit;
                padding: 1px;
                background: linear-gradient(135deg, rgba(0, 174, 239, .24), rgba(233, 30, 99, .14), rgba(44, 230, 211, .16));
                -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                -webkit-mask-composite: xor;
                mask-composite: exclude;
                pointer-events: none;
            }

            .brif-rm-v2 .rm-panel-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 18px;
                position: relative;
                z-index: 2;
            }

            .brif-rm-v2 .rm-growth {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                border-radius: 999px;
                background: #ecfdf3;
                color: #0d9b5f;
                font-size: 12px;
                font-weight: 800;
                white-space: nowrap;
            }

            .brif-rm-v2 .rm-overview-grid {
                display: grid;
                grid-template-columns: 1.15fr .85fr;
                gap: 16px;
                margin-bottom: 16px;
                position: relative;
                z-index: 2;
            }

            .brif-rm-v2 .rm-chart-card {
                border-radius: 24px;
                background: #f8fafc;
                border: 1px solid rgba(241, 245, 249, 1);
                padding: 22px;
            }

            .brif-rm-v2 .rm-amount {
                margin: 0;
                font-size: 40px;
                line-height: 1.06;
                font-weight: 850;
                letter-spacing: -.04em;
                color: #0f172a;
            }

            .brif-rm-v2 .rm-bars {
                display: flex;
                align-items: flex-end;
                gap: 8px;
                height: 128px;
                margin-top: 18px;
            }

            .brif-rm-v2 .rm-bar {
                flex: 1 1 auto;
                border-radius: 14px 14px 4px 4px;
                background: rgba(203, 213, 225, .75);
                position: relative;
                overflow: hidden;
            }

            .brif-rm-v2 .rm-bar.active {
                background: linear-gradient(to top, var(--rm-blue), var(--rm-cyan));
                box-shadow: 0 0 32px rgba(0, 174, 239, .22);
            }

            .brif-rm-v2 .rm-channel-box {
                border-radius: 24px;
                background: #0f172a;
                color: #fff;
                border: 1px solid rgba(30, 41, 59, 1);
                padding: 22px;
            }

            .brif-rm-v2 .rm-channel-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-top: 16px;
            }

            .brif-rm-v2 .rm-channel-pill {
                border-radius: 14px;
                background: rgba(255, 255, 255, .05);
                border: 1px solid rgba(255, 255, 255, .1);
                padding: 12px;
                font-size: 12px;
                font-weight: 700;
                color: #dbe7f5;
                text-align: center;
            }

            .brif-rm-v2 .rm-summary-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 12px;
                margin-bottom: 16px;
                position: relative;
                z-index: 2;
            }

            .brif-rm-v2 .rm-summary-box {
                border-radius: 18px;
                background: #f8fafc;
                border: 1px solid rgba(241, 245, 249, 1);
                padding: 16px;
            }

            .brif-rm-v2 .rm-summary-title {
                font-size: 11px;
                font-weight: 800;
                color: #94a3b8;
                text-transform: uppercase;
                letter-spacing: .14em;
                margin-bottom: 6px;
            }

            .brif-rm-v2 .rm-summary-value {
                margin: 0;
                font-size: 16px;
                font-weight: 800;
                color: #0f172a;
            }

            .brif-rm-v2 .rm-feature-boxes {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
                position: relative;
                z-index: 2;
            }

            .brif-rm-v2 .rm-feature-glass {
                border-radius: 20px;
                padding: 18px;
                background: rgba(255, 255, 255, .84);
                border: 1px solid rgba(255, 255, 255, .94);
                box-shadow: var(--rm-shadow-sm);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .brif-rm-v2 .rm-stat-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
                margin-top: 32px;
                margin-bottom: 26px;
            }

            .brif-rm-v2 .rm-stat-card {
                padding: 22px;
                border-radius: 22px;
                background: linear-gradient(180deg, rgba(255, 255, 255, .96), rgba(255, 255, 255, .8));
                border: 1px solid rgba(226, 232, 240, .92);
                box-shadow: var(--rm-shadow-sm);
            }

            .brif-rm-v2 .rm-stat-label {
                font-size: 11px;
                font-weight: 800;
                letter-spacing: .16em;
                text-transform: uppercase;
                color: #94a3b8;
                margin-bottom: 8px;
            }

            .brif-rm-v2 .rm-stat-value {
                font-size: 30px;
                line-height: 1.1;
                font-weight: 850;
                letter-spacing: -.03em;
                color: #0f172a;
                margin: 0 0 6px;
            }

            .brif-rm-v2 .rm-info-panel {
                border-radius: 28px;
                background: linear-gradient(180deg, rgba(255, 255, 255, .96), rgba(255, 255, 255, .84));
                border: 1px solid rgba(226, 232, 240, .92);
                box-shadow: var(--rm-shadow-md);
                padding: 30px;
            }

            .brif-rm-v2 .rm-check-list {
                display: grid;
                gap: 12px;
                margin-top: 22px;
            }

            .brif-rm-v2 .rm-check {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                font-size: 14px;
                line-height: 1.7;
                color: var(--rm-text-soft);
            }

            .brif-rm-v2 .rm-check-icon {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                flex: 0 0 auto;
                margin-top: 1px;
                background: linear-gradient(135deg, rgba(0, 174, 239, .14), rgba(44, 230, 211, .18));
                border: 1px solid rgba(0, 174, 239, .12);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: var(--rm-blue);
                font-size: 12px;
                font-weight: 900;
            }

            .brif-rm-v2 .rm-logo-cloud {
                margin-top: 34px;
                padding: 20px;
                border-radius: 26px;
                background: rgba(255, 255, 255, .8);
                border: 1px solid rgba(226, 232, 240, .82);
                box-shadow: var(--rm-shadow-sm);
            }

            .brif-rm-v2 .rm-logo-cloud-label {
                margin: 0 0 14px;
                font-size: 11px;
                font-weight: 800;
                letter-spacing: .16em;
                text-transform: uppercase;
                color: #94a3b8;
            }

            .brif-rm-v2 .rm-payment-logos {
                display: grid;
                grid-template-columns: repeat(6, minmax(0, 1fr));
                gap: 14px;
                align-items: stretch;
            }

            .brif-rm-v2 .rm-payment-logo {
                min-height: 76px;
                border-radius: 18px;
                background: #fff;
                border: 1px solid rgba(226, 232, 240, .9);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 12px;
                transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
                box-shadow: 0 8px 22px rgba(15, 23, 42, .04);
            }

            .brif-rm-v2 .rm-payment-logo:hover {
                transform: translateY(-3px);
                border-color: rgba(0, 174, 239, .20);
                box-shadow: 0 14px 30px rgba(15, 23, 42, .08);
            }

            .brif-rm-v2 .rm-payment-logo img {
                max-height: 30px;
                width: auto;
                object-fit: contain;
            }

            .brif-rm-v2 .rm-feature-number {
                font-size: 48px;
                line-height: 1;
                font-weight: 900;
                letter-spacing: -.05em;
                color: rgba(15, 23, 42, .08);
                margin-bottom: 10px;
            }

            .brif-rm-v2 .rm-dark-section {
                position: relative;
                overflow: hidden;
                background: linear-gradient(180deg, #0b1730 0%, #07111f 100%);
                color: #fff;
            }

            .brif-rm-v2 .rm-dark-section::before {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
                background:
                    radial-gradient(circle at 50% 45%, rgba(0, 174, 239, .18), transparent 34%),
                    radial-gradient(circle at 90% 8%, rgba(233, 30, 99, .12), transparent 22%);
                z-index: 0;
            }

            .brif-rm-v2 .rm-dark-section::after {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
                background-image:
                    linear-gradient(rgba(255, 255, 255, .04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255, 255, 255, .04) 1px, transparent 1px);
                background-size: 34px 34px;
                opacity: .26;
                z-index: 0;
            }

            .brif-rm-v2 .rm-footer-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
                margin-top: 16px;
            }

            .brif-rm-v2 .rm-footer-card {
                border-radius: 20px;
                padding: 20px;
                background: rgba(255, 255, 255, .08);
                border: 1px solid rgba(255, 255, 255, .10);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .brif-rm-v2 .rm-footer-card p {
                margin: 0;
                font-size: 14px;
                line-height: 1.75;
                color: #fff;
            }

            .brif-rm-v2 .rm-floating-orb {
                position: absolute;
                border-radius: 50%;
                pointer-events: none;
                filter: blur(8px);
                opacity: .75;
                animation: rmOrbFloat 8s ease-in-out infinite;
            }

            .brif-rm-v2 .rm-orb-1 {
                width: 120px;
                height: 120px;
                top: 10%;
                right: 8%;
                background: radial-gradient(circle, rgba(0, 174, 239, .24), rgba(0, 174, 239, 0));
            }

            .brif-rm-v2 .rm-orb-2 {
                width: 140px;
                height: 140px;
                bottom: 16%;
                left: -30px;
                background: radial-gradient(circle, rgba(44, 230, 211, .18), rgba(44, 230, 211, 0));
                animation-delay: 1.2s;
            }

            .brif-rm-v2 .rm-orb-3 {
                width: 160px;
                height: 160px;
                top: 32%;
                right: -40px;
                background: radial-gradient(circle, rgba(31, 143, 255, .12), rgba(31, 143, 255, 0));
                animation-delay: 2s;
            }

            @keyframes rmOrbFloat {

                0%,
                100% {
                    transform: translateY(0) translateX(0);
                }

                50% {
                    transform: translateY(-12px) translateX(8px);
                }
            }

            .brif-rm-v2 .rm-mb-18 {
                margin-bottom: 18px;
            }

            .brif-rm-v2 .rm-mb-20 {
                margin-bottom: 20px;
            }

            .brif-rm-v2 .rm-mb-24 {
                margin-bottom: 24px;
            }

            .brif-rm-v2 .rm-mb-28 {
                margin-bottom: 28px;
            }

            .brif-rm-v2 .rm-mb-30 {
                margin-bottom: 30px;
            }

            .brif-rm-v2 .rm-mb-36 {
                margin-bottom: 36px;
            }

            .brif-rm-v2 .rm-mb-40 {
                margin-bottom: 40px;
            }

            .brif-rm-v2 .rm-mb-48 {
                margin-bottom: 48px;
            }

            @media (max-width: 1180px) {
                .brif-rm-v2 .rm-grid-4 {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .brif-rm-v2 .rm-payment-logos {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                }
            }

            @media (max-width: 1024px) {
                .brif-rm-v2 .rm-section {
                    padding: 78px 0;
                }

                .brif-rm-v2 .rm-grid-2,
                .brif-rm-v2 .rm-grid-2-even,
                .brif-rm-v2 .rm-overview-grid {
                    grid-template-columns: 1fr;
                }

                .brif-rm-v2 .rm-grid-3 {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .brif-rm-v2 .rm-feature-boxes,
                .brif-rm-v2 .rm-stat-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .brif-rm-v2 .rm-title {
                    font-size: clamp(2.2rem, 7vw, 4rem);
                }

                .brif-rm-v2 .rm-title-md {
                    font-size: clamp(1.95rem, 5vw, 3rem);
                }
            }

            @media (max-width: 767px) {
                .brif-rm-v2 .rm-container {
                    padding-left: 18px;
                    padding-right: 18px;
                }

                .brif-rm-v2 .rm-section {
                    padding: 62px 0;
                }

                .brif-rm-v2 .rm-hero {
                    padding-top: 64px;
                    padding-bottom: 54px;
                }

                .brif-rm-v2 .rm-title {
                    font-size: clamp(2rem, 10vw, 3rem);
                    line-height: 1.02;
                }

                .brif-rm-v2 .rm-title-md {
                    font-size: clamp(1.75rem, 8vw, 2.5rem);
                    line-height: 1.06;
                }

                .brif-rm-v2 .rm-text {
                    font-size: 15px;
                    line-height: 1.82;
                }

                .brif-rm-v2 .rm-text-sm {
                    font-size: 13px;
                }

                .brif-rm-v2 .rm-partner-logo-row {
                    gap: 12px;
                    margin-bottom: 22px;
                }

                .brif-rm-v2 .rm-separator,
                .brif-rm-v2 .rm-kicker-desktop {
                    display: none;
                }

                .brif-rm-v2 .rm-grid-4,
                .brif-rm-v2 .rm-grid-3,
                .brif-rm-v2 .rm-summary-grid,
                .brif-rm-v2 .rm-feature-boxes,
                .brif-rm-v2 .rm-stat-grid,
                .brif-rm-v2 .rm-footer-grid {
                    grid-template-columns: 1fr;
                }

                .brif-rm-v2 .rm-channel-grid {
                    grid-template-columns: 1fr 1fr;
                }

                .brif-rm-v2 .rm-btn-row {
                    flex-direction: column;
                }

                .brif-rm-v2 .rm-btn {
                    width: 100%;
                }

                .brif-rm-v2 .rm-card-pad,
                .brif-rm-v2 .rm-hero-panel,
                .brif-rm-v2 .rm-chart-card,
                .brif-rm-v2 .rm-channel-box,
                .brif-rm-v2 .rm-info-panel {
                    padding: 18px;
                }

                .brif-rm-v2 .rm-brand-box {
                    width: 100%;
                    justify-content: center;
                }

                .brif-rm-v2 .rm-payment-logos {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 12px;
                }

                .brif-rm-v2 .rm-payment-logo {
                    min-height: 64px;
                    padding: 10px;
                }

                .brif-rm-v2 .rm-payment-logo img {
                    max-height: 26px;
                }

                .brif-rm-v2 .rm-amount {
                    font-size: 32px;
                }

                .brif-rm-v2 .rm-stat-value {
                    font-size: 26px;
                }

                .brif-rm-v2 .rm-bars {
                    height: 108px;
                    gap: 6px;
                }

                .brif-rm-v2 .rm-card:hover,
                .brif-rm-v2 .rm-card-dark:hover,
                .brif-rm-v2 .rm-btn-primary:hover,
                .brif-rm-v2 .rm-btn-secondary:hover,
                .brif-rm-v2 .rm-btn-light:hover,
                .brif-rm-v2 .rm-mini-card:hover {
                    transform: none;
                }
            }
        </style>

        <div class="rm-floating-orb rm-orb-1"></div>
        <div class="rm-floating-orb rm-orb-2"></div>
        <div class="rm-floating-orb rm-orb-3"></div>

        <!-- HERO -->
        <section class="rm-section rm-hero">
            <div class="rm-container">
                <div class="rm-grid rm-grid-2">
                    <div>
                        <div class="rm-badge rm-mb-24">
                            <span class="rm-badge-dot"></span>
                            Official Merchant Partnership
                        </div>

                        <div class="rm-partner-logo-row">
                            <div class="rm-brand-box br-box-br">
                                <img src="https://brif.store/wp-content/uploads/2026/02/%E9%A2%98%E7%9B%AE-190-x-80-%E5%83%8F%E7%B4%A0-156-x-40-%E5%83%8F%E7%B4%A0.png"
                                    alt="BR Innovate Future Logo">
                            </div>

                            <div class="rm-separator"></div>

                            <div class="rm-brand-box br-box-rm">
                                <img src="https://brif.store/wp-content/uploads/2026/03/2-1.png"
                                    alt="Revenue Monster Logo">
                            </div>
                        </div>

                        <div class="rm-kicker rm-mb-20">BR Innovate Future × Revenue Monster</div>

                        <h1 class="rm-title">
                            Help your business collect payments
                            <span class="rm-gradient">faster, smarter, and more professionally</span>
                        </h1>

                        <p class="rm-text rm-mb-36">
                            Through our partnership with Revenue Monster, we help merchants upgrade from manual
                            collection into a modern payment ecosystem — with online payment, smart terminals, payment
                            links, dashboard visibility, and scalable tools designed to support real business growth.
                        </p>

                        <div class="rm-btn-row rm-mb-30">
                            <a class="rm-btn rm-btn-primary"
                                href="https://oauth.revenuemonster.my/register?redirectUri=https://merchant.revenuemonster.my/dashboard&partnerId=1752158596631029180">
                                Apply as Merchant
                                <span class="rm-btn-arrow">→</span>
                            </a>

                            <a class="rm-btn rm-btn-secondary" href="#rm-services">
                                Explore Services
                            </a>
                        </div>

                        {{-- <div class="rm-stat-grid">
                            <div class="rm-stat-card">
                                <div class="rm-stat-label">Complete Setup</div>
                                <div class="rm-stat-value">Online + Offline</div>
                                <p class="rm-text-sm">One ecosystem for QR, eWallet, cards, payment links, terminal, and
                                    merchant tools.</p>
                            </div>

                            <div class="rm-stat-card">
                                <div class="rm-stat-label">Built for Growth</div>
                                <div class="rm-stat-value">Scalable</div>
                                <p class="rm-text-sm">Suitable for retail, F&amp;B, service businesses, eCommerce, and
                                    growing merchants.</p>
                            </div>
                        </div> --}}

                    </div>

                    <div>
                        <div class="rm-hero-panel">
                            <div class="rm-panel-top">
                                <div>
                                    <div class="rm-note">Merchant Dashboard</div>
                                    <div style="font-size:16px;font-weight:800;color:#0f172a;">Business Overview</div>
                                </div>
                                <div class="rm-growth">↗ Ready to Scale</div>
                            </div>

                            <div class="rm-overview-grid">
                                <div class="rm-chart-card">
                                    <div class="rm-note" style="margin-bottom:6px;">Collection Snapshot</div>
                                    <p class="rm-amount">RM 12,480</p>

                                    <div class="rm-bars">
                                        <div class="rm-bar" style="height:28%;"></div>
                                        <div class="rm-bar" style="height:42%;"></div>
                                        <div class="rm-bar" style="height:38%;"></div>
                                        <div class="rm-bar active" style="height:80%;"></div>
                                        <div class="rm-bar" style="height:56%;"></div>
                                        <div class="rm-bar" style="height:64%;"></div>
                                        <div class="rm-bar" style="height:48%;"></div>
                                    </div>
                                </div>

                                <div class="rm-channel-box">
                                    <div
                                        style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px;">
                                        <div>
                                            <div class="rm-note" style="color:#64748b;">Channels</div>
                                            <div style="font-size:15px;font-weight:800;color:#fff;">Connected</div>
                                        </div>
                                        <div class="rm-icon rm-icon-dark"
                                            style="margin-bottom:0;width:44px;height:44px;border-radius:14px;">
                                            <svg viewBox="0 0 24 24">
                                                <rect x="3" y="4" width="7" height="7"></rect>
                                                <rect x="14" y="4" width="7" height="7"></rect>
                                                <rect x="3" y="15" width="7" height="6"></rect>
                                                <rect x="14" y="15" width="7" height="6"></rect>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="rm-channel-grid">
                                        <div class="rm-channel-pill">Online</div>
                                        <div class="rm-channel-pill">Terminal</div>
                                        <div class="rm-channel-pill">Invoice Link</div>
                                        <div class="rm-channel-pill">App</div>
                                    </div>
                                </div>
                            </div>

                            <div class="rm-summary-grid">
                                <div class="rm-summary-box">
                                    <div class="rm-summary-title">QR</div>
                                    <p class="rm-summary-value">RM 5,960</p>
                                </div>
                                <div class="rm-summary-box">
                                    <div class="rm-summary-title">Cards</div>
                                    <p class="rm-summary-value">RM 3,820</p>
                                </div>
                                <div class="rm-summary-box">
                                    <div class="rm-summary-title">Online</div>
                                    <p class="rm-summary-value">RM 2,700</p>
                                </div>
                            </div>

                            <div class="rm-feature-boxes">
                                <div class="rm-feature-glass">
                                    <div class="rm-icon rm-icon-green"
                                        style="margin-bottom:12px;width:42px;height:42px;border-radius:14px;">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg>
                                    </div>
                                    <div class="rm-note">Visibility</div>
                                    <p style="margin:0 0 6px;font-size:15px;font-weight:800;color:#0f172a;">Cleaner
                                        tracking</p>
                                    <p class="rm-text-sm">See activity across collection channels and merchant tools
                                        more clearly.</p>
                                </div>

                                <div class="rm-feature-glass">
                                    <div class="rm-icon"
                                        style="margin-bottom:12px;width:42px;height:42px;border-radius:14px;">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 3v18"></path>
                                            <path d="M3 12h18"></path>
                                            <circle cx="12" cy="12" r="8"></circle>
                                        </svg>
                                    </div>
                                    <div class="rm-note">Operations</div>
                                    <p style="margin:0 0 6px;font-size:15px;font-weight:800;color:#0f172a;">Built for
                                        daily use</p>
                                    <p class="rm-text-sm">Bring payment collection and merchant-side tools into one
                                        connected environment.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ✅ 重点：独立出来（不要在 grid 里面） -->
                <div class="rm-chip-row" style="margin-top:30px;">
                    <span class="rm-chip">Online Payment</span>
                    <span class="rm-chip">Payment Link</span>
                    <span class="rm-chip">Smart Terminal</span>
                    <span class="rm-chip">Dashboard</span>
                    <span class="rm-chip">API Integration</span>
                </div>

                <div class="rm-trust-row" style="margin-top:30px;">
                    <div class="rm-trust-pill"><span class="rm-trust-dot"></span> Faster Collections</div>
                    <div class="rm-trust-pill"><span class="rm-trust-dot"></span> Cleaner Merchant Operations
                    </div>
                    <div class="rm-trust-pill"><span class="rm-trust-dot"></span> Better Customer Experience</div>
                </div>

                <div class="rm-logo-cloud">
                    <p class="rm-logo-cloud-label">Supported payment methods</p>
                    <div class="rm-payment-logos">
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/03/6-2.png"
                                alt="Visa"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/03/10-2.png"
                                alt="Mastercard"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/03/13-1.png"
                                alt="WeChat Pay"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/03/14-1.png"
                                alt="MCash"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/03/12-2.png"
                                alt="Touch 'n Go eWallet"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/02/2-1.png"
                                alt="ShopeePay"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/02/1.png"
                                alt="Maybank QR"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/02/5-7.png"
                                alt="Alipay"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/02/3-7.png"
                                alt="GrabPay"></div>
                        <div class="rm-payment-logo"><img
                                src="https://brif.store/wp-content/uploads/2026/03/15-1-e1773781814491.png"
                                alt="Boost"></div>
                        <div class="rm-payment-logo"><img src="https://brif.store/wp-content/uploads/2026/03/7-1.png"
                                alt="FPX"></div>
                    </div>
                </div>
            </div>
        </section>

        <div class="rm-divider"></div>

        <!-- INTRO / VALUE -->
        <section class="rm-section" id="rm-about">
            <div class="rm-container">
                <div class="rm-grid rm-grid-2-even">
                    <div class="rm-info-panel">
                        <div class="rm-badge rm-mb-20">Our Service Advantage</div>
                        <h2 class="rm-title-md">A payment solution is only valuable when it fits your real business
                            workflow.</h2>
                        <p class="rm-text">
                            We do not just pass you a signup link. We help merchants understand what they need, which
                            setup fits their business, and how to move from manual collection into a more structured and
                            professional payment system.
                        </p>

                        <div class="rm-check-list">
                            <div class="rm-check">
                                <span class="rm-check-icon">✓</span>
                                <span>Solution matching based on business type, collection style, and operational
                                    needs.</span>
                            </div>
                            <div class="rm-check">
                                <span class="rm-check-icon">✓</span>
                                <span>Better merchant onboarding guidance with clearer explanation and structure.</span>
                            </div>
                            <div class="rm-check">
                                <span class="rm-check-icon">✓</span>
                                <span>A stronger customer-facing payment experience that helps build trust and
                                    convenience.</span>
                            </div>
                        </div>
                    </div>

                    <div class="rm-card-dark">
                        <div class="rm-card-pad">
                            <div class="rm-badge rm-badge-dark rm-mb-20">About Revenue Monster</div>
                            <h2 class="rm-title-md rm-title-md-dark">More than a payment gateway.</h2>
                            <p class="rm-text rm-text-dark rm-mb-28">
                                Revenue Monster is positioned as a broader merchant ecosystem that combines payment
                                collection, digital tools, payment links, merchant visibility, and integration
                                possibilities — helping businesses operate more efficiently, not just collect money.
                            </p>

                            <div class="rm-grid" style="gap:14px;">
                                <div class="rm-footer-card" style="background:rgba(255,255,255,.05);">
                                    <div class="rm-note" style="color:#94a3b8;">For merchants</div>
                                    <p>Built to support retail, service businesses, eCommerce, and businesses moving
                                        into digital payment workflows.</p>
                                </div>
                                <div class="rm-footer-card" style="background:rgba(255,255,255,.05);">
                                    <div class="rm-note" style="color:#94a3b8;">For growth</div>
                                    <p>Helps businesses improve convenience, reduce friction, and move toward a more
                                        scalable merchant setup.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SERVICES -->
        <section class="rm-section" id="rm-services" style="background:#f8fbfe;">
            <div class="rm-container">
                <div class="rm-center" style="max-width:860px;margin:0 auto 52px;">
                    <div class="rm-badge rm-mb-20">Our Core Services</div>
                    <h2 class="rm-title-md">Designed to help merchants collect better, sell better, and operate better.
                    </h2>
                    <p class="rm-text">
                        Revenue Monster supports multiple merchant needs under one connected ecosystem, giving your
                        business more flexibility and better tools for modern payment collection.
                    </p>
                </div>

                <div class="rm-grid rm-grid-4">
                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="2" y="5" width="20" height="14" rx="3"></rect>
                                    <path d="M2 10h20"></path>
                                </svg>
                            </div>
                            <div class="rm-feature-number">01</div>
                            <h3 class="rm-title-sm">Online Payment</h3>
                            <p class="rm-text-sm">Accept payments online with a more professional checkout experience
                                across web, mobile, and online store environments.</p>
                        </div>
                    </div>

                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M8 3h8l5 5v11a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                    <path d="M16 3v5h5"></path>
                                    <path d="M9 13h6"></path>
                                    <path d="M9 17h6"></path>
                                </svg>
                            </div>
                            <div class="rm-feature-number">02</div>
                            <h3 class="rm-title-sm">Payment Link &amp; Invoice</h3>
                            <p class="rm-text-sm">Create payment requests quickly and share them through chat, email,
                                social media, or SMS for faster collection.</p>
                        </div>
                    </div>

                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="7" y="2" width="10" height="20" rx="2"></rect>
                                    <path d="M10 6h4"></path>
                                    <path d="M11 18h2"></path>
                                </svg>
                            </div>
                            <div class="rm-feature-number">03</div>
                            <h3 class="rm-title-sm">Smart Terminal</h3>
                            <p class="rm-text-sm">Improve in-store collection with modern terminal hardware and a more
                                complete payment environment for customers.</p>
                        </div>
                    </div>

                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 3v18"></path>
                                    <path d="M3 12h18"></path>
                                    <circle cx="12" cy="12" r="8"></circle>
                                </svg>
                            </div>
                            <div class="rm-feature-number">04</div>
                            <h3 class="rm-title-sm">Merchant Dashboard</h3>
                            <p class="rm-text-sm">Track payment activities, monitor collection channels, and improve
                                visibility across your merchant operations.</p>
                        </div>
                    </div>

                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M3 7h18"></path>
                                    <path d="M6 7V5h12v2"></path>
                                    <path d="M5 7l1 12h12l1-12"></path>
                                    <path d="M10 11v4"></path>
                                    <path d="M14 11v4"></path>
                                </svg>
                            </div>
                            <div class="rm-feature-number">05</div>
                            <h3 class="rm-title-sm">à la carte Store</h3>
                            <p class="rm-text-sm">Combine ordering and collection into a digital store experience for
                                delivery, pickup, or contactless ordering.</p>
                        </div>
                    </div>

                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 21s-7-4.35-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 11c0 5.65-7 10-7 10z">
                                    </path>
                                </svg>
                            </div>
                            <div class="rm-feature-number">06</div>
                            <h3 class="rm-title-sm">Loyalty &amp; Retention</h3>
                            <p class="rm-text-sm">Encourage repeat business with merchant-led loyalty features and
                                stronger customer engagement options.</p>
                        </div>
                    </div>

                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M3 10V6a2 2 0 0 1 2-2h14l2 2v4"></path>
                                    <path d="M3 10h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <path d="M9 14h6"></path>
                                </svg>
                            </div>
                            <div class="rm-feature-number">07</div>
                            <h3 class="rm-title-sm">eVoucher Campaigns</h3>
                            <p class="rm-text-sm">Launch promotional voucher campaigns that create stronger incentives
                                for customers to buy and return.</p>
                        </div>
                    </div>

                    <div class="rm-card rm-card-glow">
                        <div class="rm-card-pad">
                            <div class="rm-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </div>
                            <div class="rm-feature-number">08</div>
                            <h3 class="rm-title-sm">Integration &amp; Growth</h3>
                            <p class="rm-text-sm">Connect payment capabilities with accounting tools, POS systems, or
                                internal business workflows as you scale.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WHY CLIENTS LIKE IT -->
        <section class="rm-section">
            <div class="rm-container">
                <div class="rm-grid rm-grid-2-even">
                    <div class="rm-card">
                        <div class="rm-card-pad">
                            <div class="rm-badge rm-mb-20">Why Clients Like It</div>
                            <h2 class="rm-title-md">A smoother payment experience for your customers.</h2>
                            <p class="rm-text rm-mb-30">
                                A better payment journey does not only help you collect money faster — it also improves
                                trust, convenience, and the professionalism of your business.
                            </p>

                            <div class="rm-grid" style="gap:14px;">
                                <div class="rm-mini-card">
                                    <h3 class="rm-title-sm" style="font-size:18px;">Less hassle</h3>
                                    <p class="rm-text-sm">Customers do not need to copy bank details manually or deal
                                        with unnecessary steps.</p>
                                </div>
                                <div class="rm-mini-card">
                                    <h3 class="rm-title-sm" style="font-size:18px;">More convenience</h3>
                                    <p class="rm-text-sm">Payment can happen more smoothly through links, online
                                        channels, terminals, and digital methods customers already use.</p>
                                </div>
                                <div class="rm-mini-card">
                                    <h3 class="rm-title-sm" style="font-size:18px;">More confidence</h3>
                                    <p class="rm-text-sm">A structured and modern payment experience helps your
                                        business appear more professional and trustworthy.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rm-card-dark">
                        <div class="rm-card-pad">
                            <div class="rm-badge rm-badge-dark rm-mb-20">Why Choose Us</div>
                            <h2 class="rm-title-md rm-title-md-dark">We help you choose the setup that actually fits
                                your business.</h2>
                            <p class="rm-text rm-text-dark rm-mb-28">
                                We do more than introduce a solution. We help merchants understand which RM services
                                make sense for their workflow, business model, and growth stage.
                            </p>

                            <div class="rm-grid rm-grid-2-even" style="gap:16px;">
                                <div class="rm-footer-card" style="background:rgba(255,255,255,.05);">
                                    <h3 class="rm-title-sm rm-title-dark" style="font-size:16px;">Business Matching
                                    </h3>
                                    <p>Identify whether online payment, terminal, payment link, or a broader RM setup
                                        fits best.</p>
                                </div>
                                <div class="rm-footer-card" style="background:rgba(255,255,255,.05);">
                                    <h3 class="rm-title-sm rm-title-dark" style="font-size:16px;">Merchant Guidance
                                    </h3>
                                    <p>Clearer onboarding explanation and more structured service presentation for
                                        merchants.</p>
                                </div>
                                <div class="rm-footer-card" style="background:rgba(255,255,255,.05);">
                                    <h3 class="rm-title-sm rm-title-dark" style="font-size:16px;">Professional Image
                                    </h3>
                                    <p>Upgrade your payment flow to look more modern, capable, and business-ready.</p>
                                </div>
                                <div class="rm-footer-card" style="background:rgba(255,255,255,.05);">
                                    <h3 class="rm-title-sm rm-title-dark" style="font-size:16px;">Growth Mindset</h3>
                                    <p>Choose a setup that supports both your current operations and your future scale.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SOLUTION FLOW -->
        <section class="rm-section" style="background:#f8fbfe;">
            <div class="rm-container">
                <div class="rm-center" style="max-width:860px;margin:0 auto 52px;">
                    <div class="rm-badge rm-mb-20">Simple Merchant Journey</div>
                    <h2 class="rm-title-md">From enquiry to application in a clearer flow.</h2>
                    <p class="rm-text">
                        Make it easier for potential clients to understand the process and take action with confidence.
                    </p>
                </div>

                <div class="rm-grid rm-grid-4">
                    <div class="rm-card">
                        <div class="rm-card-pad">
                            <div class="rm-feature-number">01</div>
                            <h3 class="rm-title-sm">Understand Your Needs</h3>
                            <p class="rm-text-sm">We identify your business type, collection style, and operational
                                needs.</p>
                        </div>
                    </div>

                    <div class="rm-card">
                        <div class="rm-card-pad">
                            <div class="rm-feature-number">02</div>
                            <h3 class="rm-title-sm">Match the Right RM Service</h3>
                            <p class="rm-text-sm">We help match you with the most suitable payment and merchant tools.
                            </p>
                        </div>
                    </div>

                    <div class="rm-card">
                        <div class="rm-card-pad">
                            <div class="rm-feature-number">03</div>
                            <h3 class="rm-title-sm">Submit Your Application</h3>
                            <p class="rm-text-sm">Use the dedicated merchant link to proceed with a more structured
                                onboarding journey.</p>
                        </div>
                    </div>

                    <div class="rm-card">
                        <div class="rm-card-pad">
                            <div class="rm-feature-number">04</div>
                            <h3 class="rm-title-sm">Start Collecting Better</h3>
                            <p class="rm-text-sm">Move toward smoother collections, stronger customer convenience, and
                                better merchant operations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FINAL CTA -->
        <section class="rm-section rm-dark-section">
            <div class="rm-container" style="position:relative;z-index:2;">
                <div class="rm-center" style="max-width:860px;margin:0 auto;">
                    <div class="rm-badge rm-badge-dark rm-mb-20">Start Your Merchant Journey</div>

                    <h2 class="rm-title-md rm-title-md-dark" style="font-size:clamp(2.15rem,4.5vw,3.9rem);">
                        Ready to grow with Revenue Monster?
                    </h2>

                    <p class="rm-text rm-text-dark rm-mb-36"
                        style="max-width:720px;margin-left:auto;margin-right:auto;">
                        Use our dedicated merchant sign-up link to start your application and explore a more connected
                        way to manage payments, collections, and merchant growth.
                    </p>

                    <div class="rm-btn-row" style="justify-content:center;margin-bottom:32px;">
                        <a class="rm-btn rm-btn-light"
                            href="https://oauth.revenuemonster.my/register?redirectUri=https://merchant.revenuemonster.my/dashboard&partnerId=1752158596631029180">
                            Sign Up Now
                        </a>

                        <a class="rm-btn rm-btn-outline" href="#rm-services">
                            Review Services
                        </a>
                    </div>

                    <div class="rm-footer-grid">
                        <div class="rm-footer-card">
                            <div class="rm-note" style="color:#94a3b8;">Online Payment</div>
                            <p>Support eCommerce and digital payment acceptance with a more complete merchant ecosystem.
                            </p>
                        </div>

                        <div class="rm-footer-card">
                            <div class="rm-note" style="color:#94a3b8;">Payment Link</div>
                            <p>Create invoice links, share instantly, and reduce friction in customer collection.</p>
                        </div>

                        <div class="rm-footer-card">
                            <div class="rm-note" style="color:#94a3b8;">Merchant Platform</div>
                            <p>Dashboard, terminal, app, merchant tools, and integration possibilities for business
                                growth.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
