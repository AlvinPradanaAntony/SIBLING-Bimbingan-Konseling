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
                Tambah
              </button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importKarirModal">
                Import
              </button>
              <a href="{{ route('jobVacancy.export') }}" class="btn btn-success">
                Ekspor
              </a>
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
                        <div class="mb-3">
                          <label for="pamphlet" class="col-form-label">Unggah Brosur</label>
                          <input type="file" class="form-control" id="pamphlet" name="pamphlet" accept=".pdf,.jpg,.png">
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
                          <label for="link" class="col-form-label">Link</label>
                          <input type="text" class="form-control" id="link" name="link">
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
              <!-- Import Modal -->
              <div class="modal fade" id="importKarirModal" tabindex="-1" aria-labelledby="importKarirModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="importKarirModalLabel">Import Data Karir</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('jobVacancy.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                          <label for="file" class="form-label">Pilih File Excel</label>
                          <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="dt-container">
              <div class="row mt-2 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto"></div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto"></div>
              </div>
            </div>
            <div class="row ">
              <div class="col-lg-12">
                <div class="card border-0 shadowNavbar" id="panel">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="example" class="table table-hover" style="width:100%; --bs-table-bg: white;">
                        <thead class="text-nowrap table-light rounded-header"
                          style="--bs-table-bg: #eef2f7; --bs-table-border-color: #eef2f7;">
                          <tr>
                            <th>No</th>
                            <th>Brosur</th>
                            <th>Posisi</th>
                            <th>Nama Perusahaan</th>
                            <th>Deskripsi</th>
                            <th>Lokasi</th>
                            <th>Gaji</th>
                            <th>Batas Waktu</th>
                            <th>Link</th>
                            <th>Ditambah oleh</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($job_vacancies as $job_vacancy)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>
                                @if ($job_vacancy->pamphlet)
                                  @php
                                    $fileType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $job_vacancy->pamphlet);
                                  @endphp
                                  @if ($fileType === 'application/pdf')
                                    <i class="uil uil-file-alt" style="font-size: 50px; color: red; margin-bottom: 10px;"></i>
                                  @else
                                    <img src="{{ route('jobVacancy.showImage', $job_vacancy->id) }}" alt="Brosur" style="max-width: 100px; max-height: 100px; margin-bottom: 10px;">
                                  @endif
                                  <a href="{{ route('jobVacancy.download', $job_vacancy->id) }}" class="btn btn-primary btn-sm">
                                    <i class="uil uil-download-alt"></i> Unduh
                                  </a>
                                @else
                                  Tidak ada brosur
                                @endif
                              </td>
                              <td>{{ $job_vacancy->position }}</td>
                              <td>{{ $job_vacancy->company_name }}</td>
                              <td>{{ $job_vacancy->description }}</td>
                              <td>{{ $job_vacancy->location }}</td>
                              <td>{{ $job_vacancy->salary }}</td>
                              <td>{{ $job_vacancy->dateline_date }}</td>
                              <td>{{ $job_vacancy->link }}</td>
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
                                          <div class="mb-3">
                                            <label for="pamphlet" class="col-form-label">Unggah Brosur</label>
                                              @if ($job_vacancy->pamphlet)
                                                <div class="mb-2">
                                                  <p>File yang sudah ada:</p>
                                                  @php
                                                      $fileType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $job_vacancy->pamphlet);
                                                  @endphp
                                                  @if (str_contains($fileType, 'image'))
                                                      <img src="{{ route('jobVacancy.showImage', $job_vacancy->id) }}" alt="Brosur" style="max-width: 100px; max-height: 100px; margin-bottom: 10px;">
                                                  @elseif ($fileType === 'application/pdf')
                                                      <i class="uil uil-file-pdf-alt" style="font-size: 50px;"></i>
                                                  @else
                                                      <i class="uil uil-file-alt" style="font-size: 50px;"></i>
                                                  @endif
                                                  <br>
                                                  <a href="{{ route('jobVacancy.download', $job_vacancy->id) }}" class="btn btn-sm btn-primary mt-2">Download Brosur</a>
                                                </div>
                                                <p class="text-muted">Jika tidak ingin mengganti file, biarkan kosong.</p>
                                              @else
                                                <p class="text-danger">Belum ada Brosur yang diunggah.</p>
                                              @endif
                                            <input type="file" class="form-control" id="pamphlet" name="pamphlet" accept=".pdf,.jpg,.png">
                                          </div>
                                          <div class="mb-3">
                                            <label for="position" class="col-form-label">Posisi</label>
                                            <input type="text" class="form-control" id="position" name="position"
                                              value="{{ $job_vacancy->position }}" required>
                                          </div>
                                          <div class="mb-3">
                                            <label for="company_name" class="col-form-label">Nama Perusahaan</label>
                                            <input type="text" class="form-control" id="company_name" name="company_name"
                                              value="{{ $job_vacancy->company_name }}" required>
                                          </div>
                                          <div class="mb-3">
                                            <label for="description" class="col-form-label">Deskripsi</label>
                                            <textarea type="text" class="form-control" id="description" name="description" required>{{ $job_vacancy->description }}</textarea>
                                          </div>
                                          <div class="mb-3">
                                            <label for="location" class="col-form-label">Lokasi</label>
                                            <input type="text" class="form-control" id="location" name="location"
                                              value="{{ $job_vacancy->location }}" required>
                                          </div>
                                          <div class="mb-3">
                                            <label for="salary" class="col-form-label">Gaji</label>
                                            <input type="text" class="form-control" id="salary" name="salary"
                                              value="{{ $job_vacancy->salary }}" required>
                                          </div>
                                          <div class="mb-3">
                                            <label for="dateline_date" class="col-form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="dateline_date" name="dateline_date"
                                              value="{{ $job_vacancy->dateline_date }}" required>
                                          </div>
                                          <div class="mb-3">
                                            <label for="link" class="col-form-label">Link</label>
                                            <input type="text" class="form-control" id="link" name="link"
                                              value="{{ $job_vacancy->link }}">
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
                            <th>Link</th>
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
