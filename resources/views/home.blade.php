<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="/img/app_logo.png">
  <link rel="stylesheet" href="css/Dashboard.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css" />
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <title>Dashboard | SMKN 7 Negeri Jember</title>

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <div class="wrapper">
    <div class="sidebar me-0" id="sidebar">
      <div class="logo-details">
        <img src="img/app_logo_extend.png" width="135" alt="Logo" id="logo_sidebar" />
      </div>
      <ul class="nav-links m-0" id="main">
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="uil-apps"></i>
            <span style="vertical-align: middle" class="link_name"> Beranda </span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Beranda</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#data" aria-expanded="false" aria-controls="data" class="nav-link">
            <i class="uil uil-database"></i>
            <span style="vertical-align: middle" class="link_name"> Data </span>
            <span class="menu-arrow uil-angle-right"></span>
          </a>
          <div class="collapse" id="data">
            <ul class="sub-menu">
              <li><a class="link_name" href="#">DATA</a></li>
              <li>
                <a href={{ route('student.index') }}>Data Siswa</a>
              </li>
              <li>
                <a href={{ route('guidance.index') }}>Data Bimbingan</a>
              </li>
              <li>
                <a href={{ route('case.index') }}>Data Kasus</a>
              </li>
              <li>
                <a href={{ route('attendance.index') }}>Data Rekap Absensi</a>
              </li>
              <li>
                <a href={{ route('jobVacancy.index') }}>Data Karir</a>
              </li>
              <li>
                <a href={{ route('achievement.index') }}>Data Prestasi</a>
              </li>
              <li>
                <a href={{ route('user.index') }}>Data Guru BK/Walas</a>
              </li>
              <li>
                <a href={{ route('major.index') }}>Data Jurusan</a>
              </li>
              <li>
                <a href={{ route('class.index') }}>Data Kelas</a>
              </li>
              <li>
                <a href={{ route('role.index') }}>Data Hak Akses</a>
              </li>
              <li>
                <a href={{ route('status.index') }}>Data Status Status</a>
              </li>
              {{-- <li>
                <a href={{ route('form.index') }}>Data Form</a>
              </li> --}}
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="uil uil-file-info-alt"></i>
            <span style="vertical-align: middle" class="link_name">Laporan</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Laporan</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link">
            <i class="uil uil-shield-check"></i>
            <span style="vertical-align: middle" class="link_name">Autentifikasi</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Autentifikasi</a></li>
          </ul>
        </li>
        <li>
          <div class="profile-details">
            <div class="profile-content">
              <img src="https://ui-avatars.com/api/?name=User+Testing&background=random" alt="profileImg" />
            </div>
            <div class="name-job">
              <div class="profile_name">User Testing</div>
              <div class="job">Guru BK</div>
            </div>
            <div class="ms-auto me-4">
              <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="uil uil-signout"></i>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <section class="home-section">
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

      <div class="content">
        <div class="row pt-4">
          <div class="mb-4">
            <div class="p-0" style="min-height: 500px">
              <div class="row g-2 mb-2">
                <div class="col-lg-8 m-0">
                  <div class="custCard">
                    <div class="px-2 py-0">
                      <div class="row no-gutters">
                        <div class="col-lg ps-4 pe-0">
                          <div class="text-card1 mb-lg-3 mt-lg-3">Selamat datang kembali, <b>User Testing</b></div>
                          <div class="text2-card1 text-white">Terima kasih anda telah mengakses layanan bimbingan
                            konseling. Kami siap membantu Anda dalam mengatasi berbagai tantangan dan mencapai
                            perkembangan yang lebih baik di sekolah.</div>
                        </div>
                        <div class="col-lg-auto p-0 ms-3">
                          <img src="img/1.png" class="img-fluid" alt="" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 m-0">
                  <div class="card">
                    <img src="..." class="card-img-top placeholder" alt="...">
                    <div class="card-body">
                      <p class="card-text">Card ini berisi informasi terbaru mengenai karir dan peluang pekerjaan yang
                        dapat membantu Anda dalam mengembangkan karir Anda lebih lanjut.</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card" id="data1">
                    <div class="card-body p-4">
                      <div class="d-flex align-items-center">
                        <div class="card-icon text-white">
                          <i class="uil uil-users-alt"></i>
                        </div>
                        <div class=" ms-auto card-detail">
                          <p class="mb-0 card-detail_text">Data Siswa</p>
                          <h4 class="my-1 card-detail_data">0</h4>
                        </div>
                      </div>
                    </div>
                    <div class="abstract1"></div>
                    <div class="abstract2"></div>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card" id="data2">
                    <div class="card-body p-4">
                      <div class="d-flex align-items-center">
                        <div class="card-icon text-white">
                          <i class="uil uil-database"></i>
                        </div>
                        <div class=" ms-auto card-detail">
                          <p class="mb-0 card-detail_text">Informasi Karir</p>
                          <h4 class="my-1 card-detail_data">0</h4>
                        </div>
                      </div>
                    </div>
                    <div class="abstract1"></div>
                    <div class="abstract2"></div>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                  <div class="card" id="data3">
                    <div class="card-body p-4">
                      <div class="d-flex align-items-center">
                        <div class="card-icon text-white">
                          <i class="uil uil-notes"></i>
                        </div>
                        <div class=" ms-auto card-detail">
                          <p class="mb-0 card-detail_text">Form Masuk</p>
                          <h4 class="my-1 card-detail_data">0</h4>
                        </div>
                      </div>
                    </div>
                    <div class="abstract1"></div>
                    <div class="abstract2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row gx-4 pt-4">
        <div class="col-lg-9">
        </div>
        <div class="col-lg-3 m-0"></div>
      </div>

  </div>
  </section>
  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/script.js"></script>
  <script src="js/moment.js"></script>
</body>

</html>
