<div class="sidebar me-0" id="sidebar">
  <div class="logo-details">
    <img src="img/app_logo_extend.png" width="135" alt="Logo" id="logo_sidebar" />
  </div>
  <ul class="nav-links m-0" id="main">
    <li class="nav-item">
      <a href="{{ route('home') }}" class="nav-link {{ $active === 'home' ? 'active' : '' }}">
        <i class="uil-apps"></i>
        <span style="vertical-align: middle" class="link_name"> Beranda </span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Beranda</a></li>
      </ul>
    </li>
    <li class="nav-item">
      <a data-bs-toggle="collapse" href="#data" aria-expanded="false" aria-controls="data"
        class="nav-link {{ in_array($active, ['siswa', 'karir', 'form', 'bimbingan', 'kasus', 'prestasi', 'absensi', 'jurusan']) ? 'active' : '' }}">
        <i class="uil uil-database"></i>
        <span style="vertical-align: middle" class="link_name"> Data </span>
        <span class="menu-arrow uil-angle-right"></span>
      </a>
      <div class="collapse" id="data">
        <ul class="sub-menu">
          <li><a class="link_name" href="#">DATA</a></li>
          <li>
            <a href="{{ route('siswa.index') }}" class="{{ ($active === 'siswa') ? 'active' : '' }}">Data Siswa</a>
          </li>
          <li>
            <a href="{{ route('karir.index') }}" class="{{ ($active === 'karir') ? 'active' : '' }}">Data Karir</a>
          </li>
          <li>
            <a href="{{ route('form.index') }}" class="{{ ($active === 'form') ? 'active' : '' }}">Data Form</a>
          </li>
          <li>
            <a href="{{ route('bimbingan.index') }}" class="{{ ($active === 'bimbingan') ? 'active' : '' }}">Data Bimbingan</a>
          </li>
          <li>
            <a href="{{ route('kasus.index') }}" class="{{ ($active === 'kasus') ? 'active' : '' }}">Data Kasus</a>
          </li>
          <li>
            <a href="{{ route('prestasi.index') }}" class="{{ ($active === 'prestasi') ? 'active' : '' }}">Data Prestasi</a>
          </li>
          <li>
            <a href="{{ route('absensi.index') }}" class="{{ ($active === 'absensi') ? 'active' : '' }}">Data Rekap Absensi</a>
          </li>
          <li>
            <a href="{{ route('jurusan.index') }}" class="{{ ($active === 'jurusan') ? 'active' : '' }}">Data Jurusan</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a href="{{ route('laporan.index') }}" class="nav-link {{ $active === 'laporan' ? 'active' : '' }}">
        <i class="uil uil-file-info-alt"></i>
        <span style="vertical-align: middle" class="link_name">Laporan</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Laporan</a></li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="{{ route('user.index') }}" class="nav-link {{ $active === 'autentifikasi' ? 'active' : '' }}">
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
          <div class="profile_name">{{ auth()->user()->name }}</div>
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
