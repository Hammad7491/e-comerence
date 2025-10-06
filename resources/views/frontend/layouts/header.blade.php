<!-- ======================= HEADER ======================= -->
<header class="site-header">
  <!-- Topbar -->
  <div class="topbar">
    <div class="container">
      <div class="topbar-left">Currency : PKR</div>

      <div class="topbar-right">
        @guest
          <a href="{{ route('registerform') }}">Register</a>
          <span class="sep">|</span>
          <a href="{{ route('loginform') }}">Sign In</a>
        @else
          <!-- User dropdown (name only, no “Welcome”) -->
          <div class="user-menu">
            <button class="user-btn" type="button" aria-haspopup="menu" aria-expanded="false" id="userMenuButton">
              <span class="user-name">{{ Auth::user()->name }}</span>
              <svg class="chev" width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">
                <path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>

            <div class="user-dropdown" role="menu" aria-labelledby="userMenuButton">
              <a role="menuitem" href="{{ route('password.change') }}">Change Password</a>
              <a role="menuitem" href="{{ route('orders.mine') }}">My Orders</a>
              <a role="menuitem" href="{{ route('cart.index') }}">My Cart</a>
              <form role="menuitem" action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit">Log Out</button>
              </form>
            </div>
          </div>
        @endguest

        @php
          $cartKey   = auth()->check() ? 'cart_user_'.auth()->id() : 'cart_guest';
          $cartItems = collect(session($cartKey.'.items', []));
          $cartQty   = (int) $cartItems->sum('qty');
        @endphp

        <a href="{{ route('cart.index') }}" class="cart-pill" aria-label="Cart">
          <span class="cart-icon">🛒</span>
          @if($cartQty > 0)
            <span>{{ $cartQty }} item{{ $cartQty > 1 ? 's' : '' }}</span>
          @else
            <span>empty</span>
          @endif
          <span class="caret"></span>
        </a>
      </div>
    </div>
  </div>

  <!-- Main header -->
  <div class="main-header">
    <div class="container">
      <div class="brand">
        <a class="logo" href="{{ route('home') }}">
          <img src="{{ asset('assets/images/guley.jpg') }}" alt="Guley Threads" />
        </a>
        <a class="brand-text" href="{{ route('home') }}">
          <span>Guley</span>
          <span>Threads</span>
        </a>
      </div>

      <!-- Mobile toggle -->
      <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>

      <!-- Centered navigation row -->
      <nav class="nav" aria-label="Primary">
        <ul>
          <li><a href="{{ route('home') }}">HOME</a></li>
          <li><a href="{{ route('brand') }}">THE BRAND</a></li>
          <li><a href="{{ route('contact') }}">CONTACT US</a></li>
        </ul>
      </nav>

      <form class="search" action="/search" method="GET" role="search">
        <input type="search" name="q" placeholder="Search..." aria-label="Search"/>
      </form>
    </div>
  </div>
</header>
<!-- ==================== /HEADER END ===================== -->

<style>
/* ---- Base ---- */
:root{
  --gray-900:#2f3133;
  --gray-700:#444;
  --txt:#7b7b7b;
  --ink:#111;
  --brand-pill:#6b1030;
  --container:1220px;
  --drop-bg:#1f2937;
  --drop-ring:#334155;
  --drop-txt:#e5e7eb;
}
.site-header{font-family:system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,sans-serif;}
.container{
  max-width:var(--container);
  margin:0 auto;
  padding:0 clamp(12px,3.2vw,16px);
  padding-left:max(clamp(12px,3.2vw,16px), env(safe-area-inset-left));
  padding-right:max(clamp(12px,3.2vw,16px), env(safe-area-inset-right));
}

/* ---- Topbar ---- */
.topbar{background:var(--gray-900); color:#cfcfcf; font-size:12px;}
.topbar .container{display:flex; align-items:center; justify-content:space-between; min-height:28px; gap:8px;}
.topbar a{color:#e2e2e2; text-decoration:none;}
.topbar a:hover{color:#fff;}
.topbar .sep{opacity:.6; margin:0 6px;}
.topbar-left{letter-spacing:.2px;}
.topbar-right{display:flex; align-items:center; gap:8px; position:relative; flex-wrap:wrap}

/* User menu */
.user-menu{position:relative}
.user-btn{
  display:inline-flex;align-items:center;gap:6px;background:transparent;border:0;color:#fff;cursor:pointer;
  padding:4px 8px;font-weight:700;letter-spacing:.2px;border-radius:6px
}
.user-btn:hover{background:#ffffff14}
.user-name{max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.user-btn .chev{opacity:.85}

.user-dropdown{
  position:absolute;right:0;top:calc(100% + 6px);
  min-width:200px;background:var(--drop-bg);border:1px solid var(--drop-ring);
  box-shadow:0 12px 30px rgba(0,0,0,.35);border-radius:10px;padding:6px;
  display:none; z-index:1000;
}
.user-dropdown a,
.user-dropdown button{
  display:block;width:100%;text-align:left;color:var(--drop-txt);text-decoration:none;
  font-weight:700;font-size:12.5px;letter-spacing:.08em;padding:10px 10px;border-radius:8px;background:transparent;border:0;cursor:pointer
}
.user-dropdown a:hover,
.user-dropdown button:hover{background:#ffffff12}
.logout-form{margin:0}

/* cart pill (maroon) */
.cart-pill{
  display:inline-flex; align-items:center; gap:6px;
  background:var(--brand-pill); color:#fff; padding:6px 10px;
  border-top-left-radius:4px; border-top-right-radius:4px;
  position:relative; margin-left:8px; text-decoration:none; white-space:nowrap;
}
.cart-pill .cart-icon{line-height:1; transform:translateY(-.5px);}
.cart-pill .caret{
  margin-left:4px; width:0;height:0; border-left:4px solid transparent;
  border-right:4px solid transparent; border-top:5px solid #e6e6e6; opacity:.9;
}

/* ---- Main header ---- */
.main-header{background:#f6f6f6;}
.main-header .container{
  display:grid;
  grid-template-columns:auto 1fr auto; /* brand | nav | search */
  align-items:center;
  gap:24px;
  padding:14px clamp(12px,3.2vw,16px);
}

/* brand (logo + stacked name) */
.brand{display:flex; align-items:center; gap:12px; min-width:0;}
.brand .logo img{width:56px; height:56px; object-fit:cover; border-radius:6px; display:block;}
.brand-text{display:flex; flex-direction:column; text-decoration:none; line-height:1.05;}
.brand-text span{font-weight:800; color:#b0b0b0; font-size:26px; letter-spacing:.02em;}
.brand-text span + span{margin-top:1px;}

/* nav (centered) */
.nav{display:flex; justify-content:center;}
.nav ul{
  display:flex; align-items:center; justify-content:center;
  gap:32px; list-style:none; margin:0; padding:0;
}
.nav li{display:inline-flex}
.nav a{color:var(--ink); text-decoration:none; font-weight:700; font-size:12px; letter-spacing:.12em;}
.nav a:hover{opacity:.75;}

/* search */
.search{display:flex; justify-content:flex-end; min-width:0}
.search input{
  width:210px; height:28px; border:1px solid #e5e5e5; border-radius:4px;
  padding:0 8px; font-size:12px; color:#333; background:#fff;
}

/* mobile toggle (hidden desktop) */
.nav-toggle{display:none; background:none; border:0; padding:6px; margin-left:auto; cursor:pointer}
.nav-toggle span{display:block; width:22px; height:2px; background:#222; margin:4px 0; border-radius:1px}

/* ---- Responsive ---- */
@media (max-width:1100px){
  .nav ul{gap:24px;}
  .brand .logo img{width:52px;height:52px}
  .brand-text span{font-size:24px}
  .search input{width:190px}
}

@media (max-width:860px){
  .main-header .container{gap:16px}
  .brand .logo img{width:46px;height:46px}
  .brand-text span{font-size:22px}
  .search input{width:170px}
}

/* Mobile layout */
@media (max-width:720px){
  .main-header .container{
    grid-template-columns:1fr auto;
    grid-template-areas:
      "brand toggle"
      "nav   nav"
      "search search";
    row-gap:8px;
  }
  .brand{grid-area:brand}
  .nav-toggle{display:block; grid-area:toggle}
  .nav{grid-area:nav}
  .search{grid-area:search; justify-content:flex-start}

  /* collapse nav into a vertical drawer */
  .nav ul{
    flex-direction:column; gap:10px;
    border-top:1px solid #e7e7e7; padding-top:10px; display:none;
    align-items:flex-start;
  }
  .nav.open ul{display:flex;}

  /* brand text smaller & allow truncation */
  .brand-text span{font-size:20px}
  .brand-text{max-width:60vw; white-space:nowrap; overflow:hidden; text-overflow:ellipsis}

  /* MOBILE SEARCH = SMALL */
  .search input{
    width:140px;            /* <-- small on mobile per request */
    height:28px;
  }
}

/* Extra small phones */
@media (max-width:400px){
  .brand .logo img{width:42px;height:42px}
  .brand-text span{font-size:18px}
  .topbar .container{gap:6px}
  .topbar .sep{margin:0 4px}
  .nav a{font-size:11px}
  .search input{width:130px}
}
</style>

<script>
/* minimal mobile menu toggle + user dropdown */
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.nav');
  if (btn && nav) {
    btn.addEventListener('click', function(){
      const open = nav.classList.toggle('open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  const userBtn = document.getElementById('userMenuButton');
  const dropdown = document.querySelector('.user-dropdown');

  function closeMenu(){
    if(!dropdown) return;
    dropdown.style.display = 'none';
    if (userBtn) userBtn.setAttribute('aria-expanded','false');
  }
  function toggleMenu(){
    if(!dropdown) return;
    const open = dropdown.style.display === 'block';
    dropdown.style.display = open ? 'none' : 'block';
    if (userBtn) userBtn.setAttribute('aria-expanded', open ? 'false' : 'true');
  }

  userBtn?.addEventListener('click', (e)=>{ e.stopPropagation(); toggleMenu(); });
  document.addEventListener('click', (e)=>{
    if (!dropdown) return;
    if (!dropdown.contains(e.target) && e.target !== userBtn) closeMenu();
  });
  document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeMenu(); });
});
</script>
