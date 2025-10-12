<div class="navbar-header">
  <div class="row align-items-center justify-content-between gx-3">
    <!-- LEFT: toggles -->
    <div class="col-auto">
      <div class="d-flex align-items-center gap-2">
        <!-- Desktop sidebar toggle -->
        <button type="button" class="btn-reset header-icon-btn d-none d-md-inline-flex sidebar-toggle" aria-label="Toggle sidebar">
          <iconify-icon icon="heroicons:bars-3-solid" class="text-2xl non-active"></iconify-icon>
          <iconify-icon icon="iconoir:arrow-right" class="text-2xl active d-none"></iconify-icon>
        </button>

        <!-- Mobile sidebar toggle -->
        <button type="button" class="btn-reset header-icon-btn d-inline-flex d-md-none sidebar-mobile-toggle" aria-label="Toggle menu">
          <iconify-icon icon="heroicons:bars-3-solid" class="text-2xl"></iconify-icon>
        </button>
      </div>
    </div>

    <!-- RIGHT: profile -->
    <div class="col-auto">
      <div class="d-flex align-items-center gap-2">
        <div class="dropdown">
          <button class="btn-profile d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="avatar-initial">
              {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </span>
            <span class="fw-semibold text-dark d-none d-sm-inline">
              {{ auth()->user()->name ?? 'Admin' }}
            </span>
            <iconify-icon icon="gg:chevron-down" class="text-lg text-muted d-none d-sm-inline"></iconify-icon>
          </button>

          <div class="dropdown-menu dropdown-menu-end p-2 shadow-sm rounded-3 border-0">
            <div class="d-flex align-items-center justify-content-between bg-primary-subtle rounded-3 px-3 py-2 mb-2">
              <div>
                <div class="fw-semibold text-primary mb-0 small">
                  {{ auth()->user()->name ?? 'Admin' }}
                </div>
                <span class="text-secondary small">Admin</span>
              </div>
              <button type="button" class="btn-reset text-danger-emphasis" data-bs-toggle="dropdown">
                <iconify-icon icon="radix-icons:cross-1" class="text-lg"></iconify-icon>
              </button>
            </div>

            <a class="dropdown-item d-flex align-items-center gap-2 rounded-2 py-2" href="{{ route('profile.edit') }}">
              <iconify-icon icon="solar:user-linear" class="text-xl"></iconify-icon>
              My Profile
            </a>

            <hr class="dropdown-divider my-2">

            <a href="{{ route('logout') }}" class="dropdown-item d-flex align-items-center gap-2 text-danger rounded-2 py-2"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <iconify-icon icon="lucide:power" class="text-xl"></iconify-icon>
              Log Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Reset helper for icon-only buttons */
.btn-reset{
  background:none;border:0;padding:0;line-height:1;cursor:pointer;
}

/* Header icon buttons (hamburger etc.) */
.header-icon-btn{
  width:40px;height:40px;align-items:center;justify-content:center;
  border-radius:10px;background:#f3f4f6; /* neutral */
  transition:background .2s ease, transform .15s ease;
}
.header-icon-btn:hover{ background:#e9eaee }
.header-icon-btn:active{ transform:scale(.98) }

/* Profile button */
.btn-profile{
  height:40px;
  border:1px solid #e5e7eb;
  background:#ffffff;
  padding:0 .6rem 0 .4rem;
  border-radius:999px;
  transition:box-shadow .2s ease, border-color .2s ease, background .2s ease;
}
.btn-profile:hover{
  background:#f9fafb;
  border-color:#e2e8f0;
  box-shadow:0 6px 20px rgba(15,23,42,.08);
}

/* Circle avatar with initial (shows even if no image) */
.avatar-initial{
  width:28px;height:28px;border-radius:50%;
  display:inline-flex;align-items:center;justify-content:center;
  font-weight:800;font-size:.9rem;
  color:#fff;background:#6b7280; /* slate */
  letter-spacing:.02em;
}

/* Dropdown menu polish */
.dropdown-menu{
  min-width: 220px;
}
.dropdown-item{
  font-weight:600;font-size:.92rem;
}
.dropdown-item:hover{
  background:#f3f4f6;
}


/* Make it comfy on very small widths */
@media (max-width: 375px){
  .btn-profile{ padding:0 .4rem 0 .35rem }
  .avatar-initial{ width:26px;height:26px;font-size:.85rem }
}
</style>

<script>
// (Optional) toggle class swap if you later hook desktop sidebar open/close
document.addEventListener('click', function(e){
  const btn = e.target.closest('.sidebar-toggle');
  if(!btn) return;
  // swap which icon is shown if you maintain an "is-collapsed" state elsewhere
  btn.querySelector('.non-active')?.classList.toggle('d-none');
  btn.querySelector('.active')?.classList.toggle('d-none');
});
</script>
