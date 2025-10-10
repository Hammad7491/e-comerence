@extends('frontend.layouts.app')
@section('title','The Brand')

@section('styles')
<!-- Use Manrope everywhere on this page (same as previous change) -->
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Global typography */
  html, body{
    font-family:"Manrope", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
    color:#0f0f10;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    text-rendering:optimizeLegibility;
  }

  :root{
    --ink:#0f0f10;
    --muted:#656b74;
    --ring:#e9e7e2;
  }
  .fx{max-width:1180px;margin:0 auto;padding:0 18px}

  /* ===== HERO (same as cart) ===== */
  .brand-hero{
    background:#2a2a2c;
    color:#fff;
    min-height:200px;
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    overflow:hidden;
    text-align:center;
  }
  .brand-hero .eyebrow{
    font:800 35px/1.1 "Manrope",system-ui;
    letter-spacing:.18em;
    text-transform:uppercase;
  }
  .brand-hero .ghost{
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    font:900 clamp(100px,16vw,200px)/.9 "Manrope";
    color:#ffffff12;
    letter-spacing:.08em;
    pointer-events:none;
  }

  /* ===== BODY ===== */
  .wrap{background:#fff}
  .block{padding:44px 0 16px}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:40px}

  .img-frame{
    border:1px solid var(--ring);
    padding:10px;
    border-radius:2px;
    background:#fff;
  }
  .img-frame img{display:block;width:100%;height:auto}

  .h-eyebrow{
    font:800 20px/1 "Manrope";
    letter-spacing:.18em;
    text-transform:uppercase;
    color:#7a808a;
    margin:10px 0;
  }
  .story p,
  .values p,
  .ethics p{
    font:600 14px/1.65 "Manrope";
    color:#2e3136;
    margin:.45rem 0;
  }

  .ethics h4{
    text-align:center;
    margin:0 0 10px;
    font:800 12px/1 "Manrope";
    letter-spacing:.18em;
    color:#79808a;
    text-transform:uppercase;
  }
  .ethics .tight{line-height:1.35;text-align:center}

  .circle{border-radius:999px;overflow:hidden;border:1px solid var(--ring)}
  .mt24{margin-top:24px}

  /* ===== Responsive ===== */
  @media (max-width: 980px){
    .grid-2{grid-template-columns:1fr;gap:26px}
    .ethics h4{margin-top:16px}
  }
</style>
@endsection

@section('content')
  <!-- HERO -->
  <header class="brand-hero">
    <div class="eyebrow">THE BRAND</div>
    <div class="ghost">GULEY THREADS</div>
  </header>

  <!-- BODY -->
  <section class="wrap">
    <div class="fx block">
      <!-- Row 1: left image, right story -->
      <div class="grid-2">
        <figure class="img-frame">
          <img src="/assets/images/brand/needle-embroidery.jpg" alt="Hand embroidery close-up">
        </figure>

        <div class="story">
          <div class="h-eyebrow">OUR STORY</div>
          <p>at guley threads, every stitch tells a story.</p>
          <p>founded in 2025, our brand was born out of a deep love for traditional hand embroidery and timeless craftsmanship. what started as a small home studio with a passion for preserving age-old techniques has now grown into a clothing label that celebrates slow fashion, cultural heritage, and meaningful design.</p>
          <p>we work closely with skilled artisans who pour generations of knowledge and artistry into every garment. each piece is carefully hand-embroidered, making it not just clothing, but wearable art: crafted with patience, precision, and pride.</p>
        </div>
      </div>

      <!-- Row 2: left values (image + copy), right ethics (circle image + centered text) -->
      <div class="grid-2 mt24">
        <div>
          <figure class="img-frame">
            <img src="/assets/images/brand/handwork-border.jpg" alt="Handcrafted floral border">
          </figure>
          <div class="values mt24">
            
            <p>we believe in the beauty of craftsmanship, the importance of fair treatment for artisans, and the need for sustainable, mindful fashion. each piece we create reflects our respect for cultural heritage and individuality, made with care and intention. our vision is to bring handcrafted, meaningful clothing to people who value quality and ethics, while supporting the communities behind the art. we do this by working directly with skilled artisans, designing timeless styles, producing responsibly, and building connections with conscious customers around the world.</p>
          </div>
        </div>

        <div>
          <figure class="img-frame circle">
            <img src="/assets/images/brand/palette-wheel.jpg" alt="Color palette wheel">
          </figure>
          <div class="ethics mt24">
            <h4>ETHICAL TRADING</h4>
            <p class="tight">we are committed to ethical trading and fair business practices. we believe fashion<br>
              should empower— not exploit.</p>
            <p class="tight">we work directly with skilled artisans and embroidery communities, ensuring that:<br>
              all workers are treated with dignity and respect  -<br>
              fair wages are paid  -<br>
              safe and healthy working conditions are provided  -<br>
              no child labor or forced labor is used  -<br>
              traditional skills are valued, preserved, and passed down  -</p>
            <p class="tight">we source our materials responsibly and strive to minimize waste, working toward a more sustainable and transparent supply chain. by choosing us, you’re supporting a business that values people, craft, and conscious fashion.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
