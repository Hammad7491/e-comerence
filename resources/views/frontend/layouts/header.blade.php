<!-- ======================= HEADER ======================= -->
<header class="site-header">
  <!-- Topbar -->
  <div class="topbar">
    <div class="container">
      <div class="topbar-left">Currency : PKR</div>
      <div class="topbar-right">
        <a href="/register">Register</a>
        <span class="sep">|</span>
        <a href="/login">Sign In</a>

        <div class="cart-pill" aria-label="Cart">
          <span class="cart-icon">🛒</span>
          <span>empty</span>
          <span class="caret"></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Main header -->
  <div class="main-header">
    <div class="container">
      <div class="brand">
        <a class="logo" href="/">
          <img src="/assets/images/logo.png" alt="Guley Threads" />
        </a>
        <a class="brand-text" href="/">
          <span>Guley</span>
          <span>Threads</span>
        </a>
      </div>

      <!-- Mobile toggle -->
      <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>

      <nav class="nav" aria-label="Primary">
        <ul>
          <li><a href="/brand">THE BRAND</a></li>
          <li><a href="/women">WOMEN</a></li>
          <li><a href="/contact">CONTACT US</a></li>
        </ul>
      </nav>

      <form class="search" action="/search" method="GET">
        <input type="search" name="q" placeholder="Search..." />
      </form>
    </div>
  </div>
</header>
<!-- ==================== /HEADER END ===================== -->

<style>
/* ---- Base ---- */
:root{
  --gray-900:#2f3133;           /* topbar background (dark) */
  --gray-700:#444;              /* borders / lines subtle */
  --txt:#7b7b7b;                /* muted text */
  --ink:#111;                   /* main text */
  --brand-pill:#6b1030;         /* cart maroon pill */
  --container:1220px;
}
.site-header{font-family:system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;}
.container{max-width:var(--container);margin:0 auto;padding:0 16px;}

/* ---- Topbar ---- */
.topbar{background:var(--gray-900); color:#cfcfcf; font-size:12px;}
.topbar .container{display:flex; align-items:center; justify-content:space-between; height:28px;}
.topbar a{color:#e2e2e2; text-decoration:none;}
.topbar a:hover{color:#fff;}
.topbar .sep{opacity:.6; margin:0 8px;}
.topbar-left{letter-spacing:.2px;}
.topbar-right{display:flex; align-items:center; gap:8px;}

/* cart pill (maroon) */
.cart-pill{
  display:inline-flex; align-items:center; gap:6px;
  background:var(--brand-pill); color:#fff; padding:6px 10px;
  border-top-left-radius:4px; border-top-right-radius:4px;
  position:relative; margin-left:8px;
}
.cart-pill .cart-icon{line-height:1; transform:translateY(-.5px);}
.cart-pill .caret{
  margin-left:4px; width:0;height:0; border-left:4px solid transparent;
  border-right:4px solid transparent; border-top:5px solid #e6e6e6; opacity:.9;
}

/* ---- Main header ---- */
.main-header{background:#f6f6f6;}
.main-header .container{
  display:grid; grid-template-columns:auto 1fr auto; align-items:center;
  gap:24px; padding:18px 16px;
}

/* brand (logo + stacked name) */
.brand{display:flex; align-items:center; gap:16px;}
.brand .logo img{width:56px; height:56px; object-fit:cover; border-radius:6px; display:block;}
.brand-text{display:flex; flex-direction:column; text-decoration:none; line-height:1.05;}
.brand-text span{font-weight:800; color:#b0b0b0; font-size:28px; letter-spacing:.02em;}
.brand-text span + span{margin-top:2px;}

/* nav */
.nav ul{display:flex; gap:36px; list-style:none; margin:0; padding:0; justify-content:center;}
.nav a{color:var(--ink); text-decoration:none; font-weight:600; font-size:12.5px; letter-spacing:.12em;}
.nav a:hover{opacity:.7;}

/* search */
.search input{
  width:190px; height:26px; border:1px solid #e5e5e5; border-radius:3px;
  padding:0 8px; font-size:12px; color:#333; background:#fff;
}

/* mobile toggle (hidden desktop) */
.nav-toggle{display:none; background:none; border:0; padding:6px; margin-left:auto; cursor:pointer}
.nav-toggle span{display:block; width:22px; height:2px; background:#222; margin:4px 0;}

/* ---- Responsive ---- */
@media (max-width:1024px){
  .main-header .container{grid-template-columns:auto auto auto; gap:16px;}
  .nav ul{gap:22px;}
}

@media (max-width:860px){
  .brand .logo img{width:48px;height:48px}
  .brand-text span{font-size:24px}
  .search input{width:160px}
}

@media (max-width:720px){
  /* stack header: brand + toggle row, then nav + search row */
  .main-header .container{grid-template-columns:1fr auto; grid-template-areas:
    "brand toggle"
    "nav   nav"
    "search search"; row-gap:10px;}
  .brand{grid-area:brand}
  .nav-toggle{display:block; grid-area:toggle}
  .nav{grid-area:nav}
  .search{grid-area:search}
  .nav ul{flex-direction:column; gap:10px; border-top:1px solid #e7e7e7; padding-top:10px; display:none;}
  .nav.open ul{display:flex;}
  .search{display:flex; justify-content:flex-end}
  .search input{width:100%}
}

@media (max-width:400px){
  .brand-text span{font-size:20px}
  .topbar .container{padding-inline:10px}
}
</style>

<script>
/* minimal mobile menu toggle */
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.nav');
  if (!btn || !nav) return;
  btn.addEventListener('click', function(){
    const open = nav.classList.toggle('open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
});
</script>
