
<div class="footer_stricky_fixed_master_class fixed-bottom d-xs-block d-sm-block d-md-block d-lg-none border-top">
    <div class="footer">
      <ul class="nav nav-pills nav-justified">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ url('/') }}">
            <i class="fa fa-home" aria-hidden="true"></i>&nbsp;<span class="tab_label">Home</span>
          </a>
        </li>
        <?php if(Session::get('login_status') != "1"){ ?>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('login') }}">
              <i class="fa fa-user"></i>&nbsp;<span class="tab_label">Login</span>
            </a>
          </li>
          <?php } ?>
          <?php if(Session::get('login_status') == "1"){ ?>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('vendor/dashboard') }}">
              <i class="fa fa-user"></i>&nbsp;<span class="tab_label">Account</span>
            </a>
          </li>
          <?php } ?>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ url('become-a-vendor') }}">
            <i class="fa fa-handshake-o" aria-hidden="true"></i> &nbsp;<span class="tab_label" style="color: red; font-weight: bold;">Free Join</span>
            
          </a>
        </li>
      </ul>
    </div>
  </div>
    <!-- <div class="col-12 shadow-lg mb-5 bg-gradient-primary border-top d-none d-xs-none d-sm-none d-md-none d-lg-block">

      <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3">
          <p class="col-md-4 mb-0 text-muted">© 2022 Karigar Bazar, Inc</p>
      
          <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          </a>
      
          <div class="nav col-md-4 justify-content-end">
            <div class="row">
              Mobile: +91 9898079641 | Email: support@karigarbazar.com
            </div>
          </div>
        </footer>
    </div> -->

    <style>
.footer_stricky_fixed_master_class{ background: white;  }
.footer_stricky_fixed_master_class a{ color: black }
.tab_label{ font-size: 13px; }

</style>