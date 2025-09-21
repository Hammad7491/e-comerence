@extends('frontend.layouts.app')
@section('title','The Brand')

@section('styles')
<style>
  :root{
    --ink:#0f0f10; --muted:#6b7280; --maroon:#6B1030;
  }
  .fx{max-width:1200px;margin:0 auto;padding:0 18px}

  /* ===== HERO (as in reference) ===== */
  .brand-hero{
    position:relative; min-height:360px; color:#fff; overflow:hidden;
    display:flex; align-items:center; justify-content:center; text-align:center;
  }
  .brand-hero::before{
    content:""; position:absolute; inset:0;
    background:url("/assets/images/brand/hero.jpg") center/cover no-repeat;
    filter:brightness(.55);
  }
  .brand-hero .ghost{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    font:900 clamp(64px,16vw,220px)/.9 "Inter",system-ui;
    letter-spacing:.06em; color:#ffffff10; pointer-events:none;
  }
  .brand-hero .inner{position:relative; z-index:2; padding:40px 18px}
  .brand-eyebrow{
    font:900 clamp(16px,2.6vw,22px)/1 "Inter"; letter-spacing:.25em; color:#fff; text-transform:uppercase;
  }
  .brand-quote{
    margin-top:8px; color:#e7e9ee;
    font:700 clamp(11px,1.8vw,13px)/1.2 "Inter"; letter-spacing:.22em;
  }

  /* ===== CONTENT ===== */
  .brand-wrap{background:#fff; padding:44px 0 60px}

  /* row 1: image left / text right  — row 2: two tiles with image then text */
  .grid-2{display:grid; grid-template-columns:1fr 1fr; gap:36px}
  .tile-img img{display:block; width:100%; height:auto; border-radius:4px}
  .tile-text{padding-top:6px}
  .eyebrow{
    font:800 11px/1 "Inter"; letter-spacing:.18em; text-transform:uppercase; color:#6b7280; margin-bottom:6px
  }
  .h2{font:900 clamp(18px,2.2vw,28px)/1.15 "Inter"; color:#0f172a; margin:0 0 8px}
  .copy{font:600 14px/1.55 "Inter"; color:#374151}

  /* circular palette image (right tile) */
  .circle img{border-radius:999px}

  /* spacing & subtle divider look like reference */
  .section-gap{margin-top:34px}
  .thin-rule{height:1px;background:#f2f2f2;margin:20px 0}

  /* ===== Responsive ===== */
  @media (max-width:980px){
    .grid-2{grid-template-columns:1fr; gap:26px}
  }
</style>
@endsection

@section('content')
  <!-- HERO -->
  <header class="brand-hero">
    <div class="ghost">GULEY THREADS</div>
    <div class="inner fx">
      <div class="brand-eyebrow">THE BRAND</div>
      <div class="brand-quote">“ FROM NEEDLE TO NEED — MADE FOR YOU ”</div>
    </div>
  </header>

  <!-- BODY -->
  <section class="brand-wrap">
    <div class="fx">

      <!-- Row 1: Image (left) + Our Story (right) -->
      <div class="grid-2">
        <figure class="tile-img">
          <img src="/assets/images/brand/needle-embroidery.jpg" alt="Hand embroidery close-up">
        </figure>

        <div class="tile-text">
          <div class="eyebrow">OUR STORY</div>
          <h2 class="h2">A craft that weaves culture with care</h2>
          <p class="copy">
            At Guley Threads, every stitch tells a story — from traditional handwork to modern silhouettes
            crafted for everyday life. What began as a small atelier has grown into a studio driven by
            community, craft, and character. We design pieces you’ll reach for again and again, blending
            soft fabrics, lasting construction, and quiet detail that feels both familiar and new.
          </p>
          <p class="copy" style="margin-top:10px">
            We partner with skilled artisans and small workshops, honoring time-tested techniques while
            embracing thoughtful innovations that reduce waste.
          </p>
        </div>
      </div>

      <!-- Row 2: two tiles -->
      <div class="section-gap grid-2">
        <!-- Left tile -->
        <div>
          <figure class="tile-img">
            <img src="/assets/images/brand/handwork-border.jpg" alt="Handcrafted floral border">
          </figure>
          <div class="tile-text">
            <div class="eyebrow">OUR VALUES, VISION & STRATEGY</div>
            <h2 class="h2">Designed to be worn, loved, and kept</h2>
            <p class="copy">
              Our vision is conscious fashion with purpose: pieces that respect your wardrobe, your wallet,
              and the world. We prioritize durable materials, versatile fits, and timeless palettes so your
              clothes move with you — season after season. Our strategy is simple: make fewer, better things
              and support the hands that make them.
            </p>
          </div>
        </div>

        <!-- Right tile -->
        <div>
          <figure class="tile-img circle">
            <img src="/assets/images/brand/palette-wheel.jpg" alt="Color palette wheel">
          </figure>
          <div class="tile-text">
            <div class="eyebrow">ETHICAL TRADING</div>
            <h2 class="h2">People first, always</h2>
            <p class="copy">
              We’re committed to fair work and fair wages across our supply chain: transparent relationships,
              safe workplaces, and continuous learning for our teams. We buy responsibly, plan mindfully, and
              reduce excess through small-batch production — keeping quality high and waste low.
            </p>
          </div>
        </div>
      </div>

    </div>
  </section>
@endsection
