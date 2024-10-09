@extends('layouts.dashboard')

@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Siswa</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Tambah Pengguna
              </button>
              <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna Baru</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('student.store') }}" method="POST">
                        @csrf
                        <!-- Field Nama -->
                        <div class="mb-3">
                          <label for="name" class="col-form-label">Nama:</label>
                          <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <!-- Field Email -->
                        <div class="mb-3">
                          <label for="email" class="col-form-label">Email:</label>
                          <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <!-- Field Role -->
                        {{-- <div class="mb-3">
                        <label for="role" class="col-form-label">Role:</label>
                        <select class="form-select" id="role" name="role" required>
                          <option value="admin">Admin</option>
                          <option value="user">User</option>
                          <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                        </select>
                      </div> --}}
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
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Foto</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>NISN</th>
                      <th>Jenis Kelamin</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Agama</th>
                      <th>Nomor Telepon</th>
                      <th>Alamat</th>
                      <th>Wali</th>
                      <th>No Wali</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Tanggal Masuk</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($students as $student)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->photo }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->class->class_level }}</td>
                        <td>{{ $student->nisn }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->place_of_birth }}</td>
                        <td>{{ $student->date_of_birth }}</td>
                        <td>{{ $student->religion }}</td>
                        <td>{{ $student->phone_number }}</td>
                        <td>{{ $student->address }}</td>
                        <td>{{ $student->guardian_name }}</td>
                        <td>{{ $student->guardian_phone_number }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->status->status_name }}</td>
                        <td>{{ $student->admission_date }}</td>
                        <td>
                          <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit_data{{ $student->id }}">Edit</a>
                          <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete_data{{ $student->id }}">Hapus</a>

                          <!-- Edit Modal -->
                          <div class="modal fade" id="edit_data{{ $student->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $student->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{ $student->id }}">Edit Data:
                                    {{ $student->name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <form action="{{ route('user.update', $student->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">

                                    <div class="mb-3">
                                      <label for="name" class="col-form-label">Nama:</label>
                                      <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $student->name }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="email" class="col-form-label">Email:</label>
                                      <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $student->email }}">
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
                          <div class="modal fade" id="delete_data{{ $student->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel{{ $student->id }}">Hapus Data:
                                    {{ $student->name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda yakin ingin menghapus data {{ $student->name }}?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                  <form action="{{ route('user.destroy', $student->id) }}" method="POST">
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
                      <th>Kelas</th>
                      <th>NISN</th>
                      <th>Jenis Kelamin</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Agama</th>
                      <th>Nomor Telepon</th>
                      <th>Alamat</th>
                      <th>Wali</th>
                      <th>No Wali</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Tanggal Masuk</th>
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
@endsection
