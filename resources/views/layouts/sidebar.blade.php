<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>

  <!-- Brand Bar -->
  <div class="sidebar-brand">
    <a href="{{ url('/') }}" class="brand-link" aria-label="Guley Threads Home">
      <span class="logo-wrap">
        <img src="{{ asset('assets/images/guley.jpg') }}" alt="Guley Threads Logo">
      </span>
    </a>
    <a href="{{ url('/') }}" class="home-btn" title="Visit Guley Threads Website">
      <iconify-icon icon="solar:home-smile-angle-outline"></iconify-icon>
      <span>Go to Website</span>
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
          <li><a href="{{ route('admin.users.create') }}">
            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Add Users
          </a></li>
          <li><a href="{{ route('admin.users.index') }}">
            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Users List
          </a></li>
        </ul>
      </li>

      <li class="sidebar-menu-group-title">Catalog</li>
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:bag-3-outline" class="menu-icon"></iconify-icon>
          <span>Products</span>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{ route('admin.products.create') }}">
            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Add Product
          </a></li>
          <li><a href="{{ route('admin.products.index') }}">
            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Product List
          </a></li>
        </ul>
      </li>

      <!-- ================= NEW SECTION: WHAT'S NEW ================= -->
      <li class="sidebar-menu-group-title">What’s New</li>
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:widget-4-outline" class="menu-icon"></iconify-icon>
          <span>What’s New</span>
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.new.create') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Add Item
            </a>
          </li>
          <li>
            <a href="{{ route('admin.new.index') }}">
              <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Items List
            </a>
          </li>
        </ul>
      </li>
      <!-- =========================================================== -->

      <li class="sidebar-menu-group-title">Orders</li>
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:clipboard-list-outline" class="menu-icon"></iconify-icon>
          <span>Orders</span>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{ route('admin.orders.check') }}">
            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Order List
          </a></li>
          <li><a href="{{ route('admin.orders.index') }}">
            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Approved Orders
          </a></li>
        </ul>
      </li>
    </ul>
  </div>
</aside>

<style>
/* --- Brand Section --- */
.sidebar-brand {
  padding: 22px 16px 12px;
  border-bottom: 1px solid #eef0f3;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #fff;
  text-align: center;
  gap: 10px;
}

.logo-wrap {
  width: 150px;
  height: 55px;
  border: 1px solid #eef0f3;
  border-radius: 12px;
  background: #fff;
  box-shadow: 0 6px 18px rgba(2, 6, 23, 0.06);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.logo-wrap img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.home-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-weight: 600;
  font-size: 14px;
  color: #2563eb;
  text-decoration: none;
  transition: 0.25s ease;
  padding: 6px 12px;
  border-radius: 8px;
  background: #eef6ff;
}
.home-btn:hover {
  background: #2563eb;
  color: #fff;
}

.sidebar-menu-area { padding-top: 10px; }
</style>
