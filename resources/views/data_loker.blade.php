@extends('layouts.dashboard')
@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Karir</h5>
              @can('Tambah Loker')
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
                      <form action="{{ route('jobVacancy.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Field Nama -->
                        <div style="display: flex; justify-content: center; align-items: center;">
                          <img id="output" style="width: 90px; height: 90px; object-fit: cover;"/>
                        </div>
                        <div class="mb-3">
                          <label for="pamphlet" class="col-form-label">Brosur</label>
                          <input type="file" class="form-control" id="pamphlet" name="pamphlet" accept="image/*" onchange="loadFile(event)" required>
                        </div>
                        <div class="mb-3">
                          <label for="position" class="col-form-label">Posisi</label>
                          <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="mb-3">
                          <label for="company_name" class="col-form-label">Nama Perusahaan</label>
                          <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="mb-3">
                          <label for="description" class="col-form-label">Deskripsi</label>
                          <textarea type="text" class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="location" class="col-form-label">Lokasi</label>
                          <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                          <label for="salary" class="col-form-label">Gaji</label>
                          <input type="text" class="form-control" id="salary" name="salary" required>
                        </div>
                        <div class="mb-3">
                          <label for="dateline_date" class="col-form-label">Batas Waktu</label>
                          <input type="date" class="form-control" id="dateline_date" name="dateline_date" required>
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
                      <th>Brosur</th>
                      <th>Posisi</th>
                      <th>Nama Perusahaan</th>
                      <th>Deskripsi</th>
                      <th>Lokasi</th>
                      <th>Gaji</th>
                      <th>Batas Waktu</th>
                      <th>Ditambah oleh</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($job_vacancies as $job_vacancy)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                          <img src="{{ $job_vacancy->pamphlet ? asset('storage/pamphlets/' . $job_vacancy->pamphlet) : 'https://ui-avatars.com/api/?name=' . urlencode($job_vacancy->position) . '&background=random'}}" 
                            alt="pamphlet" class="img-fluid rounded"
                            style="width: 100px; height: 100px; cursor: pointer;" 
                            onclick="showFullscreen(this.src)">
                        </td>
                        <td>{{ $job_vacancy->position }}</td>
                        <td>{{ $job_vacancy->company_name }}</td>
                        <td>{{ $job_vacancy->description }}</td>
                        <td>{{ $job_vacancy->location }}</td>
                        <td>{{ $job_vacancy->salary }}</td>
                        <td>{{ $job_vacancy->dateline_date }}</td>
                        <td>{{ $job_vacancy->user ? $job_vacancy->user->name : '-' }}</td>
                        <td>
                          @can('Ubah Loker')
                          <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit_data{{ $job_vacancy->id }}">Edit</a>
                          @endcan
                          @can('Hapus Loker')
                          <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete_data{{ $job_vacancy->id }}">Hapus</a>
                          @endcan
                          <!-- Edit Modal -->
                          <div class="modal fade" id="edit_data{{ $job_vacancy->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $job_vacancy->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{ $job_vacancy->id }}">Edit Data:
                                    {{ $job_vacancy->position }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <form action="{{ route('jobVacancy.update', $job_vacancy->id) }}" method="POST" enctype="multipart/form-data">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                      @if($job_vacancy->pamphlet)
                                        <img src="{{ asset('storage/pamphlets/' . $job_vacancy->pamphlet) }}" id="outputUpdate" style="width: 90px; height: 90px; object-fit: cover; " />
                                      @else
                                        <img id="outputUpdate" style="width: 90px; height: 90px; object-fit: cover;" />
                                      @endif
                                    </div>
                                    <div class="mb-3">
                                      <label for="pamphlet" class="col-form-label">Brosur</label>
                                      <input type="file" class="form-control" id="pamphlet" name="pamphlet" accept="image/*" onchange="loadFileUpdate(event)">
                                    </div>
                                    <div class="mb-3">
                                      <label for="position" class="col-form-label">Posisi</label>
                                      <input type="text" class="form-control" id="position" name="position"
                                        value="{{ $job_vacancy->position }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="company_name" class="col-form-label">Nama Perusahaan</label>
                                      <input type="text" class="form-control" id="company_name" name="company_name"
                                        value="{{ $job_vacancy->company_name }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="description" class="col-form-label">Deskripsi</label>
                                      <textarea type="text" class="form-control" id="description" name="description">{{ $job_vacancy->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                      <label for="location" class="col-form-label">Lokasi</label>
                                      <input type="text" class="form-control" id="location" name="location"
                                        value="{{ $job_vacancy->location }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="salary" class="col-form-label">Gaji</label>
                                      <input type="text" class="form-control" id="salary" name="salary"
                                        value="{{ $job_vacancy->salary }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="dateline_date" class="col-form-label">Tanggal</label>
                                      <input type="date" class="form-control" id="dateline_date" name="dateline_date"
                                        value="{{ $job_vacancy->dateline_date }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="user_id" class="col-form-label">Guru BK</label>
                                      <select class="form-control" id="user_id" name="user_id" required>
                                        <option value="">-- Pilih Guru BK --</option>
                                        @foreach ($users as $user)
                                          @if($user->hasRole('Guru BK')) <!-- Menggunakan Spatie Role -->
                                            <option value="{{ $user->id }}" {{ $job_vacancy->user_id == $user->id ? 'selected' : '' }}>
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
                          <div class="modal fade" id="delete_data{{ $job_vacancy->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $job_vacancy->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel{{ $job_vacancy->id }}">Hapus Data:
                                    {{ $job_vacancy->position }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda yakin ingin menghapus data {{ $job_vacancy->position }}?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                  <form action="{{ route('jobVacancy.destroy', $job_vacancy->id) }}" method="POST">
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
                      <th>Brosur</th>
                      <th>Posisi</th>
                      <th>Nama Perusahaan</th>
                      <th>Deskripsi</th>
                      <th>Lokasi</th>
                      <th>Gaji</th>
                      <th>Batas Waktu</th>
                      <th>Ditambah oleh</th>
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
<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    
  }
  var loadFileUpdate = function(event) {
    var outputUpdate = document.getElementById('outputUpdate');
    outputUpdate.src = URL.createObjectURL(event.target.files[0]);
    
  }
</script>
