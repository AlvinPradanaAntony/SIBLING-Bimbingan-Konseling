<!doctype html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="/img/app_logo.png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  <title>Bimbingan Konseling | SMKN 7 Negeri Jember</title>

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <script>
    const selectedTheme = localStorage.getItem("selected-theme");
    if (selectedTheme) {
      document.documentElement.setAttribute("data-theme", selectedTheme);
    }
  </script>
</head>

<body>
  <header class="header">
    <nav class="navbar navbar-expand-md fixed-top" id="header">
      <div class="container">
        <button class="navbar-toggler me-4 m-md-0 border-0 shadow-none" type="button" data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <i class="uil uil-bars" style="font-size: 1.625rem; color: var(--title-color);"></i>
        </button>
        <a class="navbar-brand m-0" href="#">
          <div class="d-flex align-items-center " id="logo__app">
            <img src="img/app_logo.png" width="45" alt="logo_nav" />
            <div class="ms-2 d-flex flex-column">
              <h3>SIBLING</h3>
              <span>Bimbingan Konseling</span>
            </div>
          </div>
        </a>
        <div class="offcanvas offcanvas-start custom__canvas" tabindex="-1" id="offcanvasNavbar"
          aria-labelledby="offcanvasNavbarLabel">
          <div class="nav__close rounded-circle d-flex justify-content-center align-items-center d-md-none">
            <i class="uil uil-times" data-bs-dismiss="offcanvas" aria-label="Close"></i>
          </div>
          <div class="offcanvas-header">
            <div class="d-flex align-items-center " id="logo__app__sidebar">
              <img src="img/app_logo.png" width="45" alt="logo_nav" />
              <div class="ms-2 d-flex flex-column">
                <h3>SIBLING</h3>
                <span>Bimbingan Konseling</span>
              </div>
            </div>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end align-items-md-center flex-grow-1">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#home">
                  <i class="uil uil-estate d-md-none me-1 nav__icon"></i>
                  Home
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#news">
                  <i class="uil uil-newspaper d-md-none me-1 nav__icon"></i>
                  Berita
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">
                  <i class="uil uil-info-circle d-md-none me-1 nav__icon"></i>
                  Tentang
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#contact">
                  <i class="uil uil-phone d-md-none me-1 nav__icon"></i>
                  Hubungi Kami
                </a>
              </li>
              <li class="nav-item ps-md-2 pe-md-3 d-none d-md-block">
                <div class="change-theme">
                  <i class="uil uil-moon"></i>
                </div>
              </li>
            </ul>
          </div>
        </div>
        @auth
          <div class="dropdown">
            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="d-flex gap-1 account align-items-center p-2">
                <div class="p-md-0" style="padding-right: 0.75rem; padding-left: 0.75rem;">
                  <img class="rounded-circle object-fit-cover"
                    src="https://ui-avatars.com/api/?name=S+A&amp;color=7F9CF5&amp;background=EBF4FF" alt="Super Admin" />
                </div>
                <span class="d-none d-md-inline-block">Super Admin</span>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm custom__container mt-2 px-2">
              <li class="mb-1">
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <i class="uil uil-apps me-2"></i>
                  <span>Dashboard</span>
                </a>
              </li>
              <li class="mb-1">
                <a class="dropdown-item d-flex align-items-center change-theme" href="#">
                  <i class="uil uil-moon me-2"></i>
                  <span>Tema Gelap</span>
                </a>
              </li>
              <div class="dropdown-divider"></div>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <i class="uil uil-sign-out-alt me-2"></i>
                  <span>Keluar</span>
                </a>
              </li>
            </ul>
          </div>
        @else
          <a href="{{ route('login') }}" class="btn btn-primary custom__btn">Login</a>
        @endauth
      </div>
    </nav>
  </header>
  <main>
    <!--==================== HOME ====================-->
    <section class="home" id="home">
      <div class="container">
        <div class="banner__heroes">
          <span class="custom-badge">Karir</span>
          <div class="row">
            <div class="col-lg-6 d-flex flex-column">
              <h1 class="home__title mb-3 mb-md-4 position-relative">Program Pengembangan Karir Lulusan SMK Negeri 7
                Jember</h1>
              <p class="home__description mb-4 mb-lg-3 mb-xl-5 pe-4 position-relative">Saat ini, kami membuka peluang
                bagi generasi muda,
                terutama lulusan baru, untuk bergabung dan mengembangkan keterampilan di dunia kerja.</p>
              <div class="mb-5 mb-lg-0">
                <a href="#news" class="btn btn-primary cta__btn py-3">Daftar Sekarang!</a>
              </div>
              <div class="datetime mt-auto">
                <i class="uil uil-clock"></i>
                <span>Batas Waktu: 30 September 2024</span>
              </div>
            </div>
            <div class="col-lg-6 position-relative d-lg-inline-block d-none">
              <img src="img/ornamen1.svg" class="ornamen1" alt="ornamen1" />
              <div class="ornamen mt-4">
                <span data-badge="Populer"></span>
                <div class="w-100 h-100 d-flex justify-content-center overflow-hidden" style="border-radius:16px;">
                  <img src="img/samples_offer.jpg" class="img-fluid" style="object-fit: cover;"/>
                </div>
              </div>
            </div>
          </div>
          <img src="img/wavy-lines.svg" class="wavy-lines" alt="wavy-lines" />
        </div>
      </div>
    </section>
    <!--==================== NEWS ====================-->
    <section class="news section" id="news">
      <div class="container">
        <div class="text-center">
          <h2 class="section__title">Informasi Lowongan Pekerjaan</h2>
          <p class="section__subtitle">Berita terbaru seputar dunia kerja dan karir</p>
        </div>
        <div class="row mb-4">
          {{-- @foreach ($job_vacancies as $job_vacancy)
          <div class="col-lg-4">
            <div class="card">
              <img src="{{ asset('storage/pamphlets/' . $job_vacancy->pamphlet) }}" class="card-img-top"
                alt="Gambar lowongan kerja" />
              <div class="card-body">
                <h5 class="card-title">{{ $job_vacancy->position }}</h5>
                <p class="card-text">{{ $job_vacancy->description }}</p>
                <a href="#" class="btn button">Detail</a>
              </div>
            </div>
          </div>
          @endforeach --}}
          <div class="col-lg-4 mb-3">
            <div class="card">
              <img src="https://picsum.photos/500/500?{{ rand(1,100) }}" class="img-fluid" style="height: 225px; object-fit: cover;" alt="..."  />
              <div class="card-body">
                <h5 class="card-title">Shopee & SeaMoney Graduate Development Program 2025 (Indonesia)</h5>
                <p class="card-text">Shopee International Indonesia saat ini membuka peluang bagi generasi muda terbuka
                  bagi lulusan baru.</p>
                <a href="#" class="btn button">Detail</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mb-3">
            <div class="card">
              <img src="https://picsum.photos/500/500?{{ rand(1,100) }}" class="img-fluid" style="height: 225px;" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Shopee & SeaMoney Graduate </h5>
                <p class="card-text">Shopee International Indonesia saat ini membuka peluang bagi generasi muda terbuka
                  bagi lulusan baru.</p>
                <a href="#" class="btn button">Detail</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mb-3">
            <div class="card">
              <img src="https://picsum.photos/500/500?{{ rand(1,100) }}" class="img-fluid" style="height: 225px; object-fit: cover" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Shopee & SeaMoney Graduate Development Program 2025 (Indonesia)</h5>
                <p class="card-text">Shopee International Indonesia saat ini membuka peluang bagi generasi muda terbuka
                  bagi lulusan baru.</p>
                <a href="#" class="btn button">Detail</a>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-center">
            <button class="btn button">Lihat Lebih Banyak</button>
          </div>
        </div>
    </section>
    <!--==================== ABOUT ====================-->
    <section class="about section" id="about">
      <div class="container">
        <h2 class="section__title">Tentang</h2>
        <p class="section__subtitle">Tentang Bimbingan Konseling SMKN 7 Negeri Jember</p>
        <div class="row">
          <div class="col-lg-6">
            <h3 class="about__title">Bimbingan Konseling SMKN 7 Negeri Jember</h3>
            <p class="about__description">Bimbingan Konseling SMKN 7 Negeri Jember merupakan sebuah layanan sekolah
              kepada siswa maupun guru untuk membantu mereka dalam mengatasi masalah pribadi, sosial, akademik, dan
              karir. Layanan ini bertujuan untuk membantu siswa agar dapat mengembangkan potensi diri, mengatasi masalah
              yang dihadapi, dan membuat keputusan yang tepat dalam kehidupan mereka. </p>

          </div>
          <div class="col-lg-6">
            <h3 class="about__title text-center mb-5">Dukungan</h3>
            <div class="about__logos text-center">
              <img src="img/logo-smk-7.png" class="me-2" alt="Logo 1" width="90" />
              <img src="img/SMKN-7-JEMBER-4.png" class="me-2" alt="Logo 2" width="120" />
              <img src="img/smkbisa.png" class="me-2" alt="Logo 3" width="140" />
              <img src="img/app_logo_extend.png" class="me-2" alt="Logo 4" width="140" />
            </div>
          </div>
        </div>
    </section>

    <!--==================== CONTACT ====================-->
    <section class="contact section" id="contact">
      <div class="container">
        <h2 class="section__title text-center">Hubungi Kami</h2>
        <p class="section__subtitle text-center">Kami siap membantu Anda</p>

        <div class="row">
          <!-- Informasi Kontak -->
          <div class="col-lg-6 ">
            <div class="contact__info">
              <div class="contact__info__item d-flex mb-4">
                <i class="uil uil-phone me-3 fs-4"></i>
                <div>
                  <h3>Telepon</h3>
                  <span>031-8292038</span>
                </div>
              </div>

              <div class="contact__info__item d-flex mb-4">
                <i class="uil uil-envelope me-3 fs-4"></i>
                <div>
                  <h3>Email</h3>
                  <span><a href="mailto:info@smkn7jember.sch.id"
                      class="contact__info__email">info@smkn7jember.sch.id</a></span>
                </div>
              </div>

              <div class="contact__info__item d-flex mb-4">
                <i class="uil uil-map-marker me-3 fs-4"></i>
                <div>
                  <h3>Alamat</h3>
                  <span>Jl. Randu Agung Jatiroto, Jam Koong, Jatiroto, Kec. Sumberbaru, Kabupaten Jember, Jawa Timur
                    68156</span>
                </div>
              </div>

              <div class="contact__info__item d-flex">
                <i class="uil uil-clock me-3 fs-4"></i>
                <div>
                  <h3>Jam Kerja</h3>
                  <span>Senin - Jumat: 07.00 - 15.00</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mt-5 mt-lg-0">
            <form action="#" class="contact__form">
              <div class="form-group">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" class="form-control" placeholder="Masukkan nama Anda"
                  required />
              </div>
              <div class="form-group mt-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" placeholder="Masukkan email Anda"
                  required />
              </div>
              <div class="form-group mt-3">
                <label for="message" class="form-label">Pesan</label>
                <textarea id="message" class="form-control" rows="6" placeholder="Masukkan pesan Anda" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary mt-4">Kirim Pesan</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--==================== Footer ====================-->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <img src="img/app_logo_extend_w.png" alt="" height="50" />
          <p class="mt-4 pe-lg-5">Aplikasi Bimbingan Konseling Digital di SMKN 7 Jember adalah platform yang dirancang
            untuk membantu siswa dalam mengatasi masalah pribadi, sosial, akademik, dan karir. Dengan aplikasi ini,
            siswa dapat dengan mudah mengakses layanan bimbingan konseling secara online, membuat janji temu dengan
            konselor, dan mendapatkan berbagai sumber daya yang berguna untuk pengembangan diri.</p>
          <ul class="social-list list-inline mt-3">
            <li class="list-inline-item text-center">
              <a href="#" class="social-list-item border-primary text-primary">
                <i class="bx bxl-facebook"></i>
              </a>
            </li>
            <li class="list-inline-item text-center">
              <a href="#" class="social-list-item border-danger text-danger">
                <i class="bx bxl-google"></i>
              </a>
            </li>
            <li class="list-inline-item text-center">
              <a href="#" class="social-list-item border-info text-info">
                <i class="bx bxl-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item text-center">
              <a href="#" class="social-list-item border-secondary text-secondary">
                <i class="bx bxl-linkedin"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-lg-auto mt-3 mt-lg-0 ms-auto">
          <h5 class="mb-3">Link Terkait</h5>
          <ul class="nav flex-column">
            <li class="nav-item"><a href="https://smkn7jember.sch.id/" class="nav-link px-0 py-1">Profil SMKN 7
                Jember</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">Berita Karir</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">BKK</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">LSP</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">Pengumuman</a></li>
          </ul>
        </div>
        <div class="col-lg-auto mt-3 mt-lg-0 ms-auto">
          <h5 class="mb-3">Bantuan</h5>
          <ul class="nav flex-column">
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">Kebijakan Privasi</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">Syarat dan Ketentuan</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">Hubungi Kami</a></li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="mt-5">
            <p class="mt-4 text-center mb-0">©2024 SIBLING | SMKN 7 Jember</p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <a href="#home" class="scrollup" id="scroll-up">
    <i class="uil uil-arrow-up scrollup__icon"></i>
  </a>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/main.js"></script>
  <script>
    $(document).ready(function() {
      var badgeText = $('.ornamen span').data('badge'); // Ambil nilai dari data-badge
      $('.ornamen span').css('--badge-content', `"${badgeText}"`); // Set nilai untuk digunakan di CSS

      $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();

        var targetId = $(this).attr('href').substring(1);
        var targetElement = $('#' + targetId);

        if (targetElement.length) {
          // Menggulir ke elemen yang diinginkan
          $('html, body').animate({
            scrollTop: targetElement.offset().top
          }, 100);

          // Menggunakan history.pushState untuk menghilangkan hash dari URL
          history.pushState(null, null, ' ');
        }
      });
    });
  </script>
</body>

</html>
