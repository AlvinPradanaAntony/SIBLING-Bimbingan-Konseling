@extends('layouts.dashboard')
@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Kasus</h5>
              @can('Tambah Kasus')
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Tambah Data
              </button>
              @endcan
              <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addUserModalLabel">Tambah Data Baru</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('case.store') }}" method="POST">
                        @csrf
                        <!-- Field Nama -->
                        <div class="mb-3">
                          <label for="student_id" class="col-form-label">Nama Siswa</label>
                          <select class="form-control" id="student_id" name="student_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($students as $student)
                              <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="case_name" class="col-form-label">Kasus</label>
                          <input type="text" class="form-control" id="case_name" name="case_name" required>
                        </div>
                        <div class="mb-3">
                          <label for="case_point" class="col-form-label">Poin Kasus</label>
                          <input type="number" class="form-control" id="case_point" name="case_point" required>
                        </div>
                        <div class="mb-3">
                          <label for="date" class="col-form-label">Tanggal</label>
                          <input type="datetime-local" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                          <label for="description" class="col-form-label">Keterangan</label>
                          <textarea type="text" class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="resolution" class="col-form-label">Solusi</label>
                          <textarea type="text" class="form-control" id="resolution" name="resolution" required></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="user_id" class="col-form-label">Guru BK</label>
                          <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">-- Pilih Guru BK --</option>
                            @foreach ($users as $user)
                              @if($user->hasRole('Guru BK'))
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endif
                            @endforeach
                          </select>
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
                      <th>Nama Siswa</th>
                      <th>Kasus</th>
                      <th>Poin Kasus</th>
                      <th>Tanggal</th>
                      <th>Keterangan</th>
                      <th>Solusi</th>
                      <th>Guru BK</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cases as $case)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($case->student)->name }}</td>
                        <td>{{ $case->case_name }}</td>
                        <td>{{ $case->case_point }}</td>
                        <td>{{ $case->date }}</td>
                        <td>{{ $case->description }}</td>
                        <td>{{ $case->resolution }}</td>
                        <td>{{ optional($case->user)->name }}</td>
                        <td>
                          @can('Ubah Kasus')
                          <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit_data{{ $case->id }}">Edit</a>
                          @endcan
                          @can('Hapus Kasus')
                          <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete_data{{ $case->id }}">Hapus</a>
                          @endcan
                          <!-- Edit Modal -->
                          <div class="modal fade" id="edit_data{{ $case->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $case->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{ $case->id }}">Edit Data:
                                    {{ $case->name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <form action="{{ route('case.update', $case->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">

                                    <div class="mb-3">
                                      <label for="student_id" class="col-form-label">Nama Siswa</label>
                                      <select class="form-control" id="user_id" name="student_id" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach ($students as $student)
                                          <option value="{{ $student->id }}"
                                            {{ $case->student_id == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }}
                                          </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="mb-3">
                                      <label for="case_name" class="col-form-label">Kasus</label>
                                      <input type="text" class="form-control" id="case_name" name="case_name"
                                        value="{{ $case->case_name }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="case_point" class="col-form-label">Poin Kasus</label>
                                      <input type="number" class="form-control" id="case_point" name="case_point"
                                        value="{{ $case->case_point }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="date" class="col-form-label">Tanggal</label>
                                      <input type="datetime-local" class="form-control" id="date" name="date"
                                        value="{{ $case->date }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="description" class="col-form-label">Keterangan</label>
                                      <textarea class="form-control" id="description" name="description">{{ $case->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                      <label for="resolution" class="col-form-label">Solusi</label>
                                      <textarea class="form-control" id="resolution" name="resolution">{{ $case->resolution }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                      <label for="user_id" class="col-form-label">Guru BK</label>
                                      <select class="form-control" id="user_id" name="user_id" required>
                                        <option value="">-- Pilih Guru BK --</option>
                                        @foreach ($users as $user)
                                          @if($user->hasRole('Guru BK')) <!-- Menggunakan Spatie Role -->
                                            <option value="{{ $user->id }}" {{ $case->user_id == $user->id ? 'selected' : '' }}>
                                              {{ $user->name }}
                                            </option>
                                          @endif
                                        @endforeach
                                      </select>
                                    </div>

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                      data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>

                          <!-- Delete Modal -->
                          <div class="modal fade" id="delete_data{{ $case->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $case->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel{{ $case->id }}">Hapus Data:
                                    {{ $case->case_name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda yakin ingin menghapus data {{ $case->case_name }}?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                  <form action="{{ route('case.destroy', $case->id) }}" method="POST">
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
                      <th>Nama Siswa</th>
                      <th>Kasus</th>
                      <th>Poin Kasus</th>
                      <th>Tanggal</th>
                      <th>Keterangan</th>
                      <th>Solusi</th>
                      <th>Guru BK</th>
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
