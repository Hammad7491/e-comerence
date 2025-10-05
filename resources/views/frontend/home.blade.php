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
            padding: 72px 0 46px
        }

        .hero h1 {
            font-family: "Great Vibes", cursive; /* DO NOT CHANGE per request */
            font-size: 74px;
            line-height: 1.05;
            color: var(--rose);
            letter-spacing: .5px;
            text-shadow: 0 3px 0 rgba(0, 0, 0, .05);
            margin: 0 0 26px;
        }

        .hero p {
            font: 400 18px/1.8 "Manrope", system-ui;
            color: #4a5568;
            max-width: 760px
        }

        .hero .cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 28px;
            border-radius: 4px;
            text-decoration: none;
            background: var(--gold);
            color: #fff;
            letter-spacing: .12em;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 18px
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
            font: 800 64px/0.98 "Manrope", system-ui;
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

        .wn-circle {
            width: 140px;
            height: 140px;
            border-radius: 999px;
            background: radial-gradient(circle at 50% 50%, #651536 0%, var(--wn-maroon) 55%, #4a0d22 100%);
            box-shadow: 0 0 0 3px #eee, 0 0 0 5px var(--wn-gold);
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

        @media (max-width: 640px) {
            .grid {
                grid-template-columns: 1fr
            }
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
            /* scroll-reveal base */
            opacity: 0;
            transform: translateY(28px);
        }

        .card.show {
            opacity: 1;
            transform: translateY(0)
        }

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
  .hero{padding:72px 0 46px}
  .hero h1{
    font-family:"Great Vibes", cursive; /* keep */
    font-size:74px; line-height:1.05;
    color:var(--rose); letter-spacing:.5px;
    text-shadow:0 3px 0 rgba(0,0,0,.05);
    margin:0 0 26px;
  }
  .hero p{font:400 18px/1.8 "Manrope", system-ui; color:#4a5568; max-width:760px}
  .hero .cta{
    display:inline-flex; align-items:center; justify-content:center;
    padding:14px 28px; border-radius:4px; text-decoration:none;
    background:var(--gold); color:#fff; letter-spacing:.12em;
    font-weight:700; text-transform:uppercase; margin-top:18px
  }

  .fade-hr{height:1px;background:var(--line);margin:30px 0}

  /* ===== WHAT'S NEW — HEADER ===== */
  .wn{padding:8px 0 22px}
  .wn-head{display:flex; align-items:flex-start; gap:80px}
  .wn-title{
    font:800 64px/0.98 "Manrope", system-ui;
    color:var(--wn-title); letter-spacing:.02em;
    margin:8px 0 6px; min-width:280px; max-width:320px;
  }

  .wn-circles{display:flex; gap:56px; align-items:flex-start}
  .wn-chip{display:flex; flex-direction:column; align-items:center; gap:10px; text-align:center; width:160px}
  .wn-circle{
    width:140px; height:140px; border-radius:999px;
    background:radial-gradient(circle at 50% 50%, #651536 0%, var(--wn-maroon) 55%, #4a0d22 100%);
    box-shadow:0 0 0 3px #eee, 0 0 0 5px var(--wn-gold);
  }
  .wn-label{font:800 10px/1.12 "Manrope"; color:#601231; text-transform:uppercase}

  .wn-tabs{display:flex; gap:26px; margin:18px 0 16px}
  .wn-tab{font:800 11px/1 "Manrope"; text-transform:uppercase; color:var(--wn-tab); text-decoration:none}
  .wn-tab.is-active{color:var(--wn-tab-active)}

  /* ===== GRID ===== */
  .grid{display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px}
  @media (max-width: 1024px){ .grid{grid-template-columns:repeat(2,minmax(0,1fr))} }
  @media (max-width: 640px){ .grid{grid-template-columns:1fr} }

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
    /* scroll-reveal base */
    opacity:0; transform:translateY(28px);
  }
  .card.show{opacity:1; transform:translateY(0)}

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
</style>
@endsection

@php use Illuminate\Support\Str; @endphp

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

    {{-- ========== WHAT’S NEW (exact) ========== --}}
    <section class="fx-container wn">
        <div class="wn-head">
            <h2 class="wn-title">WHAT’S<br>NEW</h2>

            {{-- maroon circles with gold ring --}}
            <div class="wn-circles">
                <div class="wn-chip">
                    <span class="wn-circle" aria-hidden="true"></span>
                    <span class="wn-label">HAND EMBROIDERY<br>UNSTITCHED</span>
                </div>
                <div class="wn-chip">
                    <span class="wn-circle" aria-hidden="true"></span>
                    <span class="wn-label">READY TO<br>WEAR</span>
                </div>
                <div class="wn-chip">
                    <span class="wn-circle" aria-hidden="true"></span>
                    <span class="wn-label">EMBROIDED<br>2 PIECE SUITS</span>
                </div>
            </div>
        </div>

        {{-- tabs row (Popular + New Arrivals only) --}}
        @php
            $popularUrl = request()->fullUrlWithQuery(['tab' => 'popular']);
            $newUrl = request()->fullUrlWithQuery(['tab' => 'new']);
            $activeTab = $tab ?? 'popular'; // from controller
            $items = $activeTab === 'new' ? $newArrivals : $popularProducts;
        @endphp
        <nav class="wn-tabs">
            <a class="wn-tab {{ $activeTab === 'popular' ? 'is-active' : '' }}" href="{{ $popularUrl }}">Popular</a>
            <a class="wn-tab {{ $activeTab === 'new' ? 'is-active' : '' }}" href="{{ $newUrl }}">New Arrivals</a>
        </nav>

        {{-- product grid (switches by tab) --}}
        <div class="grid">
            @forelse($items as $p)
                <article class="card" style="--d: {{ $loop->index * 70 }}ms">
                    {{-- CLICKABLE OVERLAY LINK TO PRODUCT VIEW --}}
                    <a href="{{ route('product.show', $p) }}" class="card-link" aria-label="{{ $p->name }}">View</a>

                    @php $img = $p->firstImageUrl(); @endphp
                    @if ($img)
<div class="media" style="--bg-img: url('{{ $img }}')">

                            <img src="{{ $img }}" alt="{{ $p->name }}">
                        </div>
                    @else
                        <div class="media" style="--bg-img: url('https://via.placeholder.com/400x300/000000/666?text=No+Image')">

                            <img src="https://via.placeholder.com/400x300/ffffff/aaaaaa?text=No+Image" alt="no image">

                        </div>
                    @endif
                    <div class="body">
                        <div class="title">{{ $p->name }}</div>
                        <div class="price">
                            <span class="now">PKR {{ number_format($p->final_price, 0) }}</span>
                            @if (!is_null($p->original_price) && $p->original_price > $p->final_price)
                                <span class="old">PKR {{ number_format($p->original_price, 0) }}</span>
                            @endif
                        </div>
                        @if (!is_null($p->pieces))
                            <div class="meta">{{ (int) $p->pieces }} {{ Str::plural('Piece', (int) $p->pieces) }}</div>
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

    </style>

@endsection

@section('scripts')
    <script>
        // Scroll reveal: fade + lift with stagger (uses inline --d)
        (function() {
            const cards = document.querySelectorAll('.card');
            if (!('IntersectionObserver' in window)) {
                cards.forEach(c => c.classList.add('show'));
                return;
            }
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        // optional stagger from inline style var(--d)
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
  // Mirror each <img> src into its parent as a CSS var used above
  document.querySelectorAll('.card .media').forEach(m => {
    const img = m.querySelector('img');
    if (img && img.src) m.style.setProperty('--bg-img', `url("${img.src}")`);
  });
</script>

@endsection
