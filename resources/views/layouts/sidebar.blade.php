<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>

  <!-- Brand Bar -->
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="brand-link" aria-label="Guley Threads">
      <span class="logo-wrap">
        <img src="{{ asset('assets/images/guley.jpg') }}" alt="Guley Threads Logo">
      </span>
    </a>
  </div>

  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li>
        <a href="{{ route('admin.dashboard') }}">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="sidebar-menu-group-title">Users</li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:user-linear" class="menu-icon"></iconify-icon>
          <span>User Management</span>
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.users.create') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Add Users
            </a>
          </li>
          <li>
            <a href="{{ route('admin.users.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Users List
            </a>
          </li>
        </ul>
      </li>

      <li class="sidebar-menu-group-title">Catalog</li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:bag-3-outline" class="menu-icon"></iconify-icon>
          <span>Products</span>
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.products.create') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Add Product
            </a>
          </li>
          <li>
            <a href="{{ route('admin.products.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Product List
            </a>
          </li>
        </ul>
      </li>

      <li class="sidebar-menu-group-title">Orders</li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:clipboard-list-outline" class="menu-icon"></iconify-icon>
          <span>Orders</span>
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.orders.check') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Order List
            </a>
          </li>
          <li>
            <a href="{{ route('admin.orders.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Approved Orders
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</aside>

<style>
/* --- Brand bar: clean, centered, no distortion --- */
.sidebar-brand{
  padding:18px 16px;
  border-bottom:1px solid #eef0f3;
  display:flex; justify-content:center; align-items:center;
  background:#fff;
}
.brand-link{display:inline-flex; align-items:center; justify-content:center; text-decoration:none}

.logo-wrap{
  width:160px;           /* overall card width (tweak if needed) */
  height:56px;           /* fixed height for consistent look */
  padding:6px 10px;      /* breathing space around logo */
  border:1px solid #eef0f3;
  border-radius:12px;    /* soft card */
  background:#fff;
  box-shadow:0 6px 18px rgba(2,6,23,.06);
  display:flex; align-items:center; justify-content:center;
}

.logo-wrap img{
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;   /* prevents stretching */
  display:block;
}

/* Hover micro-interaction (subtle and classy) */
.brand-link:hover .logo-wrap{ box-shadow:0 10px 24px rgba(2,6,23,.10) }

/* Optional: compact logo when sidebar is collapsed (if your layout adds a class like .is-collapsed) */
.sidebar.is-collapsed .logo-wrap{
  width: 44px;
  height: 44px;
  padding: 4px;
  border-radius: 10px;
}

/* Keep menu spacing neat after the brand bar */
.sidebar-menu-area{ padding-top: 10px; }
</style>
