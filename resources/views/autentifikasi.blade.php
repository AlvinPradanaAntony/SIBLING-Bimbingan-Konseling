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
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
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
          <a href={{ route('home') }} class="nav-link">
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
                <a href={{ route('status.index') }}>Data Status</a>
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
          <a href="#" class="nav-link active">
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
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 text-primary">Tabel Data Guru BK/Walas</h5>
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                  data-bs-target="#addUserModal">
                  Tambah Pengguna
                </button>
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                          aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="{{ route('user.store') }}" method="POST">
                          @csrf
                          <!-- Field Nama -->
                          <div class="mb-3">
                            <label for="photo" class="col-form-label">Foto</label>
                            <input type="text" class="form-control" id="photo" name="photo" required>
                          </div>
                          <!-- Field Nama -->
                          <div class="mb-3">
                            <label for="name" class="col-form-label">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                          </div>
                          <!-- Field NIP -->
                          <div class="mb-3">
                            <label for="nip" class="col-form-label">NIP/NUPTK:</label>
                            <input type="text" class="form-control" id="nip" name="nip" required>
                          </div>
                          <!-- Field Jenis Kelamin -->
                          <div class="mb-3">
                            <label for="gender" class="col-form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                          </div>
                          <!-- Field Jenis Kelamin -->
                          <div class="mb-3">
                            <label for="gender" class="col-form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                          </div>
                          <!-- Field Jenis Kelamin -->
                          <div class="mb-3">
                            <label for="gender" class="col-form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                          </div>
                          <!-- Field Jenis Kelamin -->
                          <div class="mb-3">
                            <label for="gender" class="col-form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                          </div>
                          <!-- Field Jenis Kelamin -->
                          <div class="mb-3">
                            <label for="gender" class="col-form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                          </div>
                          <!-- Field Jenis Kelamin -->
                          <div class="mb-3">
                            <label for="gender" class="col-form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                          </div>
                          <!-- Field Email -->
                          <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                          </div>
                          <!-- Field Jenis Kelamin -->
                          <div class="mb-3">
                            <label for="gender" class="col-form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                          </div>
                          <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div> --}}
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIP/NUPTK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Akses</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $user->photo }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->nip }}</td>
                          <td>{{ $user->gender }}</td>
                          <td>{{ $user->place_of_birth }}</td>
                          <td>{{ $user->date_of_birth }}</td>
                          <td>{{ $user->religion }}</td>
                          <td>{{ $user->phone_number }}</td>
                          <td>{{ $user->address }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->role->role_name }}</td>
                          <td>
                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                              data-bs-target="#edit_data{{ $user->id }}">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                              data-bs-target="#delete_data{{ $user->id }}">Hapus</a>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_data{{ $user->id }}" tabindex="-1"
                              aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit Data:
                                      {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                      aria-label="Close"></button>
                                  </div>
                                  <form action="{{ route('user.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">

                                      <div class="mb-3">
                                        <label for="photo" class="col-form-label">Foto:</label>
                                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                      </div>
                                      <div class="mb-3">
                                        <label for="name" class="col-form-label">Nama:</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                          value="{{ $user->name }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="nip" class="col-form-label">NIP/NUPTK</label>
                                        <input type="text" class="form-control" id="nip" name="nip"
                                          value="{{ $user->nip }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="gender" class="col-form-label">Jenis Kelamin</label>
                                        <select class="form-control" id="gender" name="gender">
                                          <option value="laki-laki" {{ $user->gender == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                          <option value="perempuan" {{ $user->gender == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="place_of_birth" class="col-form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth"
                                          value="{{ $user->place_of_birth }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="date_of_birth" class="col-form-label">Tanggal Lahir</label>
                                        <input type="text" class="form-control" id="date_of_birth" name="date_of_birth"
                                          value="{{ $user->date_of_birth }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="religion" class="col-form-label">Agama</label>
                                        <select class="form-control" id="religion" name="religion">
                                          <option value="Islam" {{ $user->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
                                          <option value="Kristen" {{ $user->religion == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                          <option value="Katolik" {{ $user->religion == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                          <option value="Hindu" {{ $user->religion == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                          <option value="Buddha" {{ $user->religion == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                          <option value="Konghucu" {{ $user->religion == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="phone_number" class="col-form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                          value="{{ $user->phone_number }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="address" class="col-form-label">Alamat</label>
                                        <input type="textarea" class="form-control" id="address" name="address"
                                          value="{{ $user->address }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                          value="{{ $user->email }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="role_id" class="col-form-label">Akses</label>
                                        <select class="form-control" id="role_id" name="role_id">
                                          @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                              {{ $role->role_name }}
                                            </option>
                                          @endforeach
                                        </select>
                                      </div>

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete_data{{ $user->id }}" tabindex="-1"
                              aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Hapus Data:
                                      {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                      aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data {{ $user->name }}?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                      data-bs-dismiss="modal">Tutup</button>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIP/NUPTK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Akses</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
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
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js"></script>
  <script src="js/script.js"></script>
  <script src="js/moment.js"></script>
  <script>
    new DataTable('#example');
  </script>
</body>

</html>