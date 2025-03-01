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
    <li class="nav-item {{ in_array($active, ['student', 'guidance_booking', 'guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status', 'achievement','assessment', 'student_assessment']) ? 'nav-item-active' : '' }}">
      <a data-bs-toggle="collapse" href="#data" aria-expanded="{{ in_array($active, ['student', 'guidance_booking', 'guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status', 'achievement','assessment', 'student_assessment']) ? 'true' : 'false' }}" aria-controls="data"
        class="nav-link {{ in_array($active, ['student', 'guidance_booking', 'guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status', 'achievement','assessment', 'student_assessment']) ? 'active' : '' }}">
        <i class="uil uil-database"></i>
        <span style="vertical-align: middle" class="link_name"> Data </span>
        <span class="menu-arrow uil-angle-right"></span>
      </a>
      <div class="collapse {{ in_array($active, ['student', 'guidance_booking', 'guidance', 'case', 'attendance', 'job_vacancy', 'user', 'major', 'class', 'role','status', 'achievement', 'assessment', 'student_assessment']) ? 'show' : '' }}" id="data">
        <ul class="sub-menu" id="data-collapse">
          <li><a class="link_name" href="#">DATA</a></li>
          <li>
            <a data-bs-toggle="collapse" href="#data_master" aria-expanded="{{ in_array($active, ['student','user', 'major', 'class', 'role', 'status', 'assessment']) ? 'true' : 'false' }}" aria-controls="data_master">Master
              <span class="submenu-dot"></span>
              <span class="menu-arrow uil uil-arrow-right"></span>
            </a>
            <div class="collapse {{ in_array($active, ['student','user', 'major', 'class', 'role', 'status', 'assessment']) ? 'show' : '' }}" data-bs-parent="#data-collapse" id="data_master">
              <ul>
                @can('Lihat Siswa')
                <li>
                  <a href="{{ route('student.index') }}" class="{{ $active === 'student' ? 'active' : '' }}">Siswa</a>
                </li>
                @endcan
                @can('Lihat User')
                <li>
                  <a href="{{ route('user.index') }}" class="{{ $active === 'user' ? 'active' : '' }}">User</a>
                </li>
                @endcan
                @can('Lihat Jurusan') 
                <li>
                  <a href="{{ route('major.index') }}" class="{{ $active === 'major' ? 'active' : '' }}">Jurusan</a>
                </li>
                @endcan
                @can('Lihat Kelas')
                <li>
                  <a href="{{ route('class.index') }}" class="{{ $active === 'class' ? 'active' : '' }}">Kelas</a>
                </li>
                @endcan
                @can('Lihat Role')
                <li>
                  <a href="{{ route('role.index') }}" class="{{ $active === 'role' ? 'active' : '' }}">Role</a>
                </li>
                @endcan
                @can('Lihat Status')
                <li>
                  <a href="{{ route('status.index') }}" class="{{ $active === 'status' ? 'active' : '' }}">Status</a>
                </li>
                @endcan
                @can('Lihat Asesmen')
                <li>
                  <a href="{{ route('assessment.index') }}" class="{{ $active === 'assessment' ? 'active' : '' }}">Asesmen</a>
                </li>
                @endcan
              </ul>
          </li>
          <li>
            <a data-bs-toggle="collapse" href="#data_operasional" aria-expanded="{{ in_array($active, ['guidance_booking', 'guidance','case', 'attendance', 'job_vacancy', 'achievement','student_assessment']) ? 'true' : 'false' }}" aria-controls="data_operasional">Operasional
              <span class="submenu-dot"></span>
              <span class="menu-arrow uil uil-arrow-right"></span>
            </a>
            <div class="collapse {{ in_array($active, ['guidance_booking', 'guidance','case', 'attendance', 'job_vacancy', 'achievement','student_assessment']) ? 'show' : '' }}" data-bs-parent="#data-collapse" id="data_operasional">
              <ul>
                @can('Lihat Booking Bimbingan')
                <li>
                  <a href="{{ route('guidanceBooking.index') }}" class="{{ $active === 'guidance_booking' ? 'active' : '' }}">Booking Bimbingan</a>
                </li>
                @endcan
                @can('Lihat Bimbingan')
                <li>
                  <a href="{{ route('guidance.index') }}" class="{{ $active === 'guidance' ? 'active' : '' }}">Bimbingan</a>
                </li>
                @endcan
                @can('Lihat Kasus')
                <li>
                  <a href="{{ route('case.index') }}" class="{{ $active === 'case' ? 'active' : '' }}">Kasus</a>
                </li>
                @endcan
                @can('Lihat Absensi')
                <li>
                  <a href="{{ route('attendance.index') }}" class="{{ $active === 'attendance' ? 'active' : '' }}">Rekap Absensi</a>
                </li>
                @endcan
                @can('Lihat Loker')
                <li>
                  <a href="{{ route('jobVacancy.index') }}" class="{{ $active === 'job_vacancy' ? 'active' : '' }}">Karir</a>
                </li>
                @endcan
                @can('Lihat Prestasi')
                <li>
                  <a href="{{ route('achievement.index') }}" class="{{ $active === 'achievement' ? 'active' : '' }}">Prestasi</a>
                </li> 
                @endcan
                @can('Lihat Asesmen Siswa')
                <li>
                  <a href="{{ route('student_assessment.index') }}" class="{{ $active === 'student_assessment' ? 'active' : '' }}">Asesmen Siswa</a>
                </li> 
                @endcan
              </ul>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      @can('Lihat Autentifikasi')
      <a href="{{ route('autentifikasi.index') }}" class="nav-link {{ $active === 'autentifikasi' ? 'active' : '' }}">
        <i class="uil uil-shield-check"></i>
        <span style="vertical-align: middle" class="link_name">Autentifikasi</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Autentifikasi</a></li>
      </ul>
      @endcan
    </li>
    <li class="nav-item">
      @can('Lihat Perizinan')
      <a href="{{ route('permission.index') }}" class="nav-link {{ $active === 'permission' ? 'active' : '' }}">
        <i class="uil uil-shield-check"></i>
        <span style="vertical-align: middle" class="link_name">Permission</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Permission</a></li>
      </ul>
      @endcan
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
          @if (auth()->user()->photo)
            <img src="{{ route('user.showImage', auth()->user()->id) }}" alt="profileImg" />
          @else
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" alt="profileImg" />
          @endif
        </div>
        <div class="name-job">
          <div class="profile_name" id="profileName">{{ auth()->user()->name }}</div>
          <div class="job">{{ auth()->user()->getRoleNames()->first() ?? 'Tidak Ada Role' }}</div>
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

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const profileNameElement = document.getElementById("profileName");
    const fullName = profileNameElement.textContent.trim();

    if (fullName.length > 15) {
      const abbreviatedName = fullName
        .split(" ")
        .map((word, index) => (index === 0 ? word : word[0] + "."))
        .join(" ");
      profileNameElement.textContent = abbreviatedName;
    }
  });
</script>