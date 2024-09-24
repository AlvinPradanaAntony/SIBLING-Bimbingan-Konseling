<div class="home-navbar sticky-top" id="sticky-element">
  <nav class="navbar-custom navbar-expand-md shadowNavbar">
    <div class="container-fluid d-flex align-items-center">
      <div class="menu" id="menu"><i class="bx bx-menu menu-collapse"></i></div>
      <div class="collapse navbar-collapse justify-content-end " id="navbarSupportedContent">
        <ul class="navbar-nav mb-lg-0">
          <li class="nav-item d-flex align-items-center">
            <div class="time-frame me-3">
              <div id="date-part"></div>
              <div id="time-part"></div>
            </div>
            <span class="seperatorVertikal me-3"></span>
            <div class="nav__btns">
              <i class="uil uil-moon change-theme" id="theme-button"></i>
            </div>
          </li>
          <li class="nav-item dropdown frameProfile">
            <a class="nav-link dropdown-toggle nav-user" href="/#" id="navbarDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <span class="account-user-avatar d-inline-block"><img
                  src="https://ui-avatars.com/api/?name=User+Testing&background=random"
                  class="cust-avatar img-fluid rounded-circle" /></span>
              <span class="account-user-name">User Testing</span><span class="account-position">Guru BK</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end me-1 border border-0 custom-rounded"
              aria-labelledby="navbarDropdown" style="">
              <li>
                <a class="text-decoration-none" href="/profile">
                  <div class="dropdown-item custom-item-dropdown d-flex align-items-center">
                    <i class="uil uil-user me-2"></i>
                    <span class="nameItem">My Profile</span>
                  </div>
                </a>
              </li>
              <li>
                <a class="dropdown-item custom-item-dropdown d-flex align-items-center" href="/#">
                  <i class="uil uil-sign-out-alt me-2"></i>
                  <span class="nameItem">Sign Out</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>