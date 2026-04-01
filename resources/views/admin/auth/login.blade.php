<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — {{ config('app.name', 'ATigaBookStore') }}</title>

    {{-- Favicon --}}
    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/favicon.png'))
        <link rel="icon" type="image/png" href="{{ asset('storage/logo/favicon.png') }}">
    @elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
        <link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.png') }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --ink-950: #050d1f;
            --ink-900: #0b1730;
            --ink-800: #152848;
            --card: #14233f;
            --line: rgba(138, 163, 205, .22);
            --primary: #1d7be6;
            --primary-2: #0ea5e9;
            --accent: #f59e0b;
            --accent-soft: #fbbf24;
            --muted-300: #a8bfdc;
            --muted-500: #7391b7;
            --white: #f8fbff;
        }

        html,
        body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at 12% 18%, rgba(14, 165, 233, .22), transparent 36%),
                radial-gradient(circle at 86% 10%, rgba(245, 158, 11, .16), transparent 30%),
                linear-gradient(160deg, #050b18 0%, #071227 36%, #0a1a38 100%);
            overflow: hidden;
            color: var(--white);
            color-scheme: dark;
        }

        /* ── Root layout ── */
        .al-root {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* ══════════════════════════════════════
           LEFT PANEL
        ══════════════════════════════════════ */
        .al-left {
            display: none;
            flex: 0 0 48%;
            position: relative;
            background:
                radial-gradient(circle at 18% 15%, rgba(29, 123, 230, .26), transparent 32%),
                radial-gradient(circle at 84% 78%, rgba(245, 158, 11, .14), transparent 30%),
                linear-gradient(145deg, #050d20 0%, #0d1f42 54%, #142d59 100%);
            overflow: hidden;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.6rem 3rem 4.7rem;
            border-right: 1px solid rgba(164, 196, 236, .12);
        }

        @media (min-width: 900px) {
            .al-left {
                display: flex;
            }
        }

        /* animated grid */
        .al-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(147, 197, 253, .08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(147, 197, 253, .08) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: gridMove 16s linear infinite;
        }

        .al-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(6, 13, 30, .76) 0%, rgba(6, 13, 30, .2) 55%, rgba(6, 13, 30, .5) 100%);
            pointer-events: none;
        }

        @keyframes gridMove {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 40px 40px;
            }
        }

        /* glow orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            pointer-events: none;
        }

        .orb-1 {
            width: 380px;
            height: 380px;
            background: rgba(14, 165, 233, .2);
            top: -80px;
            left: -80px;
            animation: oPulse 6s ease-in-out infinite;
        }

        .orb-2 {
            width: 260px;
            height: 260px;
            background: rgba(245, 158, 11, .14);
            bottom: 80px;
            right: -60px;
            animation: oPulse 8s ease-in-out infinite reverse;
        }

        .orb-3 {
            width: 180px;
            height: 180px;
            background: rgba(29, 123, 230, .16);
            bottom: -40px;
            left: 30%;
            animation: oPulse 7s ease-in-out 2s infinite;
        }

        @keyframes oPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.15);
                opacity: .7;
            }
        }

        /* ── Left: Brand ── */
        .left-brand {
            position: relative;
            z-index: 2;
        }

        .left-brand-inner {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .left-logo-wrap {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            overflow: hidden;
            border: 1.5px solid rgba(255, 255, 255, .12);
            flex-shrink: 0;
        }

        .left-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .left-logo-fallback {
            width: 46px;
            height: 46px;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
        }

        .left-brand-name {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
            letter-spacing: -.2px;
        }

        .left-brand-tag {
            font-size: .7rem;
            color: var(--slate-400);
            font-weight: 500;
        }

        /* ── Left: Visual center ── */
        .left-visual {
            position: relative;
            z-index: 2;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 2rem 0;
        }

        .shield-wrap {
            position: relative;
            margin-bottom: 2.5rem;
        }

        .shield-svg {
            width: 160px;
            height: 160px;
            filter: drop-shadow(0 0 44px rgba(14, 165, 233, .5));
            animation: shieldFloat 4s ease-in-out infinite;
        }

        @keyframes shieldFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .ring {
            position: absolute;
            inset: -20px;
            border-radius: 50%;
            border: 1.5px dashed rgba(125, 211, 252, .4);
            animation: ringRot 12s linear infinite;
        }

        .ring::before {
            content: '';
            position: absolute;
            top: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary-2);
            box-shadow: 0 0 10px var(--primary-2);
        }

        .ring-2 {
            position: absolute;
            inset: -40px;
            border-radius: 50%;
            border: 1px dashed rgba(245, 158, 11, .35);
            animation: ringRot 18s linear infinite reverse;
        }

        @keyframes ringRot {
            to {
                transform: rotate(360deg);
            }
        }

        .left-headline {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.9rem;
            color: #fff;
            line-height: 1.18;
            margin-bottom: .75rem;
            letter-spacing: -.5px;
        }

        .left-headline span {
            color: var(--accent-soft);
        }

        .left-sub {
            font-size: .92rem;
            color: var(--muted-300);
            line-height: 1.65;
            max-width: 320px;
        }

        /* ── Left: Feature pills ── */
        .left-features {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: .3rem;
        }

        .fpill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(173, 206, 244, .2);
            border-radius: 12px;
            padding: 12px 16px;
            backdrop-filter: blur(10px);
            transition: transform .25s ease, border-color .25s ease, background .25s ease;
        }

        .fpill:hover {
            transform: translateY(-2px);
            border-color: rgba(173, 206, 244, .3);
            background: rgba(255, 255, 255, .08);
        }

        .fpill-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .fpill-icon.blue {
            background: rgba(14, 165, 233, .2);
            color: #7dd3fc;
        }

        .fpill-icon.orange {
            background: rgba(245, 158, 11, .2);
            color: var(--accent-soft);
        }

        .fpill-body strong {
            display: block;
            font-size: .8rem;
            font-weight: 700;
            color: #eef5ff;
        }

        .fpill-body span {
            font-size: .72rem;
            color: var(--muted-500);
        }

        /* ══════════════════════════════════════
           RIGHT PANEL
        ══════════════════════════════════════ */
        .al-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 78% 12%, rgba(245, 158, 11, .16), transparent 26%),
                radial-gradient(circle at 24% 82%, rgba(14, 165, 233, .18), transparent 28%),
                linear-gradient(150deg, var(--ink-900) 0%, #0f2142 100%);
            padding: 2rem 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .al-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(197, 221, 252, .08) 1px, transparent 1px);
            background-size: 22px 22px;
            pointer-events: none;
        }

        /* ── Form Card ── */
        .form-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 400px;
            background: linear-gradient(165deg, rgba(21, 40, 72, .95) 0%, rgba(17, 34, 62, .95) 100%);
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 2.25rem 2rem 2rem;
            box-shadow: 0 32px 74px rgba(3, 10, 24, .65), inset 0 1px 0 rgba(255, 255, 255, .08);
            animation: cardUp .55s cubic-bezier(.22, .68, 0, 1.15) both;
            backdrop-filter: blur(10px);
        }

        @keyframes cardUp {
            from {
                opacity: 0;
                transform: translateY(28px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Top accent bar */
        .card-accent {
            position: absolute;
            top: 0;
            left: 9%;
            right: 9%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary-2), var(--accent), var(--primary), transparent);
            border-radius: 0 0 6px 6px;
            filter: drop-shadow(0 5px 15px rgba(14, 165, 233, .35));
        }

        /* ── Card Header ── */
        .card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .card-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(14, 165, 233, .12);
            border: 1px solid rgba(125, 211, 252, .35);
            border-radius: 100px;
            padding: 2px 10px;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: #7dd3fc;
            margin-bottom: 7px;
        }

        .card-title {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.45rem;
            color: #f7fbff;
            letter-spacing: -.45px;
            line-height: 1.2;
        }

        .card-sub {
            font-size: .82rem;
            color: var(--muted-500);
            margin-top: 4px;
        }

        /* Mobile-only logo (shows when left panel is hidden) */
        .mobile-logo {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 2px;
        }

        @media (min-width: 900px) {
            .mobile-logo {
                display: none;
            }
        }

        .mobile-logo-img {
            width: 38px;
            height: 38px;
            object-fit: contain;
            border-radius: 8px;
        }

        .mobile-logo-fb {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: .9rem;
            color: #fff;
        }

        .mobile-logo-name {
            font-size: .65rem;
            color: var(--muted-500);
            font-weight: 700;
        }

        .form-divider {
            border: none;
            border-top: 1px solid rgba(138, 163, 205, .15);
            margin: 0 0 1.5rem;
        }

        /* ── Alerts ── */
        .al-alert {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            border-radius: 10px;
            padding: .7rem .9rem;
            font-size: .8rem;
            margin-bottom: 1.25rem;
            line-height: 1.4;
        }

        .al-alert i {
            margin-top: 1px;
            flex-shrink: 0;
        }

        .al-alert.err {
            background: rgba(239, 68, 68, .08);
            border: 1px solid rgba(239, 68, 68, .2);
            color: #fca5a5;
        }

        .al-alert.ok {
            background: rgba(34, 197, 94, .08);
            border: 1px solid rgba(34, 197, 94, .2);
            color: #86efac;
        }

        /* ── Fields ── */
        .fblock {
            margin-bottom: 1rem;
        }

        .flabel {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: .72rem;
            font-weight: 700;
            color: var(--muted-300);
            text-transform: uppercase;
            letter-spacing: .7px;
            margin-bottom: 7px;
        }

        .flabel i {
            font-size: .65rem;
        }

        .fbox {
            position: relative;
        }

        .finput {
            width: 100%;
            background: #0a1730;
            border: 1.5px solid rgba(138, 163, 205, .2);
            border-radius: 11px;
            padding: .72rem 2.7rem .72rem 2.75rem;
            font-size: .9rem;
            color: #e8f2ff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }

        .finput::placeholder {
            color: #48628a;
        }

        .finput:focus {
            border-color: var(--primary-2);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .2);
            background: #0d1d3a;
        }

        .finput.is-err {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        .fi-l,
        .fi-r {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: .82rem;
            pointer-events: none;
            color: #6180a9;
            transition: color .2s;
        }

        .fi-l {
            left: 13px;
        }

        .fi-r {
            right: 13px;
            pointer-events: all;
            cursor: pointer;
        }

        .fi-r:hover {
            color: var(--muted-300);
        }

        .fbox:focus-within .fi-l,
        .fbox:focus-within .fi-r {
            color: #9ec5f5;
        }

        .ferr {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: .74rem;
            color: #f87171;
            margin-top: 5px;
        }

        /* ── Meta row ── */
        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            margin-top: 1rem;
        }

        .chk-label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            user-select: none;
        }

        .chk-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--blue-600);
            cursor: pointer;
        }

        .chk-label span {
            font-size: .8rem;
            color: var(--muted-500);
        }

        /* ── Submit btn ── */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 54%, var(--accent) 100%);
            color: #fff;
            border: none;
            border-radius: 11px;
            padding: .82rem 1rem;
            font-size: .92rem;
            font-weight: 800;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: box-shadow .25s, transform .1s, filter .2s;
            position: relative;
            overflow: hidden;
            letter-spacing: .2px;
            margin-bottom: .9rem;
            box-shadow: 0 8px 28px rgba(14, 165, 233, .42);
        }

        .btn-login:hover {
            box-shadow: 0 10px 30px rgba(14, 165, 233, .52);
            filter: brightness(1.08);
        }

        .btn-login:active {
            transform: scale(.985);
        }

        .btn-login.loading {
            pointer-events: none;
            opacity: .85;
        }

        /* shine sweep */
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .12), transparent);
            transition: left .5s ease;
        }

        .btn-login:hover::before {
            left: 150%;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, .25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .65s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .rpl {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: rpl .55s linear;
            background: rgba(255, 255, 255, .18);
            width: 80px;
            height: 80px;
            margin-left: -40px;
            margin-top: -40px;
            pointer-events: none;
        }

        @keyframes rpl {
            to {
                transform: scale(4.5);
                opacity: 0;
            }
        }

        /* ── Secure row ── */
        .secure-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: .73rem;
            color: #5d7ea9;
            margin-bottom: 1.25rem;
            letter-spacing: .2px;
        }

        .secure-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 6px #22c55e;
            flex-shrink: 0;
            animation: dotP 2.5s ease-in-out infinite;
        }

        @keyframes dotP {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }

        /* ── Back row ── */
        .back-row {
            text-align: center;
            border-top: 1px solid rgba(138, 163, 205, .1);
            padding-top: 1.1rem;
        }

        .back-row a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .78rem;
            color: #8fb0da;
            text-decoration: none;
            transition: color .2s;
        }

        .back-row a:hover {
            color: #c7ddf8;
        }

        .back-row a i {
            font-size: .7rem;
        }

        /* ── Particles ── */
        .prt {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            animation: prtFly linear infinite;
        }

        @keyframes prtFly {
            0% {
                opacity: 0;
                transform: translateY(0) scale(1);
            }

            10% {
                opacity: .6;
            }

            90% {
                opacity: .2;
            }

            100% {
                opacity: 0;
                transform: translateY(-80vh) scale(.5);
            }
        }

        @media (max-width: 899px) {
            body {
                overflow: auto;
            }

            .al-root {
                min-height: 100vh;
                height: auto;
            }

            .al-right {
                padding: 1.25rem;
                min-height: 100vh;
            }

            .form-card {
                max-width: 460px;
                padding: 1.85rem 1.3rem 1.4rem;
                border-radius: 18px;
            }

            .card-title {
                font-size: 1.22rem;
            }

            .card-sub {
                font-size: .78rem;
            }

            .meta-row {
                margin-bottom: 1.2rem;
            }
        }

        @media (max-height: 830px) and (min-width: 900px) {
            .al-left {
                padding: 2rem 2.2rem 4.2rem;
            }

            .left-visual {
                padding: 1.25rem 0;
            }

            .left-features {
                gap: 8px;
            }

            .fpill {
                padding: 10px 14px;
            }
        }
    </style>
</head>

<body>
    <div class="al-root">

        {{-- ═══════ LEFT PANEL ═══════ --}}
        <div class="al-left">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>

            {{-- Brand --}}
            <div class="left-brand">
                <div class="left-brand-inner">
                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
                        <div class="left-logo-wrap">
                            <img src="{{ asset('storage/logo/logo.png') }}" alt="{{ config('app.name') }}">
                        </div>
                    @else
                        <div class="left-logo-fallback">{{ strtoupper(substr(config('app.name', 'B'), 0, 1)) }}</div>
                    @endif
                    <div>
                        <div class="left-brand-name">{{ config('app.name', 'ATigaBookStore') }}</div>
                        <div class="left-brand-tag">Toko Buku Anak</div>
                    </div>
                </div>
            </div>

            {{-- Shield illustration --}}
            <div class="left-visual">
                <div class="shield-wrap">
                    <div class="ring-2"></div>
                    <div class="ring"></div>
                    <svg class="shield-svg" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="sg1" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#3b82f6" />
                                <stop offset="100%" stop-color="#1d4ed8" />
                            </linearGradient>
                            <linearGradient id="sg2" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#1e3a8a" stop-opacity=".9" />
                                <stop offset="100%" stop-color="#0f172a" stop-opacity=".7" />
                            </linearGradient>
                            <filter id="glow">
                                <feGaussianBlur stdDeviation="4" result="blur" />
                                <feMerge>
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                        </defs>
                        <path d="M80 14 L138 36 L138 80 C138 112 112 136 80 148 C48 136 22 112 22 80 L22 36 Z"
                            fill="url(#sg2)" stroke="url(#sg1)" stroke-width="2.5" />
                        <path d="M80 26 L126 44 L126 80 C126 106 106 126 80 138 C54 126 34 106 34 80 L34 44 Z"
                            fill="rgba(37,99,235,0.18)" stroke="rgba(59,130,246,0.4)" stroke-width="1.5" />
                        <rect x="62" y="78" width="36" height="28" rx="5" fill="url(#sg1)" opacity=".95"
                            filter="url(#glow)" />
                        <path d="M69 78 L69 70 C69 62.3 91 62.3 91 70 L91 78" stroke="#60a5fa" stroke-width="3.5"
                            stroke-linecap="round" fill="none" />
                        <circle cx="80" cy="93" r="4" fill="white" opacity=".9" />
                        <rect x="78.5" y="93" width="3" height="6" rx="1" fill="white"
                            opacity=".9" />
                        <circle cx="80" cy="48" r="3" fill="#3b82f6" opacity=".7" />
                        <circle cx="112" cy="62" r="2" fill="#f97316" opacity=".5" />
                        <circle cx="48" cy="62" r="2" fill="#3b82f6" opacity=".4" />
                    </svg>
                </div>
                <h1 class="left-headline">Panel Kontrol<br><span>Admin Terpercaya</span></h1>
                <p class="left-sub">Kelola seluruh operasional toko buku Anda dengan mudah, aman, dan efisien dalam
                    satu platform.</p>
            </div>

            {{-- Feature pills --}}
            <div class="left-features">
                <div class="fpill">
                    <div class="fpill-icon blue"><i class="fas fa-chart-line"></i></div>
                    <div class="fpill-body">
                        <strong>Dashboard Analitik</strong>
                        <span>Monitor penjualan &amp; tren real-time</span>
                    </div>
                </div>
                <div class="fpill">
                    <div class="fpill-icon orange"><i class="fas fa-boxes-stacked"></i></div>
                    <div class="fpill-body">
                        <strong>Manajemen Produk</strong>
                        <span>Kelola buku, kategori, &amp; stok dengan mudah</span>
                    </div>
                </div>
                <div class="fpill">
                    <div class="fpill-icon blue"><i class="fas fa-lock"></i></div>
                    <div class="fpill-body">
                        <strong>Akses Aman &amp; Terenkripsi</strong>
                        <span>Sesi terlindungi dengan enkripsi penuh</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════ RIGHT PANEL ═══════ --}}
        <div class="al-right" id="rightPanel">
            <div class="form-card">
                <div class="card-accent"></div>

                {{-- Card header --}}
                <div class="card-header">
                    <div>
                        <div class="card-eyebrow"><i class="fas fa-shield-halved"></i> Admin Panel</div>
                        <h2 class="card-title">Masuk ke<br>Ruang Kendali Admin</h2>
                        <p class="card-sub">Gunakan akun admin untuk melanjutkan pengelolaan toko</p>
                    </div>
                    {{-- Mobile logo --}}
                    <div class="mobile-logo">
                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('logo/logo.png'))
                            <img src="{{ asset('storage/logo/logo.png') }}" alt="{{ config('app.name') }}"
                                class="mobile-logo-img">
                        @else
                            <div class="mobile-logo-fb">{{ strtoupper(substr(config('app.name', 'B'), 0, 1)) }}</div>
                        @endif
                        <span class="mobile-logo-name">{{ config('app.name', 'ATigaBookStore') }}</span>
                    </div>
                </div>

                <hr class="form-divider">

                {{-- Alerts --}}
                @if (session('error'))
                    <div class="al-alert err">
                        <i class="fas fa-circle-exclamation"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="al-alert err">
                        <i class="fas fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
                @if (session('status'))
                    <div class="al-alert ok">
                        <i class="fas fa-circle-check"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.login.store') }}" id="adminLoginForm">
                    @csrf

                    {{-- Email --}}
                    <div class="fblock">
                        <div class="flabel"><i class="fas fa-envelope"></i> Alamat Email</div>
                        <div class="fbox">
                            <i class="fas fa-envelope fi-l"></i>
                            <input type="email" id="email" name="email"
                                class="finput {{ $errors->has('email') ? 'is-err' : '' }}"
                                value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus
                                autocomplete="username">
                            <i class="fas fa-circle-check fi-r" id="emailCheck"
                                style="display:none;color:#4ade80;pointer-events:none;"></i>
                        </div>
                        @error('email')
                            <div class="ferr"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="fblock" style="margin-bottom:0;">
                        <div class="flabel"><i class="fas fa-lock"></i> Password</div>
                        <div class="fbox">
                            <i class="fas fa-lock fi-l"></i>
                            <input type="password" id="password" name="password"
                                class="finput {{ $errors->has('password') ? 'is-err' : '' }}"
                                placeholder="••••••••••" required autocomplete="current-password">
                            <i class="fas fa-eye fi-r" id="togglePwdIcon" onclick="togglePwd()"></i>
                        </div>
                        @error('password')
                            <div class="ferr"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember --}}
                    <div class="meta-row">
                        <label class="chk-label">
                            <input type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-login" id="submitBtn">
                        <i class="fas fa-right-to-bracket" id="btnIcon"></i>
                        <span id="btnText">Masuk ke Dashboard</span>
                    </button>
                </form>

                {{-- Secure row --}}
                <div class="secure-row">
                    <div class="secure-dot"></div>
                    Koneksi aman &mdash; SSL terenkripsi
                </div>

                {{-- Back --}}
                <div class="back-row">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke toko
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePwd() {
            const inp = document.getElementById('password');
            const ico = document.getElementById('togglePwdIcon');
            if (inp.type === 'password') {
                inp.type = 'text';
                ico.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                inp.type = 'password';
                ico.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        const emailEl = document.getElementById('email');
        const emailChk = document.getElementById('emailCheck');
        emailEl.addEventListener('input', function() {
            emailChk.style.display = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value) ? 'block' : 'none';
        });
        if (emailEl.value) emailEl.dispatchEvent(new Event('input'));

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.addEventListener('click', function(e) {
            const r = this.getBoundingClientRect();
            const s = document.createElement('span');
            s.className = 'rpl';
            s.style.left = (e.clientX - r.left) + 'px';
            s.style.top = (e.clientY - r.top) + 'px';
            this.appendChild(s);
            setTimeout(() => s.remove(), 650);
        });

        document.getElementById('adminLoginForm').addEventListener('submit', function() {
            submitBtn.classList.add('loading');
            document.getElementById('btnIcon').style.display = 'none';
            document.getElementById('btnText').textContent = 'Memproses\u2026';
            const sp = document.createElement('div');
            sp.className = 'spinner';
            submitBtn.prepend(sp);
        });

        /* Floating particles */
        (function() {
            const panel = document.getElementById('rightPanel');
            const sizes = [3, 4, 5, 6];
            const colors = ['rgba(14,165,233,.34)', 'rgba(125,211,252,.24)', 'rgba(245,158,11,.22)'];

            function create() {
                const p = document.createElement('div');
                p.className = 'prt';
                const sz = sizes[Math.floor(Math.random() * sizes.length)];
                p.style.cssText = [
                    'width:' + sz + 'px', 'height:' + sz + 'px',
                    'background:' + colors[Math.floor(Math.random() * colors.length)],
                    'left:' + (Math.random() * 100) + '%',
                    'bottom:-' + sz + 'px',
                    'animation-duration:' + (6 + Math.random() * 8) + 's',
                    'animation-delay:' + (Math.random() * 4) + 's',
                    'filter:blur(' + (Math.random() > .5 ? 1 : 0) + 'px)',
                ].join(';');
                panel.appendChild(p);
                setTimeout(() => p.remove(), 14000);
            }
            setInterval(create, 800);
            for (let i = 0; i < 8; i++) create();
        })();
    </script>
</body>

</html>
