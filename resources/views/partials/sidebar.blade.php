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
        class="nav-link {{ in_array($active, ['student','guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status']) ? 'active' : '' }}">
        <i class="uil uil-database"></i>
        <span style="vertical-align: middle" class="link_name"> Data </span>
        <span class="menu-arrow uil-angle-right"></span>
      </a>
      <div class="collapse" id="data">
        <ul class="sub-menu">
          <li><a class="link_name" href="#">DATA</a></li>
          <li>
            <a href="{{ route('student.index') }}" class="{{ $active === 'student' ? 'active' : '' }}">Data Siswa</a>
          </li>
          <li>
            <a href="{{ route('guidance.index') }}" class="{{ $active === 'guidance' ? 'active' : '' }}">Data
              Bimbingan</a>
          </li>
          <li>
            <a href="{{ route('case.index') }}" class="{{ $active === 'case' ? 'active' : '' }}">Data Kasus</a>
          </li>
          <li>
            <a href="{{ route('attendance.index') }}" class="{{ $active === 'attendance' ? 'active' : '' }}">Data
              Rekap Absensi</a>
          </li>
          <li>
            <a href="{{ route('jobVacancy.index') }}" class="{{ $active === 'job_vacancy' ? 'active' : '' }}">Data
              Karir</a>
          </li>
          <li>
            <a href="{{ route('achievement.index') }}" class="{{ $active === 'achievement' ? 'active' : '' }}">Data
              Prestasi</a>
          </li>
          <li>
            <a href="{{ route('user.index') }}" class="{{ $active === 'user' ? 'active' : '' }}">Data Guru
              BK/Walas</a>
          </li>
          <li>
            <a href="{{ route('major.index') }}" class="{{ $active === 'major' ? 'active' : '' }}">Data Jurusan</a>
          </li>
          <li>
            <a href="{{ route('class.index') }}" class="{{ $active === 'class' ? 'active' : '' }}">Data Kelas</a>
          </li>
          <li>
            <a href="{{ route('role.index') }}" class="{{ $active === 'role' ? 'active' : '' }}">Data Hak Akses</a>
          </li>
          <li>
            <a href="{{ route('status.index') }}" class="{{ $active === 'status' ? 'active' : '' }}">Data Status
              Status</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a href="{{ route('reports.index') }}" class="nav-link {{ $active === 'laporan' ? 'active' : '' }}">
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
