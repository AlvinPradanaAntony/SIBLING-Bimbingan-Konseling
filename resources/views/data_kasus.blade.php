@extends('layouts.dashboard')
@section('content')
<style>
    /* Styling untuk membuat elemen sejajar */
    .form-inline {
        display: flex;
        flex-wrap: nowrap; /* Memastikan elemen tetap dalam satu baris */
        gap: 15px; /* Jarak antar elemen */
        align-items: center;
    }

    .form-inline .form-group {
        flex: 1; /* Membuat elemen menyesuaikan lebar */
        min-width: 200px; /* Lebar minimum dropdown */
    }
</style>
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Kasus</h5>
              <div class="row filter-row">
                <form method="GET" action="{{ route('case.index') }}" class="form-inline">
                    <div class="col-12 col-sm-6 col-md-3">
                        <select name="class" class="form-select">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_level }} {{ $class->major->major_name }} {{ $class->classroom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                        <select name="month" class="form-select">
                            <option value="01" {{ $selectedMonth == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ $selectedMonth == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ $selectedMonth == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ $selectedMonth == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ $selectedMonth == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ $selectedMonth == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ $selectedMonth == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ $selectedMonth == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ $selectedMonth == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ $selectedMonth == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ $selectedMonth == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ $selectedMonth == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                        <select name="year" class="form-select">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="uil uil-search"></i>
                    </button>
                </form>
              </div>
              @can('Tambah Kasus')
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Tambah
              </button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importKasusModal">
                Import
              </button>
              <a href="{{ route('case.export') }}" class="btn btn-success">
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
                      <form action="{{ route('case.store') }}" method="POST" enctype="multipart/form-data">
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
                          <label for="evidence" class="col-form-label">Unggah Bukti Kasus</label>
                          <input type="file" class="form-control" id="evidence" name="evidence" accept=".pdf,.jpg,.png">
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
              <div class="modal fade" id="importKasusModal" tabindex="-1" aria-labelledby="importKasusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="importKasusModalLabel">Import Data Kasus</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('case.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                          <label for="file" class="form-label">Pilih File Excel</label>
                          <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="mb-3">
                          <a href="{{ route('case.download_format') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download"></i> Download Format Excel
                          </a>
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
                            <th>Nama Siswa</th>
                            <th>Kasus</th>
                            <th>Poin Kasus</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Solusi</th>
                            <th>Bukti Kasus</th>
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
                              <td>
                                @if ($case->evidence)
                                  @php
                                    $fileType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $case->evidence);
                                  @endphp
                                  @if ($fileType === 'application/pdf')
                                    <i class="uil uil-file-alt" style="font-size: 50px; color: red; margin-bottom: 10px;"></i>
                                  @else
                                    <img src="{{ route('case.showImage', $case->id) }}" alt="Bukti Kasus" style="max-width: 100px; max-height: 100px; margin-bottom: 10px;">
                                  @endif
                                  <a href="{{ route('case.download', $case->id) }}" class="btn btn-primary btn-sm">
                                    <i class="uil uil-download-alt"></i> Unduh
                                  </a>
                                @else
                                  Tidak ada bukti
                                @endif
                              </td>
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
                                      <form action="{{ route('case.update', $case->id) }}" method="POST" enctype="multipart/form-data">
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
                                            <label for="evidence" class="col-form-label">Unggah Bukti Kasus</label>
                                              @if ($case->evidence)
                                                <div class="mb-2">
                                                  <p>File yang sudah ada:</p>
                                                  @php
                                                      $fileType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $case->evidence);
                                                  @endphp
                                                  @if (str_contains($fileType, 'image'))
                                                      <img src="{{ route('case.showImage', $case->id) }}" alt="Bukti Kasus" style="max-width: 100px; max-height: 100px; margin-bottom: 10px;">
                                                  @elseif ($fileType === 'application/pdf')
                                                      <i class="uil uil-file-pdf-alt" style="font-size: 50px;"></i>
                                                  @else
                                                      <i class="uil uil-file-alt" style="font-size: 50px;"></i>
                                                  @endif
                                                  <br>
                                                  <a href="{{ route('case.download', $case->id) }}" class="btn btn-sm btn-primary mt-2">Download Bukti</a>
                                                </div>
                                                <p class="text-muted">Jika tidak ingin mengganti file, biarkan kosong.</p>
                                              @else
                                                <p class="text-danger">Belum ada bukti kasus yang diunggah.</p>
                                              @endif
                                            <input type="file" class="form-control" id="evidence" name="evidence" accept=".pdf,.jpg,.png">
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
                            <th>Bukti Kasus</th>
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
