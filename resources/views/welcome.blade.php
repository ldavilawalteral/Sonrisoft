<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sonrisoft – Software de Gestión para Clínicas Dentales</title>
    <meta name="description" content="Sonrisoft es el software todo-en-uno para clínicas dentales. Historias clínicas digitales, odontogramas, agenda inteligente, inventario y reportes. Pago único, sin mensualidades.">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =========================================================
           ROOT & GLOBAL
        ========================================================= */
        :root {
            --primary:       #0d6efd;
            --primary-dark:  #0a58ca;
            --primary-light: #e8f0fe;
            --accent:        #00b4d8;
            --success:       #198754;
            --dark:          #0f172a;
            --text-muted:    #64748b;
            --card-border:   #e2e8f0;
            --section-gray:  #f8fafc;
            --hero-gradient: linear-gradient(135deg, #ebf4ff 0%, #dbeafe 60%, #cffafe 100%);
        }

        * { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* =========================================================
           NAVBAR
        ========================================================= */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,.06);
            transition: box-shadow .3s;
        }
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,.08); }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }
        .navbar-brand i { color: var(--accent); }

        .nav-link {
            font-weight: 500;
            color: #475569 !important;
            padding: .5rem .9rem !important;
            border-radius: .5rem;
            transition: background .2s, color .2s;
        }
        .nav-link:hover {
            color: var(--primary) !important;
            background: var(--primary-light);
        }

        /* =========================================================
           HERO
        ========================================================= */
        .hero-section {
            background: var(--hero-gradient);
            padding: 7rem 0 5rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,180,216,.12) 0%, transparent 70%);
            top: -200px; right: -200px;
            pointer-events: none;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: white;
            border: 1px solid var(--card-border);
            color: var(--primary);
            border-radius: 50px;
            padding: .35rem 1rem;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(13,110,253,.1);
        }
        .hero-title {
            font-weight: 800;
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            line-height: 1.15;
            color: var(--dark);
            letter-spacing: -1.5px;
            margin-bottom: 1.25rem;
        }
        .hero-title span {
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            line-height: 1.7;
            max-width: 520px;
            margin-bottom: 2.5rem;
        }
        .hero-cta-group { display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; }
        .btn-hero-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            padding: .85rem 2rem;
            border-radius: 50px;
            box-shadow: 0 8px 24px rgba(13,110,253,.35);
            transition: transform .2s, box-shadow .2s;
            text-decoration: none;
        }
        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(13,110,253,.45);
            color: white;
        }
        .btn-hero-secondary {
            border: 2px solid var(--card-border);
            color: var(--dark);
            background: white;
            font-weight: 600;
            font-size: 1rem;
            padding: .8rem 1.75rem;
            border-radius: 50px;
            text-decoration: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .btn-hero-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 4px 16px rgba(13,110,253,.12);
        }
        .hero-trust {
            margin-top: 2rem;
            font-size: .85rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .hero-trust i { color: var(--success); }
        .hero-image-wrapper {
            position: relative;
        }
        .hero-image-wrapper::before {
            content: '';
            position: absolute;
            inset: -12px;
            border-radius: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            opacity: .12;
            z-index: 0;
        }
        .hero-image-wrapper img {
            position: relative;
            z-index: 1;
        }
        .hero-wave {
            position: absolute;
            bottom: -1px; left: 0;
            width: 100%; line-height: 0;
        }

        /* =========================================================
           STATS BAR
        ========================================================= */
        .stats-bar {
            background: white;
            border-bottom: 1px solid var(--card-border);
            padding: 1.75rem 0;
        }
        .stat-item { text-align: center; padding: 0 1rem; }
        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            display: block;
        }
        .stat-label { font-size: .8rem; color: var(--text-muted); font-weight: 500; }

        /* =========================================================
           FEATURES SECTION
        ========================================================= */
        .features-section {
            padding: 6rem 0;
            background: white;
        }
        .section-label {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 50px;
            padding: .3rem .9rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .section-title {
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        .section-subtitle { color: var(--text-muted); font-size: 1.05rem; max-width: 560px; }

        .feature-card {
            padding: 2.2rem;
            border-radius: 1.25rem;
            background: white;
            border: 1.5px solid var(--card-border);
            height: 100%;
            transition: transform .3s, box-shadow .3s, border-color .3s;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 48px rgba(13,110,253,.1);
            border-color: var(--primary);
        }
        .feature-icon {
            width: 60px; height: 60px;
            border-radius: 1rem;
            font-size: 1.5rem;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.3rem;
        }
        .fi-blue   { background: #dbeafe; color: #2563eb; }
        .fi-teal   { background: #cffafe; color: #0891b2; }
        .fi-green  { background: #dcfce7; color: #16a34a; }
        .fi-purple { background: #ede9fe; color: #7c3aed; }
        .fi-orange { background: #ffedd5; color: #ea580c; }
        .fi-pink   { background: #fce7f3; color: #db2777; }

        .feature-card h4 {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: .6rem;
        }
        .feature-card p { color: var(--text-muted); font-size: .93rem; line-height: 1.65; margin: 0; }

        /* =========================================================
           SCREENSHOTS SECTION
        ========================================================= */
        .screenshots-section {
            background: var(--section-gray);
            padding: 6rem 0;
            border-top: 1px solid var(--card-border);
            border-bottom: 1px solid var(--card-border);
        }
        .mockup-card {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            border: 1.5px solid var(--card-border);
            box-shadow: 0 8px 32px rgba(0,0,0,.06);
            transition: transform .3s, box-shadow .3s;
        }
        .mockup-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(0,0,0,.1); }
        .mockup-bar {
            background: #f1f5f9;
            padding: .6rem 1rem;
            display: flex; gap: .4rem; align-items: center;
            border-bottom: 1px solid var(--card-border);
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #22c55e; }
        .mockup-placeholder {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            display: flex; align-items: center; justify-content: center;
            flex-direction: column;
            gap: .75rem;
            color: #94a3b8;
            font-size: .85rem;
            font-weight: 500;
            min-height: 200px;
        }
        .mockup-placeholder i { font-size: 2.5rem; opacity: .5; }
        .mockup-desc h5 { font-weight: 700; color: var(--dark); margin-bottom: .4rem; }
        .mockup-desc p { color: var(--text-muted); font-size: .9rem; line-height: 1.6; margin: 0; }

        /* =========================================================
           PRICING SECTION
        ========================================================= */
        .pricing-section {
            padding: 6rem 0;
            background: white;
        }
        .pricing-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #ea580c;
            border-radius: 50px;
            padding: .3rem .9rem;
            font-size: .78rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .price-card {
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            border: 2px solid var(--card-border);
            background: white;
            height: 100%;
            display: flex; flex-direction: column;
            transition: transform .3s, box-shadow .3s;
            position: relative;
        }
        .price-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(0,0,0,.1); }
        .price-card.featured {
            border-color: var(--primary);
            background: linear-gradient(160deg, #f0f7ff 0%, white 80%);
            box-shadow: 0 12px 48px rgba(13,110,253,.2);
            transform: translateY(-12px);
        }
        .price-card.featured:hover { transform: translateY(-18px); }
        .popular-badge {
            position: absolute;
            top: -14px; left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(90deg, var(--primary), var(--accent));
            color: white;
            border-radius: 50px;
            padding: .3rem 1.2rem;
            font-size: .78rem;
            font-weight: 700;
            white-space: nowrap;
            letter-spacing: .3px;
        }
        .plan-name {
            font-size: .85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: .75rem;
        }
        .plan-name.featured-label { color: var(--primary); }
        .price-amount {
            font-size: 3rem;
            font-weight: 900;
            color: var(--dark);
            line-height: 1;
            letter-spacing: -2px;
            margin-bottom: .25rem;
        }
        .price-amount .currency {
            font-size: 1.6rem;
            font-weight: 700;
            vertical-align: top;
            margin-top: .4rem;
            display: inline-block;
        }
        .price-once {
            font-size: .8rem;
            font-weight: 600;
            color: var(--success);
            background: #dcfce7;
            border-radius: 50px;
            padding: .2rem .75rem;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        .price-desc { color: var(--text-muted); font-size: .9rem; margin-bottom: 1.5rem; }
        .price-divider { border-color: var(--card-border); margin: 1.25rem 0; }
        .price-features { list-style: none; padding: 0; margin: 0 0 2rem; flex-grow: 1; }
        .price-features li {
            display: flex; align-items: flex-start; gap: .6rem;
            padding: .45rem 0;
            font-size: .92rem;
            color: #334155;
        }
        .price-features li i { color: var(--success); font-size: .85rem; margin-top: .15rem; flex-shrink: 0; }
        .price-features li.disabled { color: #94a3b8; }
        .price-features li.disabled i { color: #cbd5e1; }
        .btn-plan {
            display: block;
            text-align: center;
            padding: .9rem;
            border-radius: .8rem;
            font-weight: 700;
            font-size: .95rem;
            text-decoration: none;
            transition: all .25s;
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            margin-top: auto;
        }
        .btn-plan:hover {
            background: var(--primary);
            color: white;
            box-shadow: 0 8px 20px rgba(13,110,253,.3);
        }
        .btn-plan.featured-btn {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            box-shadow: 0 8px 24px rgba(13,110,253,.35);
        }
        .btn-plan.featured-btn:hover {
            box-shadow: 0 12px 32px rgba(13,110,253,.5);
            filter: brightness(1.05);
            color: white;
        }

        /* =========================================================
           TESTIMONIALS SECTION
        ========================================================= */
        .testimonials-section {
            background: var(--section-gray);
            padding: 6rem 0;
            border-top: 1px solid var(--card-border);
        }
        .testimonial-card {
            background: white;
            border-radius: 1.25rem;
            padding: 2rem;
            border: 1.5px solid var(--card-border);
            height: 100%;
            transition: transform .3s, box-shadow .3s;
            position: relative;
        }
        .testimonial-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,.08); }
        .testimonial-card::before {
            content: '\201C';
            font-size: 5rem;
            line-height: 1;
            color: var(--primary-light);
            position: absolute;
            top: .75rem; right: 1.5rem;
            font-family: Georgia, serif;
            pointer-events: none;
        }
        .stars { color: #f59e0b; font-size: .9rem; margin-bottom: 1rem; letter-spacing: 1px; }
        .testimonial-text { color: #475569; font-size: .95rem; line-height: 1.7; margin-bottom: 1.5rem; }
        .testimonial-author { display: flex; align-items: center; gap: .9rem; }
        .author-avatar {
            width: 46px; height: 46px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
        }
        .av-blue { background: linear-gradient(135deg, #2563eb, #0891b2); }
        .av-green { background: linear-gradient(135deg, #16a34a, #0d9488); }
        .av-purple { background: linear-gradient(135deg, #7c3aed, #db2777); }
        .author-name { font-weight: 700; font-size: .95rem; color: var(--dark); }
        .author-role { font-size: .8rem; color: var(--text-muted); }

        /* =========================================================
           CTA SECTION
        ========================================================= */
        .cta-section {
            background: linear-gradient(135deg, var(--dark) 0%, #1e3a8a 100%);
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,180,216,.15) 0%, transparent 70%);
            top: -200px; right: -100px;
            pointer-events: none;
        }
        .cta-section h2 {
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            font-weight: 800;
            color: white;
            letter-spacing: -1px;
            margin-bottom: 1rem;
        }
        .cta-section p { color: rgba(255,255,255,.7); font-size: 1.05rem; margin-bottom: 2rem; }

        /* =========================================================
           FOOTER
        ========================================================= */
        footer {
            background: var(--dark);
            color: #94a3b8;
            padding: 4rem 0 2rem;
        }
        .footer-brand {
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: .4rem;
        }
        .footer-brand span { color: var(--accent); }
        .footer-desc { font-size: .88rem; color: #64748b; line-height: 1.7; margin-top: .75rem; max-width: 260px; }
        .footer-heading { color: white; font-weight: 700; font-size: .9rem; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 1rem; }
        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: .5rem; }
        .footer-links a { color: #64748b; text-decoration: none; font-size: .9rem; transition: color .2s; }
        .footer-links a:hover { color: white; }
        .footer-divider { border-color: #1e293b; margin: 2.5rem 0 1.5rem; }
        .footer-copy { font-size: .82rem; color: #475569; }

        /* =========================================================
           FAQ SECTION
        ========================================================= */
        .faq-section {
            padding: 6rem 0;
            background: white;
            border-top: 1px solid var(--card-border);
        }
        .faq-accordion .accordion-item {
            border: 1.5px solid var(--card-border);
            border-radius: 1rem !important;
            margin-bottom: .75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
            transition: box-shadow .2s;
        }
        .faq-accordion .accordion-item:hover {
            box-shadow: 0 6px 20px rgba(13,110,253,.1);
        }
        .faq-accordion .accordion-button {
            font-weight: 600;
            font-size: 1rem;
            color: var(--dark);
            background: white;
            padding: 1.25rem 1.5rem;
            border-radius: 1rem !important;
            box-shadow: none !important;
        }
        .faq-accordion .accordion-button:not(.collapsed) {
            color: var(--primary);
            background: var(--primary-light);
        }
        .faq-accordion .accordion-button::after {
            filter: none;
        }
        .faq-accordion .accordion-button:not(.collapsed)::after {
            filter: invert(30%) sepia(90%) saturate(300%) hue-rotate(200deg);
        }
        .faq-accordion .accordion-body {
            color: var(--text-muted);
            font-size: .95rem;
            line-height: 1.75;
            padding: .75rem 1.5rem 1.5rem;
            background: white;
        }

        /* =========================================================
           WHATSAPP FLOATING BUTTON
        ========================================================= */
        .btn-whatsapp-float {
            position: fixed;
            bottom: 1.75rem;
            right: 1.75rem;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: .6rem;
            background: #25D366;
            color: white;
            border-radius: 50px;
            padding: .75rem 1.25rem;
            font-weight: 700;
            font-size: .9rem;
            text-decoration: none;
            box-shadow: 0 8px 28px rgba(37,211,102,.45);
            transition: transform .25s, box-shadow .25s, padding .25s;
            overflow: hidden;
        }
        .btn-whatsapp-float i {
            font-size: 1.35rem;
            flex-shrink: 0;
        }
        .btn-whatsapp-float .wa-label {
            white-space: nowrap;
            max-width: 120px;
            overflow: hidden;
            transition: max-width .35s ease, opacity .35s ease;
            opacity: 1;
        }
        .btn-whatsapp-float:hover {
            transform: translateY(-3px) scale(1.04);
            box-shadow: 0 14px 36px rgba(37,211,102,.55);
            color: white;
        }
        @media (max-width: 575.98px) {
            .btn-whatsapp-float .wa-label { max-width: 0; opacity: 0; }
            .btn-whatsapp-float { padding: .85rem; }
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 991.98px) {
            .hero-section { padding: 6rem 0 4rem; }
            .price-card.featured { transform: none; }
            .price-card.featured:hover { transform: translateY(-6px); }
        }
        @media (max-width: 767.98px) {
            .hero-cta-group { justify-content: center; }
            .hero-trust { justify-content: center; }
            .hero-section .text-center-sm { text-align: center !important; }
            .section-subtitle { max-width: 100%; }
        }
    </style>
</head>
<body>

{{-- =====================================================================
     NAVBAR
===================================================================== --}}
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fa-solid fa-tooth me-1"></i>Sonrisoft
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                @auth
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="btn btn-primary px-4 rounded-pill">
                            <i class="fas fa-gauge-high me-2"></i>Ir al Dashboard
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="#caracteristicas" class="nav-link">Características</a>
                    </li>
                    <li class="nav-item">
                        <a href="#precios" class="nav-link">Precios</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary px-4 rounded-pill">Iniciar Sesión</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item ms-lg-1">
                            <a href="#precios" class="btn btn-primary px-4 rounded-pill">Registrar mi Clínica</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- =====================================================================
     HERO SECTION
===================================================================== --}}
<section class="hero-section" id="inicio">
    <div class="container">
        <div class="row align-items-center g-5">
            {{-- Left: Text --}}
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="fa-solid fa-star-of-life fa-spin" style="font-size:.65rem; animation-duration:3s;"></i>
                    Software #1 para Clínicas Dentales en Perú
                </div>
                <h1 class="hero-title">
                    Gestiona tu clínica dental
                    <span>de forma inteligente</span>
                </h1>
                <p class="hero-subtitle">
                    Historiales clínicos, odontogramas, agenda, inventario y reportes financieros — todo en un solo sistema. Sin mensualidades. Un solo pago para siempre.
                </p>
                <div class="hero-cta-group">
                    <a href="#precios" class="btn-hero-primary">
                        Ver Planes y Precios &nbsp;<i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#caracteristicas" class="btn-hero-secondary">
                        <i class="fas fa-play-circle me-2 text-primary"></i>Conocer más
                    </a>
                </div>
                <div class="hero-trust">
                    <i class="fas fa-circle-check"></i> Sin mensualidades &nbsp;·&nbsp;
                    <i class="fas fa-circle-check"></i> Soporte incluido &nbsp;·&nbsp;
                    <i class="fas fa-circle-check"></i> Instalación en tu servidor
                </div>
            </div>

            {{-- Right: Dashboard Placeholder --}}
            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-image-wrapper">
                    {{--
                        ✅ INSTRUCCIÓN PARA EL DESARROLLADOR:
                        Reemplaza el src por la ruta real de tu captura de pantalla,
                        por ejemplo: src="{{ asset('img/dashboard-preview.png') }}"
                    --}}
                    <img
                        src="https://placehold.co/700x440/e8f0fe/2563eb?text=📊+Dashboard+Sonrisoft&font=Inter"
                        alt="Dashboard Sonrisoft - Vista previa del sistema"
                        class="img-fluid shadow-lg rounded"
                        style="border-radius: 1rem !important;"
                    >
                </div>
            </div>
        </div>
    </div>
    <!-- Wave Divider -->
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none" style="display:block;width:100%;height:80px;">
            <path fill="#ffffff" d="M0,40 C240,80 480,0 720,40 C960,80 1200,0 1440,40 L1440,80 L0,80 Z"/>
        </svg>
    </div>
</section>

{{-- =====================================================================
     STATS BAR
===================================================================== --}}
<div class="stats-bar">
    <div class="container">
        <div class="row justify-content-center g-3">
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">+500</span>
                <span class="stat-label">Pacientes gestionados</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">+50</span>
                <span class="stat-label">Clínicas activas</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">99.9%</span>
                <span class="stat-label">Disponibilidad del sistema</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">4.9★</span>
                <span class="stat-label">Valoración promedio</span>
            </div>
        </div>
    </div>
</div>

{{-- =====================================================================
     FEATURES SECTION
===================================================================== --}}
<section class="features-section" id="caracteristicas">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Características</div>
            <h2 class="section-title">Todo lo que tu clínica necesita</h2>
            <p class="section-subtitle mx-auto">Herramientas potentes diseñadas específicamente para odontólogos, en un sistema fácil de usar.</p>
        </div>

        <div class="row g-4">
            <!-- Historial Clínico Digital -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon fi-blue"><i class="fas fa-file-medical"></i></div>
                    <h4>Historial Clínico Digital</h4>
                    <p>Registra y accede al historial completo de cada paciente: diagnósticos, tratamientos, radiografías y evolución clínica, desde cualquier dispositivo.</p>
                </div>
            </div>
            <!-- Odontogramas Interactivos -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon fi-teal"><i class="fas fa-tooth"></i></div>
                    <h4>Odontogramas Interactivos</h4>
                    <p>Mapa dental visual e interactivo para registrar hallazgos, tratamientos realizados y planificados por superficie dental de forma rápida e intuitiva.</p>
                </div>
            </div>
            <!-- Agenda Inteligente -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon fi-green"><i class="fas fa-calendar-check"></i></div>
                    <h4>Agenda Inteligente</h4>
                    <p>Gestión de citas con vista diaria, semanal y mensual. Evita cruces de horario, administra tiempos por procedimiento y reduce las ausencias.</p>
                </div>
            </div>
            <!-- Control de Inventario -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon fi-orange"><i class="fas fa-boxes-stacked"></i></div>
                    <h4>Control de Inventario</h4>
                    <p>Gestiona materiales dentales y productos en tiempo real. Recibe alertas de stock bajo y lleva un historial de consumo y compras detallado.</p>
                </div>
            </div>
            <!-- Reportes Financieros -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon fi-purple"><i class="fas fa-chart-line"></i></div>
                    <h4>Reportes Financieros</h4>
                    <p>Visualiza ingresos, gastos, pagos pendientes y rentabilidad con gráficos claros. Exporta reportes para tomar decisiones basadas en datos reales.</p>
                </div>
            </div>
            <!-- Multi-sucursal / Multi-doctor -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon fi-pink"><i class="fas fa-hospital-user"></i></div>
                    <h4>Multi-sucursal / Multi-doctor</h4>
                    <p>Administra varias sedes y múltiples especialistas desde un único panel de control con roles y permisos diferenciados por usuario.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     SCREENSHOTS / MOCKUPS SECTION
===================================================================== --}}
<section class="screenshots-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Interfaz del Sistema</div>
            <h2 class="section-title">Diseñado para ser fácil de usar</h2>
            <p class="section-subtitle mx-auto">Una interfaz limpia y moderna que tu equipo aprenderá a dominar en minutos.</p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Mockup 1: Odontograma -->
            <div class="col-lg-5 d-flex flex-column gap-4">
                <div class="mockup-desc mt-auto">
                    <h5><i class="fas fa-tooth text-primary me-2"></i>Odontograma interactivo</h5>
                    <p>Haz clic en cualquier pieza dental para registrar tratamientos, caries, extracciones o restauraciones. El historial queda guardado automáticamente.</p>
                </div>
                <div class="mockup-card">
                    <div class="mockup-bar">
                        <div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div>
                        <small class="ms-2 text-muted" style="font-size:.7rem;">Sonrisoft – Odontograma</small>
                    </div>
                    {{-- ✅ Reemplaza este img con tu captura real --}}
                    <img
                        src="https://placehold.co/700x260/f8fafc/0891b2?text=🦷+Vista+del+Odontograma&font=Inter"
                        alt="Vista del odontograma interactivo"
                        class="img-fluid w-100"
                        style="display:block;"
                    >
                </div>
            </div>

            <!-- Mockup 2: Agenda -->
            <div class="col-lg-7 d-flex flex-column gap-4">
                <div class="mockup-card">
                    <div class="mockup-bar">
                        <div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div>
                        <small class="ms-2 text-muted" style="font-size:.7rem;">Sonrisoft – Agenda de Citas</small>
                    </div>
                    {{-- ✅ Reemplaza este img con tu captura real --}}
                    <img
                        src="https://placehold.co/900x260/f8fafc/16a34a?text=📅+Agenda+y+Calendar+View&font=Inter"
                        alt="Vista de la agenda de citas"
                        class="img-fluid w-100"
                        style="display:block;"
                    >
                </div>
                <div class="mockup-desc">
                    <h5><i class="fas fa-calendar-check text-success me-2"></i>Agenda inteligente de citas</h5>
                    <p>Visualiza todos los turnos del día o la semana de cada doctor. Arrastra y reorganiza citas con facilidad y detecta conflictos de horario al instante.</p>
                </div>
            </div>

            <!-- Mockup 3: Reportes (full width) -->
            <div class="col-12">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4">
                        <div class="mockup-desc">
                            <h5><i class="fas fa-chart-line text-purple me-2" style="color:#7c3aed"></i>Reportes Financieros</h5>
                            <p>Visualiza el rendimiento económico de tu clínica con gráficos de ingresos, cobros por doctor, y deuda de pacientes. Todo actualizado en tiempo real.</p>
                            <ul class="list-unstyled mt-3" style="font-size:.88rem; color:var(--text-muted);">
                                <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Ingresos diarios y mensuales</li>
                                <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Pagos pendientes por paciente</li>
                                <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Exportación en PDF y Excel</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="mockup-card">
                            <div class="mockup-bar">
                                <div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div>
                                <small class="ms-2 text-muted" style="font-size:.7rem;">Sonrisoft – Reportes</small>
                            </div>
                            {{-- ✅ Reemplaza este img con tu captura real --}}
                            <img
                                src="https://placehold.co/900x280/f8fafc/7c3aed?text=📊+Panel+de+Reportes+Financieros&font=Inter"
                                alt="Panel de reportes financieros"
                                class="img-fluid w-100"
                                style="display:block;"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     PRICING SECTION
===================================================================== --}}
<section class="pricing-section" id="precios">
    <div class="container">
        <div class="text-center mb-5">
            <div class="pricing-badge">
                <i class="fas fa-infinity"></i> Pago Único · Sin Mensualidades · Tuyo Para Siempre
            </div>
            <h2 class="section-title">Elige el plan ideal para tu clínica</h2>
            <p class="section-subtitle mx-auto">Un solo pago, acceso de por vida. Sin sorpresas, sin suscripciones. Elige tu plan y comienza hoy.</p>
        </div>

        <div class="row g-4 align-items-start justify-content-center">

            {{-- PLAN BÁSICO --}}
            <div class="col-md-10 col-lg-4">
                <div class="price-card">
                    <div class="plan-name">Plan Básico</div>
                    <div class="price-amount"><span class="currency">S/</span>200</div>
                    <div class="price-once"><i class="fas fa-check-circle me-1"></i>Pago único · Sin mensualidades</div>
                    <p class="price-desc">Ideal para odontólogos independientes que quieren digitalizar su consultorio.</p>
                    <hr class="price-divider">
                    <ul class="price-features">
                        <li><i class="fas fa-check-circle"></i> Gestión completa de pacientes</li>
                        <li><i class="fas fa-check-circle"></i> Historial clínico digital</li>
                        <li><i class="fas fa-check-circle"></i> Agenda de citas</li>
                        <li><i class="fas fa-check-circle"></i> Hasta <strong>1 doctor</strong></li>
                        <li><i class="fas fa-check-circle"></i> 1 sede/sucursal</li>
                        <li class="disabled"><i class="fas fa-times-circle"></i> <s>Odontograma interactivo</s></li>
                        <li class="disabled"><i class="fas fa-times-circle"></i> <s>Control de inventario</s></li>
                        <li class="disabled"><i class="fas fa-times-circle"></i> <s>Reportes financieros</s></li>
                    </ul>
                    {{-- Formulario POST → Mercado Pago (Plan Básico) --}}
                    <form method="POST" action="{{ route('payment.create') }}">
                        @csrf
                        <input type="hidden" name="plan_name" value="basico">
                        <input type="hidden" name="price" value="200">
                        <button type="submit" class="btn-plan w-100">
                            <i class="fas fa-credit-card me-2"></i>Elegir Plan Básico
                        </button>
                    </form>
                </div>
            </div>

            {{-- PLAN PROFESIONAL (DESTACADO) --}}
            <div class="col-md-10 col-lg-4">
                <div class="price-card featured">
                    <div class="popular-badge"><i class="fas fa-fire-flame-curved me-1"></i>Más Popular</div>
                    <div class="plan-name featured-label">Plan Profesional</div>
                    <div class="price-amount"><span class="currency">S/</span>400</div>
                    <div class="price-once"><i class="fas fa-check-circle me-1"></i>Pago único · Sin mensualidades</div>
                    <p class="price-desc">La opción más elegida por clínicas dentales en crecimiento.</p>
                    <hr class="price-divider">
                    <ul class="price-features">
                        <li><i class="fas fa-check-circle"></i> Todo lo del Plan Básico</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Odontograma interactivo</strong></li>
                        <li><i class="fas fa-check-circle"></i> Control de inventario completo</li>
                        <li><i class="fas fa-check-circle"></i> Hasta <strong>3 doctores</strong></li>
                        <li><i class="fas fa-check-circle"></i> Hasta 2 sucursales</li>
                        <li><i class="fas fa-check-circle"></i> Reportes básicos</li>
                        <li class="disabled"><i class="fas fa-times-circle"></i> <s>Reportes financieros avanzados</s></li>
                        <li class="disabled"><i class="fas fa-times-circle"></i> <s>Soporte prioritario</s></li>
                    </ul>
                    {{-- Formulario POST → Mercado Pago (Plan Profesional) --}}
                    <form method="POST" action="{{ route('payment.create') }}">
                        @csrf
                        <input type="hidden" name="plan_name" value="profesional">
                        <input type="hidden" name="price" value="400">
                        <button type="submit" class="btn-plan featured-btn w-100">
                            <i class="fas fa-credit-card me-2"></i>Elegir Plan Profesional
                        </button>
                    </form>
                </div>
            </div>

            {{-- PLAN PREMIUM --}}
            <div class="col-md-10 col-lg-4">
                <div class="price-card">
                    <div class="plan-name">Plan Premium</div>
                    <div class="price-amount"><span class="currency">S/</span>600</div>
                    <div class="price-once"><i class="fas fa-check-circle me-1"></i>Pago único · Sin mensualidades</div>
                    <p class="price-desc">Para clínicas con múltiples sedes y doctores que necesitan el máximo control.</p>
                    <hr class="price-divider">
                    <ul class="price-features">
                        <li><i class="fas fa-check-circle"></i> Todo lo del Plan Profesional</li>
                        <li><i class="fas fa-check-circle"></i> Doctores <strong>ilimitados</strong></li>
                        <li><i class="fas fa-check-circle"></i> Sucursales <strong>ilimitadas</strong></li>
                        <li><i class="fas fa-check-circle"></i> Reportes financieros avanzados</li>
                        <li><i class="fas fa-check-circle"></i> Exportación PDF y Excel</li>
                        <li><i class="fas fa-check-circle"></i> Gestión de roles y permisos</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Soporte prioritario</strong> vía WhatsApp</li>
                        <li><i class="fas fa-check-circle"></i> Actualizaciones de por vida</li>
                    </ul>
                    {{-- Formulario POST → Mercado Pago (Plan Premium) --}}
                    <form method="POST" action="{{ route('payment.create') }}">
                        @csrf
                        <input type="hidden" name="plan_name" value="premium">
                        <input type="hidden" name="price" value="600">
                        <button type="submit" class="btn-plan w-100">
                            <i class="fas fa-credit-card me-2"></i>Elegir Plan Premium
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pricing Footer Note -->
        <div class="text-center mt-5 pt-2">
            <p class="text-muted" style="font-size:.9rem;">
                <i class="fas fa-lock me-2 text-success"></i>Pago 100% seguro &nbsp;·&nbsp;
                <i class="fas fa-headset me-2 text-primary"></i>Soporte en español &nbsp;·&nbsp;
                <i class="fas fa-download me-2 text-primary"></i>Instalación asistida incluida
            </p>
        </div>
    </div>
</section>

{{-- =====================================================================
     TESTIMONIALS SECTION
===================================================================== --}}
<section class="testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Testimonios</div>
            <h2 class="section-title">Lo que dicen nuestros clientes</h2>
            <p class="section-subtitle mx-auto">Más de 50 clínicas dentales ya confían en Sonrisoft para administrar su día a día.</p>
        </div>

        <div class="row g-4">
            <!-- Testimonio 1 -->
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">
                        "Antes perdía horas buscando fichas en papel. Con Sonrisoft encuentro el historial de cualquier paciente en segundos. La agenda me eliminó los doble-turnos y mis pacientes notan la diferencia desde el primer día."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar av-blue">RM</div>
                        <div>
                            <div class="author-name">Dra. Rocío Mendoza</div>
                            <div class="author-role">Odontóloga General · Lima, Perú</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Testimonio 2 -->
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">
                        "Tengo 3 doctores y 2 sedes. Antes coordinar todo era un caos. Sonrisoft me da una vista completa de la agenda, el inventario y los ingresos de ambas clínicas desde mi celular. No puedo imaginar volver a trabajar sin él."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar av-green">CA</div>
                        <div>
                            <div class="author-name">Dr. Carlos Aquino</div>
                            <div class="author-role">Director Clínica Sonrisa Perfecta · Arequipa</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Testimonio 3 -->
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">
                        "El odontograma interactivo es increíble, mis pacientes entienden visualmente su tratamiento y eso genera más confianza. Los reportes financieros me ayudaron a darme cuenta de que estaba subcobrando varios procedimientos. ¡Un antes y después!"
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar av-purple">LV</div>
                        <div>
                            <div class="author-name">Dra. Luz Vargas</div>
                            <div class="author-role">Ortodoncista · Trujillo, Perú</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     CALL TO ACTION SECTION
===================================================================== --}}
<section class="cta-section text-center">
    <div class="container position-relative">
        <h2>¿Listo para transformar tu clínica dental?</h2>
        <p>Únete a más de 50 clínicas que ya eligieron Sonrisoft. Un pago, acceso de por vida.</p>
        <a href="#precios" class="btn btn-light btn-lg px-5 rounded-pill fw-bold shadow-sm me-3" style="color: var(--primary);">
            Ver Planes <i class="fas fa-arrow-right ms-2"></i>
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill fw-bold mt-2 mt-md-0">
            Iniciar Sesión
        </a>
    </div>
</section>

{{-- =====================================================================
     FAQ SECTION
===================================================================== --}}
<section class="faq-section" id="faq">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <div class="section-label">Preguntas Frecuentes</div>
                    <h2 class="section-title">Resolvemos tus dudas</h2>
                    <p class="section-subtitle mx-auto">Todo lo que necesitas saber antes de elegir tu plan.</p>
                </div>

                <div class="accordion faq-accordion" id="faqAccordion">

                    {{-- Pregunta 1 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq-head-1">
                            <button class="accordion-button" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq-body-1"
                                    aria-expanded="true"
                                    aria-controls="faq-body-1">
                                <i class="fas fa-infinity text-primary me-3"></i>
                                ¿Es de verdad un solo pago o cobran mensualidad?
                            </button>
                        </h2>
                        <div id="faq-body-1" class="accordion-collapse collapse show"
                             aria-labelledby="faq-head-1"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Es un modelo de <strong>pago único (Lifetime)</strong>. Compras tu plan una vez y el sistema es tuyo para siempre, sin cuotas mensuales ni cobros ocultos. Lo que ves en la página de precios es exactamente lo que pagas: una sola vez.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 2 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq-head-2">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq-body-2"
                                    aria-expanded="false"
                                    aria-controls="faq-body-2">
                                <i class="fas fa-shield-halved text-primary me-3"></i>
                                ¿Mis historias clínicas y datos de pacientes están seguros?
                            </button>
                        </h2>
                        <div id="faq-body-2" class="accordion-collapse collapse"
                             aria-labelledby="faq-head-2"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Totalmente. Sonrisoft funciona con <strong>encriptación de alto nivel</strong> y copias de seguridad automáticas. Tú eres el único dueño de tu información: no vendemos ni compartimos los datos de tus pacientes bajo ninguna circunstancia.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 3 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq-head-3">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq-body-3"
                                    aria-expanded="false"
                                    aria-controls="faq-body-3">
                                <i class="fas fa-headset text-primary me-3"></i>
                                ¿Qué pasa si necesito ayuda o no sé cómo usar algo?
                            </button>
                        </h2>
                        <div id="faq-body-3" class="accordion-collapse collapse"
                             aria-labelledby="faq-head-3"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Contamos con <strong>soporte técnico directo por WhatsApp</strong> para guiarte paso a paso en todo momento. Además, el sistema es súper intuitivo y cuenta con una guía de inicio rápido para que tú y tu equipo comiencen a usarlo desde el primer día sin complicaciones.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 4 --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq-head-4">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq-body-4"
                                    aria-expanded="false"
                                    aria-controls="faq-body-4">
                                <i class="fas fa-mobile-screen-button text-primary me-3"></i>
                                ¿Puedo usarlo desde mi celular o tablet?
                            </button>
                        </h2>
                        <div id="faq-body-4" class="accordion-collapse collapse"
                             aria-labelledby="faq-head-4"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                ¡Sí! Sonrisoft es <strong>100% responsivo</strong>. Puedes revisar tu agenda desde el celular mientras vas en camino a la clínica, consultar historiales desde una tablet en el sillón dental, o ver tus reportes financieros desde cualquier dispositivo con internet.
                            </div>
                        </div>
                    </div>

                </div>{{-- /accordion --}}

                <div class="text-center mt-5">
                    <p class="text-muted" style="font-size:.9rem;">¿Tienes otra pregunta? <a href="https://wa.me/51932149661?text=Hola,%20tengo%20una%20consulta%20sobre%20Sonrisoft" target="_blank" rel="noopener" class="text-primary fw-semibold"><i class="fab fa-whatsapp me-1"></i>Escríbenos por WhatsApp</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =====================================================================
     FOOTER
===================================================================== --}}
<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a class="footer-brand" href="#">
                    <i class="fas fa-tooth" style="color: var(--accent);"></i>
                    <span>Sonri<span style="color:white;">soft</span></span>
                </a>
                <p class="footer-desc">
                    La plataforma líder en gestión odontológica del Perú. Simplificamos tu práctica para que puedas enfocarte en lo que más importa: tus pacientes.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-muted fs-5 hover-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-muted fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-muted fs-5"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="text-muted fs-5"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2 offset-lg-1">
                <div class="footer-heading">Producto</div>
                <ul class="footer-links">
                    <li><a href="#caracteristicas">Características</a></li>
                    <li><a href="#precios">Precios</a></li>
                    <li><a href="#">Actualizaciones</a></li>
                    <li><a href="#">Seguridad</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <div class="footer-heading">Compañía</div>
                <ul class="footer-links">
                    <li><a href="#">Sobre Nosotros</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Soporte</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-3">
                <div class="footer-heading">Contáctanos</div>
                <ul class="footer-links">
                    <li><i class="fas fa-envelope me-2" style="color:#334155;"></i>soporte@sonrisoft.pe</li>
                    <li class="mt-1"><i class="fab fa-whatsapp me-2" style="color:#334155;"></i>+51 999 000 111</li>
                    <li class="mt-1"><i class="fas fa-map-marker-alt me-2" style="color:#334155;"></i>Lima, Perú</li>
                </ul>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row align-items-center">
            <div class="col-md-6 footer-copy">
                &copy; {{ date('Y') }} Sonrisoft. Todos los derechos reservados.
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <a href="#" class="footer-copy text-decoration-none me-3">Términos y Condiciones</a>
                <a href="#" class="footer-copy text-decoration-none">Política de Privacidad</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Scroll suave para anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const navbarHeight = document.getElementById('mainNav').offsetHeight;
                const topOffset = target.getBoundingClientRect().top + window.scrollY - navbarHeight - 16;
                window.scrollTo({ top: topOffset, behavior: 'smooth' });
            }
        });
    });

    // Navbar shadow on scroll
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('mainNav');
        nav.classList.toggle('scrolled', window.scrollY > 30);
    });
</script>

{{-- =====================================================================
     BOTÓN FLOTANTE DE WHATSAPP
===================================================================== --}}
<a href="https://wa.me/51932149661?text=Hola,%20estoy%20interesado%20en%20los%20planes%20del%20sistema%20Sonrisoft"
   class="btn-whatsapp-float"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Contactar por WhatsApp"
   title="¡Escríbenos por WhatsApp!">
    <i class="fab fa-whatsapp"></i>
    <span class="wa-label">¿Tienes dudas?</span>
</a>

</body>
</html>
