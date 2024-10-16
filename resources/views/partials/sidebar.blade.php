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
    <li class="nav-item {{ in_array($active, ['student','guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status']) ? 'nav-item-active' : '' }}">
      <a data-bs-toggle="collapse" href="#data" aria-expanded="{{ in_array($active, ['student','guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status']) ? 'true' : 'false' }}" aria-controls="data"
        class="nav-link {{ in_array($active, ['student','guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status']) ? 'active' : '' }}">
        <i class="uil uil-database"></i>
        <span style="vertical-align: middle" class="link_name"> Data </span>
        <span class="menu-arrow uil-angle-right"></span>
      </a>
      <div class="collapse {{ in_array($active, ['student','guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status']) ? 'show' : '' }}" id="data">
        <ul class="sub-menu" id="data-collapse">
          <li><a class="link_name" href="#">DATA</a></li>
          <li>
            <a data-bs-toggle="collapse" href="#data_master" aria-expanded="{{ in_array($active, ['student','user', 'major', 'class', 'role', 'status']) ? 'true' : 'false' }}" aria-controls="data_master">Master
              <span class="submenu-dot"></span>
              <span class="menu-arrow uil uil-arrow-right"></span>
            </a>
            <div class="collapse {{ in_array($active, ['student','user', 'major', 'class', 'role', 'status']) ? 'show' : '' }}" data-bs-parent="#data-collapse" id="data_master">
              <ul>
                <li>
                  <a href="{{ route('student.index') }}" class="{{ $active === 'student' ? 'active' : '' }}">Siswa</a>
                </li>
                <li>
                  <a href="{{ route('user.index') }}" class="{{ $active === 'user' ? 'active' : '' }}">Guru</a>
                </li>   
                <li>
                  <a href="{{ route('major.index') }}" class="{{ $active === 'major' ? 'active' : '' }}">Jurusan</a>
                </li>
                <li>
                  <a href="{{ route('class.index') }}" class="{{ $active === 'class' ? 'active' : '' }}">Kelas</a>
                </li>
                <li>
                  <a href="{{ route('role.index') }}" class="{{ $active === 'role' ? 'active' : '' }}">Role</a>
                </li>
                <li>
                  <a href="{{ route('status.index') }}" class="{{ $active === 'status' ? 'active' : '' }}">Status</a>
                </li>
              </ul>
          </li>
          <li>
            <a data-bs-toggle="collapse" href="#data_operasional" aria-expanded="{{ in_array($active, ['guidance','case', 'attendance', 'job_vacancy', 'achievement']) ? 'true' : 'false' }}" aria-controls="data_operasional">Operasional
              <span class="submenu-dot"></span>
              <span class="menu-arrow uil uil-arrow-right"></span>
            </a>
            <div class="collapse {{ in_array($active, ['guidance','case', 'attendance', 'job_vacancy', 'achievement']) ? 'show' : '' }}" data-bs-parent="#data-collapse" id="data_operasional">
              <ul>
                <li>
                  <a href="{{ route('guidance.index') }}" class="{{ $active === 'guidance' ? 'active' : '' }}">Bimbingan</a>
                </li>
                <li>
                  <a href="{{ route('case.index') }}" class="{{ $active === 'case' ? 'active' : '' }}">Kasus</a>
                </li>
                <li>
                  <a href="{{ route('attendance.index') }}" class="{{ $active === 'attendance' ? 'active' : '' }}">Rekap Absensi</a>
                </li>
                <li>
                  <a href="{{ route('jobVacancy.index') }}" class="{{ $active === 'job_vacancy' ? 'active' : '' }}">Karir</a>
                </li>
                <li>
                  <a href="{{ route('achievement.index') }}" class="{{ $active === 'achievement' ? 'active' : '' }}">Prestasi</a>
                </li> 
              </ul>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a href="{{ route('reports.index') }}" class="nav-link {{ $active === 'reports' ? 'active' : '' }}">
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
    <li class="nav-item">
      <a href="\settings" class="nav-link {{ $active === 'settings' ? 'active' : '' }}">
        <i class="uil uil-setting"></i>
        <span style="vertical-align: middle" class="link_name">Pengaturan</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Pengaturan</a></li>
      </ul>
    </li>
    <li>
      <div class="profile-details">
        <div class="profile-content">
          <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" alt="profileImg" />
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
