@extends('layouts.dashboard')
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
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('guidance.store') }}" method="POST">
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
                            @foreach ($users as $user)
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="notes" class="col-form-label">Catatan</label>
                          <textarea type="text" class="form-control" id="notes" name="notes" required></textarea>
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
                                <form action="{{ route('guidance.update', $guidance->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">

                                    <div class="mb-3">
                                      <label for="student_id" class="col-form-label">Nama Siswa</label>
                                      <select class="form-control" id="user_id" name="student_id" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach ($students as $student)
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
                                      <label for="date" class="col-form-label">Tanggal</label>
                                      <input type="date" class="form-control" id="date" name="date"
                                        value="{{ $guidance->date }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="user_id" class="col-form-label">Guru BK</label>
                                      <select class="form-control" id="user_id" name="user_id" required>
                                        <option value="">-- Pilih Guru BK --</option>
                                        @foreach ($users as $user)
                                          <option value="{{ $user->id }}"
                                            {{ $guidance->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                          </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="mb-3">
                                      <label for="notes" class="col-form-label">Catatan</label>
                                      <textarea class="form-control" id="notes" name="notes">{{ $guidance->notes }}</textarea>
                                    </div>

                                    <!-- Add more fields as needed -->

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
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                  <form action="{{ route('guidance.destroy', $guidance->id) }}" method="POST">
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
                      <th>Topik</th>
                      <th>Tanggal</th>
                      <th>Guru BK</th>
                      <th>Catatan</th>
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
