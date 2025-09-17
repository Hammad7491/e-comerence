<footer class="gt-footer">
  <div class="container">
    <div class="row gy-4 align-items-start">

      <!-- Brand / Left column -->
      <div class="col-lg-3 col-md-6">
        <div class="d-flex align-items-start mb-2">
          <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="gt-logo me-2">
          <div class="gt-brand">
            <div class="gt-brand-line">Guley</div>
            <div class="gt-brand-line">Threads</div>
          </div>
        </div>
        <p class="gt-muted">
          We’d love to hear from you! Whether you have questions about our collections,
          need assistance with an order, or simply want to share your thoughts, feel free
          to reach out.
        </p>
      </div>

      <!-- Information -->
      <div class="col-lg-2 col-md-6">
        <div class="gt-head">INFORMATION</div>
        <ul class="gt-list">
          <li><a href="#">The brand</a></li>
          <li><a href="#">Privacy policy</a></li>
          <li><a href="#">Payments</a></li>
        </ul>
      </div>

      <!-- Customer Care -->
      <div class="col-lg-2 col-md-6">
        <div class="gt-head">CUSTOMER CARE</div>
        <ul class="gt-list">
          <li><a href="#">Exchange & return policy</a></li>
          <li><a href="#">FAQs</a></li>
          <li><a href="#">Contact us</a></li>
        </ul>
      </div>

      <!-- Your Account -->
      <div class="col-lg-2 col-md-6">
        <div class="gt-head">YOUR ACCOUNT</div>
        <ul class="gt-list">
          <li><a href="#">Sign in</a></li>
          <li><a href="#">View cart</a></li>
          <li><a href="#">Track an order</a></li>
          <li><a href="#">Update information</a></li>
        </ul>
      </div>

      <!-- Contact + Social -->
      <div class="col-lg-3 col-md-6 d-flex flex-column">
        <div class="gt-head">CONTACT DETAILS</div>

        <div class="gt-label">Telephone</div>
        <div class="gt-muted">+92 3157647938</div>
        <div class="gt-muted mb-2">+92 3069460063</div>

        <div class="gt-label">Email</div>
        <div class="gt-muted">gulmeryam18@gmail.com</div>

        <div class="mt-3 ms-auto">
          <div class="gt-socialbar">
            <!-- Facebook -->
            <a href="#" aria-label="Facebook" class="gt-social">
              <svg width="16" height="16" viewBox="0 0 320 512" aria-hidden="true">
                <path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S270.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
              </svg>
            </a>
            <!-- Instagram -->
            <a href="#" aria-label="Instagram" class="gt-social">
              <svg width="18" height="18" viewBox="0 0 448 512" aria-hidden="true">
                <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9S160.5 370.9 224.1 370.9 339 319.6 339 256 287.7 141 224.1 141zm0 189.6c-41.2 0-74.7-33.4-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.4 74.7 74.7-33.5 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.9-26.9 26.9s-26.9-12-26.9-26.9 12-26.9 26.9-26.9 26.9 12 26.9 26.9zM398.8 80c-7.8-20.7-24.3-37.2-45-45C327.7 24 224 24 224 24s-103.7 0-129.8 11c-20.7 7.8-37.2 24.3-45 45C38.2 106.3 38.2 160 38.2 160s0 53.7 11 80c7.8 20.7 24.3 37.2 45 45 26.1 11 129.8 11 129.8 11s103.7 0 129.8-11c20.7-7.8 37.2-24.3 45-45 11-26.3 11-80 11-80s0-53.7-11-80z"/>
              </svg>
            </a>
            <!-- Google Plus (legacy icon) -->
            <a href="#" aria-label="Google Plus" class="gt-social">
              <svg width="18" height="18" viewBox="0 0 640 512" aria-hidden="true">
                <path fill="currentColor" d="M386.6 228.3c1.8 9.7 2.8 19.7 2.8 30 0 110.6-92.3 200-206.4 200C79 458.3 0 379.3 0 282.3S79 106.3 183 106.3c52.4 0 100 20.3 135.3 53.4l-54.7 52.7c-15.2-14.6-41.7-31.7-80.6-31.7-68.9 0-125 56.4-125 124.8s56.1 124.8 125 124.8c79.7 0 109.7-57.3 114.3-86.8H183v-69.1h203.6zM640 224v64h-64v64h-64v-64h-64v-64h64v-64h64v64z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- bottom strip like reference -->
  <div class="gt-strip"></div>
</footer>

<style>
/* container + background */
.gt-footer{background:#f6f6f6;padding:38px 0 24px}

/* left brand block */
.gt-logo{
  width:56px;height:56px;object-fit:cover; /* square like header */
  border-radius:6px;display:block;
}
.gt-brand-line{font-weight:800;line-height:1;letter-spacing:.2px;color:#b3b3b3;font-size:28px}
@media (min-width:1200px){
  .gt-brand-line{font-size:32px}
}

/* tiny single-line headings (no letter spacing) */
.gt-head{
  font-size:12px;               /* small so it never wraps */
  font-weight:700;
  color:#7a7a7a;
  margin-bottom:10px;
  white-space:nowrap;           /* FORCE one line like the reference */
  text-transform:none;
}

/* labels on right column */
.gt-label{font-size:11px;font-weight:700;color:#7a7a7a;margin-top:4px}

/* body text / links */
.gt-muted{font-size:12px;color:#8f8f8f}
.gt-list{list-style:none;margin:0;padding:0}
.gt-list li{margin:6px 0}
.gt-list a{font-size:12px;color:#8f8f8f;text-decoration:none}
.gt-list a:hover{color:#555}

/* peach social bar on the right */
.gt-socialbar{
  width:220px;height:40px;background:#eec9a8; /* peach */
  display:flex;align-items:center;justify-content:center;gap:36px;
  border-radius:2px;
}
.gt-social{color:#ffffff;display:flex;align-items:center;justify-content:center}
.gt-social:hover{opacity:.9}

/* bottom dark strip */
.gt-strip{height:36px;background:#333;margin-top:26px}

/* small tweak for tighter spacing on md/lg */
@media (min-width:992px){
  .gt-footer .col-lg-2 .gt-list li{margin:5px 0}
}
</style>
