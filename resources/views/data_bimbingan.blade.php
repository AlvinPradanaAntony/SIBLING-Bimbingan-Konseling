@extends('layouts.dashboard')

<<<<<<< HEAD
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
                <h5 class="m-0 text-primary">Tabel Data Bimbingan</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                  data-bs-target="#addUserModal">
                  Tambah Bimbingan
                </button>
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah Data Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                          aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="{{ route('guidance.store') }}" method="POST">
                          @csrf
                          <!-- Field Nama -->
                          <div class="mb-3">
                            <label for="student_id" class="col-form-label">Nama Siswa</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                              <option value="">-- Pilih Siswa --</option>
                              @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="topics" class="col-form-label">Topik</label>
                            <input type="text" class="form-control" id="topics" name="topics" required>
                          </div>
                          <div class="mb-3">
                            <label for="date" class="col-form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                          </div>
                          <div class="mb-3">
                            <label for="user_id" class="col-form-label">Guru BK</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                              <option value="">-- Pilih Guru BK --</option>
                              @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="notes" class="col-form-label">Catatan</label>
                            <input type="textarea" class="form-control" id="notes" name="notes" required>
                          </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                      </div>
                      </form>
=======
@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Bimbingan</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Tambah Data
              </button>
              <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addUserModalLabel">Tambah Data Baru</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
>>>>>>> bb09f2138cbd2a20eee2430897b434cf8669653e
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('bimbingan.store') }}" method="POST">
                        @csrf
                        <!-- Field Nama -->
                        <div class="mb-3">
                          <label for="name" class="col-form-label">Nama:</label>
                          <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($bimbingan as $bimbingan)
                      <tr>
<<<<<<< HEAD
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Topik</th>
                        <th>Tanggal</th>
                        <th>Guru BK</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($guidances as $guidance)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $guidance->student->name }}</td>
                          <td>{{ $guidance->topics }}</td>
                          <td>{{ $guidance->date }}</td>
                          <td>{{ $guidance->user->name }}</td>
                          <td>{{ $guidance->notes }}</td>
                          <td>
                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                              data-bs-target="#edit_data{{ $guidance->id }}">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                              data-bs-target="#delete_data{{ $guidance->id }}">Hapus</a>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit_data{{ $guidance->id }}" tabindex="-1"
                              aria-labelledby="editModalLabel{{ $guidance->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $guidance->id }}">Edit Data:
                                      {{ $guidance->topics }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                      aria-label="Close"></button>
                                  </div>
                                  <form action="{{ route('user.update', $guidance->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">

                                      <div class="mb-3">
                                        <label for="student_id" class="col-form-label">Nama Siswa</label>
                                        <select class="form-control" id="user_id" name="student_id" required>
                                          <option value="">-- Pilih Kelas --</option>
                                          @foreach($students as $student)
                                            <option value="{{ $student->id }}" 
                                              {{ $guidance->student_id == $student->id ? 'selected' : '' }}>
                                              {{ $student->name }} 
                                            </option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="topics" class="col-form-label">Topik</label>
                                        <input type="text" class="form-control" id="topics" name="topics"
                                          value="{{ $guidance->topics }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="date" class="col-form-label">Topik</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                          value="{{ $guidance->date }}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="user_id" class="col-form-label">Nama Guru BK</label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                          <option value="">-- Pilih Kelas --</option>
                                          @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                              {{ $guidance->user_id == $user->id ? 'selected' : '' }}>
                                              {{ $user->name }} 
                                            </option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="notes" class="col-form-label">Catatan</label>
                                        <input type="textarea" class="form-control" id="notes" name="notes"
                                          value="{{ $guidance->notes }}">
                                      </div>
                                      <!-- Add more fields as needed -->

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete_data{{ $guidance->id }}" tabindex="-1"
                              aria-labelledby="deleteModalLabel{{ $guidance->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $guidance->id }}">Hapus Data:
                                      {{ $guidance->topics }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                      aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data {{ $guidance->topics }}?
=======
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bimbingan->name }}</td>
                        <td>{{ $bimbingan->email }}</td>
                        <td>null</td>
                        <td>
                          <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit_data{{ $bimbingan->id }}">Edit</a>
                          <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete_data{{ $bimbingan->id }}">Hapus</a>

                          <!-- Edit Modal -->
                          <div class="modal fade" id="edit_data{{ $bimbingan->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $bimbingan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{ $bimbingan->id }}">Edit Data:
                                    {{ $bimbingan->name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <form action="{{ route('user.update', $bimbingan->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">

                                    <div class="mb-3">
                                      <label for="name" class="col-form-label">Nama:</label>
                                      <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $bimbingan->name }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="email" class="col-form-label">Email:</label>
                                      <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $bimbingan->email }}">
                                    </div>
                                    <!-- Add more fields as needed -->

>>>>>>> bb09f2138cbd2a20eee2430897b434cf8669653e
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                      data-bs-dismiss="modal">Close</button>
<<<<<<< HEAD
                                    <form action="{{ route('user.destroy', $guidance->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
=======
                                    <button type="submit" class="btn btn-primary">Save changes</button>
>>>>>>> bb09f2138cbd2a20eee2430897b434cf8669653e
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>

                          <!-- Delete Modal -->
                          <div class="modal fade" id="delete_data{{ $bimbingan->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $bimbingan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel{{ $bimbingan->id }}">Hapus Data:
                                    {{ $bimbingan->name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda yakin ingin menghapus data {{ $bimbingan->name }}?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                  <form action="{{ route('user.destroy', $bimbingan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                  </form>
                                </div>
                              </div>
                            </div>
<<<<<<< HEAD
                          </td>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Topik</th>
                        <th>Tanggal</th>
                        <th>Guru BK</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
=======
                          </div>
                        </td>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                </table>
>>>>>>> bb09f2138cbd2a20eee2430897b434cf8669653e
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
@endsection
