<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="/img/app_logo.png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  <title>Bimbingan Konseling | SMKN 7 Negeri Jember</title>

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <header class="header">
    <nav class="navbar navbar-expand-md fixed-top" id="header">
      <div class="container">
        <button class="nav__toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="uil uil-bars nav__toggler__icon"></i>
        </button>
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="img/app_logo.png" width="48" alt="Sibling" srcset="" />
          <div class="ms-2 d-flex flex-column ">
            <h3>SIBLING</h3>
            <span>Bimbingan Konseling</span>
          </div>
        </a>
        <div class="offcanvas offcanvas-start offcanvas__container" data-bs-scroll="true" id="navbarNav">
          <div class="offcanvas-header offcanvas__header">
            <img src="img/app_logo.png" width="48" alt="Sibling" srcset="" />

            <div class="nav__btns">
              <i class="uil uil-moon change-theme me-1" id="theme-button"></i>
              <i class="uil uil-times nav__close" data-bs-dismiss="offcanvas" aria-label="Close"></i>
              <!-- <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
            </div>
          </div>
          <div class="offcanvas-body offcanvas__body nav__menu">
            <ul class="navbar-nav ms-auto mb-lg-0">
              <li class="nav-item me-3 align-self-md-center">
                <a class="nav-link nav__link active" aria-current="page" href="#home">
                  <i class="uil uil-estate d-md-none me-2 nav__icon"></i>
                  Home
                </a>
              </li>
              <li class="nav-item me-3 align-self-md-center">
                <a class="nav-link nav__link" href="#news">
                  <i class="uil uil-atom d-md-none me-2 nav__icon"></i>
                  Berita
                </a>
              </li>
              <li class="nav-item me-3 align-self-md-center">
                <a class="nav-link nav__link" href="#about">
                  <i class="uil uil-pricetag-alt d-md-none me-2 nav__icon"></i>
                  Tentang
                </a>
              </li>
              <li class="nav-item me-3 align-self-md-center">
                <a class="nav-link nav__link" href="#contact">
                  <i class="uil uil-message d-md-none me-2 nav__icon"></i>
                  Hubungi Kami
                </a>
              </li>
            </ul>
            <div class="align-self-md-center me-3 nav__theme">
              <i class="uil uil-moon change-theme" id="theme-button"></i>
            </div>
            <a href="{{ route('login') }}" class="btn btn-primary navbar__btn align-self-center pt-1">Login</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <!--==================== HOME ====================-->
    <section class="home" id="home">
      <div class="container">
        <span class="custom-badge">Karir</span>
        <div class="row">
          <div class="col-lg-6">
            <h1 class="home__title mb-4 position-relative">Shopee & SeaMoney Graduate Development Program 2025
              (Indonesia)</h1>
            <p class="home__description mb-5 pe-4 position-relative">Shopee International Indonesia saat ini membuka
              peluang bagi generasi muda terbuka bagi lulusan baru.</span></p>
            <div class="d-flex nav__btns position-relative">
              <button class="btn button me-3" type="submit">Daftar Sekarang !</button>
              <button class="btn button-alt" type="submit">Detail</button>
            </div>
          </div>
          <div class="col-lg-6 position-relative d-lg-inline-block d-none">
            <img src="img/ornamen1.svg" class="ornamen1" alt="..." />
            <div class="ornamen mt-4 d-flex justify-content-center">
              <span data-badge="Populer"></span>
              <img src="img/samples_offer.jpg" />
            </div>
          </div>
        </div>
        <div class="datetime">
          <i class="uil uil-clock"></i>
          <span>Batas Waktu: 30 September 2024</span>
        </div>
        <img src="img/wavy-lines.svg" class="wavy-lines" alt="..." />
      </div>
    </section>

    <!--==================== NEWS ====================-->
    <section class="news section" id="news">
      <div class="container">
        <h2 class="section__title">Berita</h2>
        <p class="section__subtitle">Berita terbaru seputar dunia kerja dan karir</p>

        <div class="row mb-5">
          <div class="col-lg-4">
            <div class="card">
              <img src="img/samples_offer.jpg" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Shopee & SeaMoney Graduate Development Program 2025 (Indonesia)</h5>
                <p class="card-text">Shopee International Indonesia saat ini membuka peluang bagi generasi muda terbuka
                  bagi lulusan baru.</p>
                <a href="#" class="btn button">Detail</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <img src="img/samples_offer.jpg" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Shopee & SeaMoney Graduate Development Program 2025 (Indonesia)</h5>
                <p class="card-text">Shopee International Indonesia saat ini membuka peluang bagi generasi muda terbuka
                  bagi lulusan baru.</p>
                <a href="#" class="btn button">Detail</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <img src="img/samples_offer.jpg" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Shopee & SeaMoney Graduate Development Program 2025 (Indonesia)</h5>
                <p class="card-text">Shopee International Indonesia saat ini membuka peluang bagi generasi muda terbuka
                  bagi lulusan baru.</p>
                <a href="#" class="btn button">Detail</a>
              </div>
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
                  <span>(0331) 487 000</span>
                </div>
              </div>

              <div class="contact__info__item d-flex mb-4">
                <i class="uil uil-envelope me-3 fs-4"></i>
                <div>
                  <h3>Email</h3>
                  <span><a href="mailto:info@yourwebsite.com"
                      class="contact__info__email">info@yourwebsite.com</a></span>
                </div>
              </div>

              <div class="contact__info__item d-flex mb-4">
                <i class="uil uil-map-marker me-3 fs-4"></i>
                <div>
                  <h3>Alamat</h3>
                  <span>Jl. Mawar No. 20, Jember, Jawa Timur</span>
                </div>
              </div>

              <div class="contact__info__item d-flex">
                <i class="uil uil-clock me-3 fs-4"></i>
                <div>
                  <h3>Jam Kerja</h3>
                  <span>Senin - Jumat: 09.00 - 17.00</span>
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
            <li class="nav-item"><a href="#" class="nav-link px-0 py-1">Profil SMKN 7 Jember</a></li>
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
