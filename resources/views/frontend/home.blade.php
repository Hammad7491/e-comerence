@extends('frontend.layouts.app')

@section('title', 'Home')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ===== THEME ===== */
        :root {
            --ink: #0f0f10;
            --muted: #6b7280;
            --rose: #c96a87; /* script headline */
            --gold: #8a6516; /* hero button */
            --card: #ffffff;
            --line: #ececec;

            /* WHAT'S NEW exact colors */
            --wn-title: #0f0f10;
            --wn-tab: #9b9b9b;
            --wn-tab-active: #6a0f2a;
            --wn-maroon: #5b112d; /* deep maroon circle */
            --wn-gold: #c9ab76;  /* thin outer ring */
            --hover-maroon: #7c1130;
        }

        /* Global type: switch all text to Manrope (hero h1 keeps Great Vibes) */
        html, body {
            font-family: "Manrope", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        .fx-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 18px
        }

        /* ===== HERO ===== */
        .hero {
            padding: clamp(48px, 10vw, 72px) 0 clamp(28px, 6vw, 46px);
            text-align: center;
        }

        .hero h1 {
            font-family: "Great Vibes", cursive; /* DO NOT CHANGE per request */
            font-size: clamp(42px, 8vw, 74px);
            line-height: 1.08;
            color: var(--rose);
            letter-spacing: .5px;
            text-shadow: 0 3px 0 rgba(0, 0, 0, .05);
            margin: 0 0 18px;
        }

        .hero p {
            font: 400 clamp(14px, 2.2vw, 18px)/1.8 "Manrope", system-ui;
            color: #4a5568;
            max-width: 760px;
            margin: 0 auto;
        }

        .hero .cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            background: var(--gold);
            color: #fff;
            letter-spacing: .12em;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 16px
        }

        .fade-hr {
            height: 1px;
            background: var(--line);
            margin: 30px 0
        }

        /* ===== WHAT'S NEW — HEADER ===== */
        .wn {
            padding: 8px 0 22px
        }

        .wn-head {
            display: flex;
            align-items: flex-start;
            gap: 80px
        }

        .wn-title {
            font: 800 clamp(34px, 6.4vw, 64px)/0.98 "Manrope", system-ui;
            color: var(--wn-title);
            letter-spacing: .02em;
            margin: 8px 0 6px;
            min-width: 280px;
            max-width: 320px;
        }

        .wn-circles {
            display: flex;
            gap: 56px;
            align-items: flex-start
        }

        .wn-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center;
            width: 160px
        }

        /* UPDATED: circle now shows an <img> inside (same pattern as header logo) */
        .wn-circle {
            position: relative;
            width: 140px;
            height: 140px;
            border-radius: 999px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 0 0 3px #eee, 0 0 0 5px var(--wn-gold);
        }
        .wn-circle img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* fills the circle nicely */
            display: block;
        }

        .wn-label {
            font: 800 10px/1.12 "Manrope";
            color: #601231;
            text-transform: uppercase
        }

        .wn-tabs {
            display: flex;
            gap: 26px;
            margin: 18px 0 16px
        }

        .wn-tab {
            font: 800 11px/1 "Manrope";
            text-transform: uppercase;
            color: var(--wn-tab);
            text-decoration: none
        }

        .wn-tab.is-active {
            color: var(--wn-tab-active)
        }

        /* ===== GRID ===== */
        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px
        }

        @media (max-width: 1024px) {
            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        /* UPDATED: 2 cards per row on mobile */
        @media (max-width: 640px) {
            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }
        }

        /* Mobile layout fixes for header block */
        @media (max-width: 900px) {
            .wn-head {flex-direction: column; gap: 24px; align-items: center;}
            .wn-title {min-width: 0; max-width: none; text-align: center;}
            .wn-circles {gap: 20px; justify-content: center; flex-wrap: wrap;}
            .wn-chip {width: 100px; gap: 8px}
            .wn-circle {width: 88px; height: 88px}
            .wn-label {font-size: 9px}
            .wn-tabs {justify-content: center}
        }

        /* ===== CARD (smaller) ===== */
        .card {
            position: relative;
            background: var(--card);
            border: 1px solid #efefef;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(17, 24, 39, .05);
            will-change: transform, box-shadow, border-color;
            transition: transform .28s cubic-bezier(.2, .65, .2, 1), box-shadow .28s ease, border-color .28s ease;
            /* visible by default; reveal only when JS adds .reveal to <body> */
        }
        .reveal .card { opacity: 0; transform: translateY(28px); }
        .reveal .card.show { opacity: 1; transform: translateY(0); }

        /* fancy hover: lift + glow + image tilt + sheen */
        .card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 40%, rgba(255, 255, 255, .18) 50%, transparent 60%);
            transform: translateX(-120%);
            transition: transform .7s ease;
            pointer-events: none;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(17, 24, 39, .15);
            border-color: rgba(124, 17, 48, .25);
        }

        .card:hover::after {
            transform: translateX(0);
        }

        .card .media {
            /* shorter like your reference */
            height: 170px;
            background: #fff;
            /* display: flex; */
            align-items: center;
            justify-content: center;
            padding:0 8px;
        }

        .card .media img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            display: block;
            transform: perspective(600px) translateZ(0) rotateZ(0);
            transition: transform .45s cubic-bezier(.2, .65, .2, 1);
            will-change: transform;
        }

        .card:hover .media img {
            transform: perspective(600px) translateZ(10px) scale(1.04) rotateZ(.2deg);
        }

        .card .body {
            padding: 10px 12px 12px
        }

        .card .title {
            font: 600 13px/1.2 "Manrope";
            color: #111827;
            margin: 2px 0 8px
        }

        .card .price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px
        }

        .card .price .now {
            color: #7c1130;
            font-weight: 800;
            font-size: 14px
        }

        .card .price .old {
            color: #9aa4b2;
            text-decoration: line-through;
            font-size: 12px
        }

        .card .meta {
            color: #6b7280;
            font: 600 11px/1 "Manrope"
        }

        /* make whole card clickable to product view */
        .card a.card-link{
            position:absolute; inset:0; z-index:10; text-indent:-9999px;
        }

        /* Tighter card layout when two-up on small screens */
        @media (max-width: 640px){
            .card .media{height: 130px; padding: 0 6px}
            .card .body{padding: 8px 8px 10px}
            .card .title{font-size: 12px}
            .card .price .now{font-size: 13px}
            .card .price .old{font-size: 11px}
            .card .meta{font-size: 10.5px}
        }
    </style>


<style>
  /* ===== THEME ===== */
  :root{
    --ink:#0f0f10;
    --muted:#6b7280;
    --rose:#c96a87;             /* script headline */
    --gold:#8a6516;             /* hero button */
    --card:#ffffff;
    --line:#ececec;

    /* WHAT'S NEW exact colors */
    --wn-title:#0f0f10;
    --wn-tab:#9b9b9b;
    --wn-tab-active:#6a0f2a;
    --wn-maroon:#5b112d;        /* deep maroon circle */
    --wn-gold:#c9ab76;          /* thin outer ring */
    --hover-maroon:#7c1130;
  }

  .fx-container{max-width:1200px;margin:0 auto;padding:0 18px}

  /* ===== HERO ===== */
  .hero{padding:clamp(48px,10vw,72px) 0 clamp(28px,6vw,46px); text-align:center}
  .hero h1{
    font-family:"Great Vibes", cursive; /* keep */
    font-size:clamp(42px,8vw,74px); line-height:1.08;
    color:var(--rose); letter-spacing:.5px;
    text-shadow:0 3px 0 rgba(0,0,0,.05);
    margin:0 0 18px;
  }
  .hero p{font:400 clamp(14px,2.2vw,18px)/1.8 "Manrope", system-ui; color:#4a5568; max-width:760px; margin:0 auto}
  .hero .cta{
    display:inline-flex; align-items:center; justify-content:center;
    padding:12px 24px; border-radius:4px; text-decoration:none;
    background:var(--gold); color:#fff; letter-spacing:.12em;
    font-weight:700; text-transform:uppercase; margin-top:16px
  }

  .fade-hr{height:1px;background:var(--line);margin:30px 0}

  /* ===== WHAT'S NEW — HEADER ===== */
  .wn{padding:8px 0 22px}
  .wn-head{display:flex; align-items:flex-start; gap:80px}
  .wn-title{
    font:800 clamp(34px,6.4vw,64px)/0.98 "Manrope", system-ui;
    color:var(--wn-title); letter-spacing:.02em;
    margin:8px 0 6px; min-width:280px; max-width:320px;
  }

  .wn-circles{display:flex; gap:56px; align-items:flex-start}
  .wn-chip{display:flex; flex-direction:column; align-items:center; gap:10px; text-align:center; width:160px}

  /* UPDATED: circle now uses <img> like the header logo */
  .wn-circle{
    position:relative;
    width:140px; height:140px; border-radius:999px; overflow:hidden;
    background:#fff;
    box-shadow:0 0 0 3px #eee, 0 0 0 5px var(--wn-gold);
  }
  .wn-circle img{
    position:absolute; inset:0; width:100%; height:100%;
    object-fit:cover; display:block;
  }

  .wn-label{font:800 10px/1.12 "Manrope"; color:#601231; text-transform:uppercase}

  .wn-tabs{display:flex; gap:26px; margin:18px 0 16px}
  .wn-tab{font:800 11px/1 "Manrope"; text-transform:uppercase; color:var(--wn-tab); text-decoration:none}
  .wn-tab.is-active{color:var(--wn-tab-active)}

  /* ===== GRID ===== */
  .grid{display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px}
  @media (max-width: 1024px){ .grid{grid-template-columns:repeat(2,minmax(0,1fr))} }
  /* UPDATED: 2 cards per row on mobile */
  @media (max-width: 640px){ .grid{grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px} }

  /* ===== CARD (smaller) ===== */
  .card{
    position:relative;
    background:var(--card);
    border:1px solid #efefef;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 8px 24px rgba(17,24,39,.05);
    will-change:transform, box-shadow, border-color;
    transition:transform .28s cubic-bezier(.2,.65,.2,1), box-shadow .28s ease, border-color .28s ease;
    /* visible by default; reveal only when JS adds .reveal to <body> */
  }
  .reveal .card{opacity:0; transform:translateY(28px)}
  .reveal .card.show{opacity:1; transform:translateY(0)}

  /* fancy hover: lift + glow + image tilt + sheen */
  .card::after{
    content:"";
    position:absolute; inset:0;
    background:linear-gradient(120deg, transparent 40%, rgba(255,255,255,.18) 50%, transparent 60%);
    transform:translateX(-120%);
    transition:transform .7s ease;
    pointer-events:none;
  }
  .card:hover{
    transform:translateY(-8px);
    box-shadow:0 18px 40px rgba(17,24,39,.15);
    border-color:rgba(124,17,48,.25);
  }
  .card:hover::after{ transform:translateX(0); }

  /* ===== PROFESSIONAL BLURRED BACKGROUND MEDIA ===== */
  .card .media{
    height:170px;
    position:relative;
    overflow:hidden;
    isolation:isolate;
  }
  
  /* Blurred background layer */
  .card .media::before{
    content:"";
    position:absolute;
    inset:-20%;
    background:var(--bg-img);
    background-size:cover;
    background-position:center;
    filter:blur(25px) brightness(0.4);
    transform:scale(1.2);
    z-index:1;
  }
  
  /* Dark gradient overlay for better contrast */
  .card .media::after{
    content:"";
    position:absolute;
    inset:0;
    background:radial-gradient(ellipse at center, transparent 30%, rgba(0,0,0,0.6) 100%);
    z-index:2;
  }
  
  /* Main image */
  .card .media img{
    position:relative;
    z-index:3;
    max-height:90%;
    max-width:90%;
    width:auto;
    height:auto;
    object-fit:contain;
    display:block;
    margin:0 auto;
    transform:perspective(600px) translateZ(0) rotateZ(0);
    transition:transform .45s cubic-bezier(.2,.65,.2,1);
    will-change:transform;
    filter:drop-shadow(0 4px 12px rgba(0,0,0,0.3));
    /* Center the image */
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
  }
  
  .card:hover .media img{
    transform:translate(-50%, -50%) perspective(600px) translateZ(10px) scale(1.04) rotateZ(.2deg);
  }

  .card .body{padding:10px 12px 12px}
  .card .title{font:600 13px/1.2 "Manrope"; color:#111827; margin:2px 0 8px}
  .card .price{display:flex; align-items:center; gap:8px; margin-bottom:4px}
  .card .price .now{color:#7c1130; font-weight:800; font-size:14px}
  .card .price .old{color:#9aa4b2; text-decoration:line-through; font-size:12px}
  .card .meta{color:#6b7280; font:600 11px/1 "Manrope"}

  /* Tighter small-screen card */
  @media (max-width:640px){
    .card .media{height:130px; padding:0 6px}
    .card .body{padding:8px 8px 10px}
    .card .title{font-size:12px}
    .card .price .now{font-size:13px}
    .card .price .old{font-size:11px}
    .card .meta{font-size:10.5px}
  }

  /* Header mobile refinements (mirror above block) */
  @media (max-width:900px){
    .wn-head{flex-direction:column; gap:24px; align-items:center}
    .wn-title{min-width:0; max-width:none; text-align:center}
    .wn-circles{gap:20px; justify-content:center; flex-wrap:wrap}
    .wn-chip{width:100px; gap:8px}
    .wn-circle{width:88px; height:88px}
    .wn-label{font-size:9px}
    .wn-tabs{justify-content:center}
  }
</style>
@endsection

@php
    use Illuminate\Support\Str;
@endphp

@section('content')

    {{-- ========== HERO ========== --}}
    <section class="hero fx-container">
        <h1>“Stitched by Hand,<br> Worn with Grace.”</h1>
        <p>
            Guley threads blends modern style with timeless hand embroidery. Each piece
            is handcrafted by skilled artisans, turning tradition into wearable art.
            Thoughtfully made, beautifully worn.
        </p>
        <a href="#" class="cta">Shop Women’s Collection</a>
    </section>

    <div class="fade-hr"></div>

    {{-- ========== WHAT’S NEW (dynamic) ========== --}}
    @php
        /** Pull dynamic items (title + image) */
        $whatNews = \App\Models\WhatNew::query()->latest()->get();
    @endphp
    <section class="fx-container wn">
        <div class="wn-head">
            <h2 class="wn-title">WHAT’S<br>NEW</h2>

            {{-- maroon circles with gold ring, each driven from DB --}}
            <div class="wn-circles">
                @foreach($whatNews as $item)
                    <div class="wn-chip">
                        <span class="wn-circle" aria-hidden="true">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}">

                        </span>
                        <span class="wn-label">{{ strtoupper($item->title) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- tabs row (Popular + New Arrivals only) --}}
        @php
            $popularUrl = request()->fullUrlWithQuery(['tab' => 'popular']);
            $newUrl = request()->fullUrlWithQuery(['tab' => 'new']);
            $activeTab = $tab ?? 'popular'; // from controller
            $items = $activeTab === 'new' ? $newArrivals : $popularProducts;

            /**
             * Build a robust list of possible image URLs for each product.
             * We DO NOT check server-side "exists" so it also works on live hosting.
             * Browser will try candidates in order and fall back automatically via JS.
             */
            function product_image_candidates($product) {
                $raws = [];

                // 1) If model exposes helpers
                if (method_exists($product, 'firstImageUrl')) {
                    $raws[] = $product->firstImageUrl();
                }
                if (method_exists($product, 'getFirstMediaUrl')) {
                    // spatie medialibrary common collections
                    $raws[] = $product->getFirstMediaUrl();              // default
                    $raws[] = $product->getFirstMediaUrl('products');    // named
                    $raws[] = $product->getFirstMediaUrl('images');      // named
                }

                // 2) Common attributes
                foreach (['image_url','image','thumbnail','thumb','cover','feature_image'] as $key) {
                    if (!empty($product->{$key})) $raws[] = $product->{$key};
                }

                // 3) "images" as array or JSON string
                $imgs = $product->images ?? null;
                if (is_string($imgs)) {
                    $decoded = json_decode($imgs, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && count($decoded)) {
                        $raws[] = $decoded[0];
                    } elseif (Str::contains($imgs, ',')) {
                        $parts = array_map('trim', explode(',', $imgs));
                        if (!empty($parts[0])) $raws[] = $parts[0];
                    } else {
                        $raws[] = $imgs;
                    }
                } elseif (is_array($imgs) && count($imgs)) {
                    $raws[] = $imgs[0];
                }

                // 4) Normalize each raw to absolute browser-loadable URLs.
                $urls = [];
                foreach ($raws as $raw) {
                    if (!$raw) continue;

                    if (Str::startsWith($raw, ['http://','https://','//'])) {
                        $urls[] = $raw;
                        continue;
                    }

                    // clean relative
                    $rel = ltrim($raw, '/');

                    // if someone already saved 'storage/products/...'
                    if (Str::startsWith($rel, 'storage/')) {
                        $urls[] = asset($rel);
                    } else {
                        // Prefer storage symlink location then direct public path
                        $rel = Str::startsWith($rel, 'products/') ? $rel : ('products/' . $rel);
                        $urls[] = asset('storage/' . $rel); // /storage/products/...
                        $urls[] = asset($rel);              // /products/...
                    }
                }

                // 5) Unique & filtered
                $urls = array_values(array_unique(array_filter($urls)));

                // 6) Always keep a placeholder as last resort
                $urls[] = 'https://via.placeholder.com/900x650/ffffff/aaaaaa?text=No+Image';

                return $urls;
            }
        @endphp
        <nav class="wn-tabs">
            <a class="wn-tab {{ $activeTab === 'popular' ? 'is-active' : '' }}" href="{{ $popularUrl }}">Popular</a>
            <a class="wn-tab {{ $activeTab === 'new' ? 'is-active' : '' }}" href="{{ $newUrl }}">New Arrivals</a>
        </nav>

        {{-- product grid (switches by tab) --}}
        <div class="grid">
            @forelse($items as $p)
                @php
                    $cands = product_image_candidates($p);
                    $src0 = $cands[0] ?? 'https://via.placeholder.com/900x650/ffffff/aaaaaa?text=No+Image';
                    $bg0  = $src0;
                    $srcListAttr = e(implode('|', $cands));
                @endphp

                <article class="card" style="--d: {{ $loop->index * 70 }}ms">
                    {{-- CLICKABLE OVERLAY LINK TO PRODUCT VIEW --}}
                    <a href="{{ route('product.show', $p) }}" class="card-link" aria-label="{{ $p->name }}">View</a>

                    <div class="media" style="--bg-img: url('{{ $bg0 }}')">
                        <img
                            src="{{ $src0 }}"
                            alt="{{ $p->name }}"
                            data-srcs="{{ $srcListAttr }}"
                            data-idx="0"
                            onerror="window.__imgfb && window.__imgfb(this);"
                        >
                    </div>

                    <div class="body">
                        <div class="title">{{ $p->name }}</div>
                        <div class="price">
                            <span class="now">PKR {{ number_format($p->final_price, 0) }}</span>
                            @if (!is_null($p->original_price) && $p->original_price > $p->final_price)
                                <span class="old">PKR {{ number_format($p->original_price, 0) }}</span>
                            @endif
                        </div>
                        @if (!is_null($p->pieces))
                            <div class="meta">{{ (int) $p->pieces }} {{ \Illuminate\Support\Str::plural('Piece', (int) $p->pieces) }}</div>
                        @endif
                    </div>
                </article>
            @empty
                <p style="grid-column:1/-1;color:#6b7280">
                    {{ $activeTab === 'new' ? 'No new arrivals in the last 30 days.' : 'No products.' }}
                </p>
            @endforelse
        </div>
    </section>

    <style>
        /* Card media wrapper */
.card .media{
  position: relative;
  height: 170px;
  overflow: hidden;
  /* display: flex; align-items: center; justify-content: center; */
}

/* Blurred background (fills the black areas) */
.card .media::before{
  content:"";
  position:absolute; inset:0;
  background: var(--bg-img, #000) center/cover no-repeat;
  filter: blur(20px) brightness(.6);
  transform: scale(1.2);
  z-index:0;
}

/* Foreground product image */
.card .media img{
  position: relative;
  z-index:1;
  max-height:100%;
  max-width:100%;
  object-fit: contain;
  display:block;
  margin: 0 !important;
}

/* Reduce media height on phones to help two-up grid */
@media (max-width:640px){
  .card .media{height:130px}
}
    </style>

@endsection

@section('scripts')
    <script>
        // Ensure reveal class is present so CSS animation only applies when JS runs.
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('reveal');
        });
    </script>

    <script>
        // Scroll reveal: fade + lift with stagger (uses inline --d)
        (function() {
            const cards = document.querySelectorAll('.card');
            if (!('IntersectionObserver' in window)) {
                // If no IO support, just show all
                cards.forEach(c => c.classList.add('show'));
                return;
            }
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const delay = parseInt(getComputedStyle(el).getPropertyValue('--d')) || 0;
                        setTimeout(() => el.classList.add('show'), delay);
                        io.unobserve(el);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -8% 0px'
            });
            cards.forEach(c => io.observe(c));
        })();
    </script>

    <script>
  // Fallback loader for product images: tries each candidate URL until one works.
  window.__imgfb = function(img){
    try{
      const list = (img.dataset.srcs || '').split('|').filter(Boolean);
      let i = parseInt(img.dataset.idx || '0', 10);
      if (i + 1 < list.length){
        i = i + 1;
        img.dataset.idx = String(i);
        const next = list[i];
        img.src = next;
        img.closest('.media')?.style.setProperty('--bg-img', `url("${next}")`);
      }else{
        img.onerror = null;
        const phFg = 'https://via.placeholder.com/900x650/ffffff/aaaaaa?text=No+Image';
        const phBg = 'https://via.placeholder.com/900x650/000000/666?text=No+Image';
        img.src = phFg;
        img.closest('.media')?.style.setProperty('--bg-img', `url("${phBg}")`);
      }
    }catch(e){
      img.onerror = null;
    }
  };

  // Mirror each <img> src into its parent as a CSS var used above (also after fallback)
  document.querySelectorAll('.card .media').forEach(m => {
    const img = m.querySelector('img');
    const syncBg = () => { if (img && img.src) m.style.setProperty('--bg-img', `url("${img.src}")`); };
    syncBg();
    img?.addEventListener('load', syncBg, { passive: true });
  });
</script>

@endsection
