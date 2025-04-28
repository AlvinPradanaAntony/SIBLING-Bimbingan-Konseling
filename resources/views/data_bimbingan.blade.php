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
              <h5 class="m-0 text-primary">Tabel Data Bimbingan</h5>
              <div class="row filter-row">
                <form method="GET" action="{{ route('guidance.index') }}" class="form-inline">
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
                    {{-- <div class="col-6 col-sm-4 col-md-2">
                        <button type="submit" class="btn btn-success w-100"> Search </button>
                    </div> --}}
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="uil uil-search"></i>
                    </button>
                </form>
              </div>
              @can('Tambah Bimbingan')
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Tambah
              </button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importBimbinganModal">
                Import
              </button>
              <a href="{{ route('guidance.export') }}" class="btn btn-success">
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
                      <form action="{{ route('guidance.store') }}" method="POST" enctype="multipart/form-data">
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
                              @if($user->hasRole('Guru BK'))
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="notes" class="col-form-label">Catatan</label>
                          <textarea type="text" class="form-control" id="notes" name="notes" required></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="proof_of_guidance" class="col-form-label">Unggah Bukti Bimbingan</label>
                          <input type="file" class="form-control" id="proof_of_guidance" name="proof_of_guidance" accept=".pdf,.jpg,.png">
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
              <div class="modal fade" id="importBimbinganModal" tabindex="-1" aria-labelledby="importBimbinganModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="importBimbinganModalLabel">Import Data Bimbingan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('guidance.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                          <label for="file" class="form-label">Pilih File Excel</label>
                          <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="mb-3">
                          <a href="{{ route('guidance.download_format') }}" class="btn btn-sm btn-success">
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
                            <th>Topik</th>
                            <th>Tanggal</th>
                            <th>Guru BK</th>
                            <th>Catatan</th>
                            <th>Bukti Bimbingan</th>
                            <th>Bimbingan Ke</th>
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
                                @if ($guidance->proof_of_guidance)
                                  @php
                                    $fileType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $guidance->proof_of_guidance);
                                  @endphp
                                  @if ($fileType === 'application/pdf')
                                    <i class="uil uil-file-alt" style="font-size: 50px; color: red; margin-bottom: 10px;"></i>
                                  @else
                                    <img src="{{ route('guidance.showImage', $guidance->id) }}" alt="Bukti Bimbingan" style="max-width: 100px; max-height: 100px; margin-bottom: 10px;">
                                  @endif
                                  <a href="{{ route('guidance.download', $guidance->id) }}" class="btn btn-primary btn-sm">
                                    <i class="uil uil-download-alt"></i> Unduh
                                  </a>
                                @else
                                  Tidak ada bukti
                                @endif
                              </td>
                              <td>{{ $guidance->guidance_count }}</td>
                              <td>
                                @can('Ubah Bimbingan')
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                  data-bs-target="#edit_data{{ $guidance->id }}">Edit</a>
                                @endcan
                                @can('Hapus Bimbingan')
                                <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                  data-bs-target="#delete_data{{ $guidance->id }}">Hapus</a>
                                @endcan
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
                                      <form action="{{ route('guidance.update', $guidance->id) }}" method="POST" enctype="multipart/form-data">
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
                                                @if($user->hasRole('Guru BK')) <!-- Menggunakan Spatie Role -->
                                                  <option value="{{ $user->id }}" {{ $guidance->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                  </option>
                                                @endif
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="mb-3">
                                            <label for="notes" class="col-form-label">Catatan</label>
                                            <textarea class="form-control" id="notes" name="notes">{{ $guidance->notes }}</textarea>
                                          </div>
                                          <div class="mb-3">
                                            <label for="proof_of_guidance" class="col-form-label">Unggah Bukti Bimbingan</label>
                                              @if ($guidance->proof_of_guidance)
                                                <div class="mb-2">
                                                  <p>File yang sudah ada:</p>
                                                  @php
                                                      $fileType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $guidance->proof_of_guidance);
                                                  @endphp
                                                  @if (str_contains($fileType, 'image'))
                                                      <img src="{{ route('guidance.showImage', $guidance->id) }}" alt="Bukti Bimbingan" style="max-width: 100px; max-height: 100px; margin-bottom: 10px;">
                                                  @elseif ($fileType === 'application/pdf')
                                                      <i class="uil uil-file-pdf-alt" style="font-size: 50px;"></i>
                                                  @else
                                                      <i class="uil uil-file-alt" style="font-size: 50px;"></i>
                                                  @endif
                                                  <br>
                                                  <a href="{{ route('guidance.download', $guidance->id) }}" class="btn btn-sm btn-primary mt-2">Download Bukti</a>
                                                </div>
                                                <p class="text-muted">Jika tidak ingin mengganti file, biarkan kosong.</p>
                                              @else
                                                <p class="text-danger">Belum ada bukti bimbingan yang diunggah.</p>
                                              @endif
                                            <input type="file" class="form-control" id="proof_of_guidance" name="proof_of_guidance" accept=".pdf,.jpg,.png">
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
                            <th>Bukti Bimbingan</th>
                            <th>Bimbingan Ke</th>
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
