@extends('layouts.dashboard')

@section('content')
  <div>
    <div class="d-flex my-2 align-items-center">
      <h4 class="m-0 flex-grow-1" style="font-family: NunitoSans-ExtraBold; color: var(--title-color);line-height: 75px;">
        Data Siswa</h4>
      {{-- <a href="" class="btn btn-primary"><i class="uil uil-plus me-2"></i>Tambah Data</a> --}}

      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        Tambah Data
      </button>
      <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addStudentModalLabel">Tambah Data Baru</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <!-- Field Nama -->
              <div style="display: flex; justify-content: center; align-items: center;">
                <img id="output" style="width: 90px; height: 90px; object-fit: cover;"/>
              </div>
              <div class="mb-3">
                <label for="photo" class="col-form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="loadFile(event)" required>
              </div>
              <div class="mb-3">
                <label for="nisn" class="col-form-label">NISN</label>
                <input type="text" class="form-control" id="nisn" name="nisn" required>
              </div>
              <div class="mb-3">
                <label for="name" class="col-form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="class_id" class="col-form-label">Kelas</label>
                <select class="form-control" id="class_id" name="class_id" required>
                  <option value="">-- Pilih Kelas --</option>
                  @foreach ($classes as $class)
                    <option value="{{ $class->id }}">
                      {{ $class->class_level }} - {{ $class->major->major_name }} - {{ $class->classroom }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="gender" class="col-form-label">Jenis Kelamin</label>
                <select class="form-control" id="gender" name="gender" required>
                  <option value="">-- Pilih Jenis Kelamin --</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="place_of_birth" class="col-form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" required>
              </div>
              <div class="mb-3">
                <label for="date_of_birth" class="col-form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
              </div>
              <div class="mb-3">
                <label for="religion" class="col-form-label">Agama</label>
                <select class="form-control" id="religion" name="religion" required>
                  <option value="">-- Pilih Agama --</option>
                  <option value="Islam">Islam</option>
                  <option value="Kristen">Kristen</option>
                  <option value="Katholik">Katholik</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Budha">Budha</option>
                  <option value="Konghucu">Konghucu</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="phone_number" class="col-form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
              </div>
              <div class="mb-3">
                <label for="address" class="col-form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="admission_date" class="col-form-label">Tanggal Masuk</label>
                <input type="date" class="form-control" id="admission_date" name="admission_date" required>
              </div>
              <div class="mb-3">
                <label for="guardian_name" class="col-form-label">Nama Wali</label>
                <input type="text" class="form-control" id="guardian_name" name="guardian_name" required>
              </div>
              <div class="mb-3">
                <label for="guardian_phone_number" class="col-form-label">Nomor Wali</label>
                <input type="text" class="form-control" id="guardian_phone_number" name="guardian_phone_number" required>
              </div>
              <div class="mb-3">
                <label for="status_id" class="col-form-label">Status</label>
                <select class="form-control" id="status_id" name="status_id" required>
                  <option value="">-- Pilih Status --</option>
                  @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                  <label for="email" class="col-form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
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

    <div class="dt-container">
      <div class="row mt-2 justify-content-between">
        <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto"></div>
        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto"></div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card border-0 shadowNavbar" id="panel">
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-hover student" style="width:100%; --bs-table-bg: white;">
                <thead class="text-nowrap table-light rounded-header"
                  style="--bs-table-bg: #eef2f7; --bs-table-border-color: #eef2f7;">
                  <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>Foto</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
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
                  </tr>
                </thead>
                <tbody>
                  @foreach ($students as $student)
                    <tr style="font-size: 14px">
                      <td>{{ $loop->iteration }}</td>
                      <td>
                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                          data-bs-target="#edit_data{{ $student->id }}">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                          data-bs-target="#delete_data{{ $student->id }}">Hapus</a>
                        <button class="btn btn-dark btn-sm">Tinjau</button>
    
                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit_data{{ $student->id }}" tabindex="-1"
                          aria-labelledby="editModalLabel{{ $student->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $student->id }}">Edit Data:
                                  {{ $student->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                  <div style="display: flex; justify-content: center; align-items: center;">
                                    <img id="outputUpdate" src="{{ asset('storage/student_photos/' . $student->photo) }}" style="width: 90px; height: 90px; object-fit: cover;"/>
                                  </div>
                                  <div class="mb-3">
                                    <label for="photo" class="col-form-label">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="loadFileUpdate(event)">
                                  </div>
                                  <div class="mb-3">
                                    <label for="nisn" class="col-form-label">NISN</label>
                                    <input type="text" class="form-control" id="nisn" name="nisn" value="{{ $student->nisn }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="name" class="col-form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="class_id" class="col-form-label">Kelas</label>
                                    <select class="form-control" id="class_id" name="class_id" required>
                                      <option value="">-- Pilih Kelas --</option>
                                      @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ $class->id == $student->class_id ? 'selected' : '' }}>
                                          {{ $class->class_level }} - {{ $class->major->major_name }} - {{ $class->classroom }}
                                        </option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="gender" class="col-form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                      <option value="">-- Pilih Jenis Kelamin --</option>
                                      <option value="Laki-laki" {{ $student->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                      <option value="Perempuan" {{ $student->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="place_of_birth" class="col-form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ $student->place_of_birth }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="date_of_birth" class="col-form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $student->date_of_birth }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="religion" class="col-form-label">Agama</label>
                                    <select class="form-control" id="religion" name="religion" required>
                                      <option value="">-- Pilih Agama --</option>
                                      <option value="Islam" {{ $student->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
                                      <option value="Kristen" {{ $student->religion == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                      <option value="Katholik" {{ $student->religion == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                      <option value="Hindu" {{ $student->religion == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                      <option value="Budha" {{ $student->religion == 'Budha' ? 'selected' : '' }}>Budha</option>
                                      <option value="Konghucu" {{ $student->religion == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="phone_number" class="col-form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $student->phone_number }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="address" class="col-form-label">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ $student->address }}</textarea>
                                  </div>
                                  <div class="mb-3">
                                    <label for="admission_date" class="col-form-label">Tanggal Masuk</label>
                                    <input type="date" class="form-control" id="admission_date" name="admission_date" value="{{ $student->admission_date }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="guardian_name" class="col-form-label">Nama Wali</label>
                                    <input type="text" class="form-control" id="guardian_name" name="guardian_name" value="{{ $student->guardian_name }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="guardian_phone_number" class="col-form-label">Nomor Wali</label>
                                    <input type="text" class="form-control" id="guardian_phone_number" name="guardian_phone_number" value="{{ $student->guardian_phone_number }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="status_id" class="col-form-label">Status</label>
                                    <select class="form-control" id="status_id" name="status_id" required>
                                      <option value="">-- Pilih Status --</option>
                                      @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $status->id == $student->status_id ? 'selected' : '' }}>
                                          {{ $status->status_name }}
                                        </option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="email" class="col-form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                  <button type="submit" class="btn btn-primary">Simpan</button>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                Apakah Anda yakin ingin menghapus data {{ $student->name }}?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="{{ route('student.destroy', $student->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <img src="{{ $student->photo ? asset('storage/student_photos/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=random'}}" 
                          alt="photo" class="img-fluid rounded"
                          style="width: 100px; height: 100px; cursor: pointer;" 
                          onclick="showFullscreen(this.src)">
                      </td>
                      <td>{{ $student->nisn }}</td>
                      <td>{{ $student->name }}</td>
                      <td>{{ $student->class->class_level . ' ' . $student->class->major->major_name . ' ' . $student->class->classroom }}</td>
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
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="row mt-2 justify-content-between">
              <div class="d-md-flex justify-content-between align-items-center dt-custom-info col-md-auto me-auto"></div>
              <div class="d-md-flex justify-content-between align-items-center dt-custom-paging col-md-auto ms-auto"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadowNavbar" id="panel">
          <div class="card-body">
            <div class="mb-3 text-center">
              <img src="{{ $student->photo ? asset('storage/student_photos/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name). '&background=random' }}" class="rounded-circle" alt="Student Photo" width="80" height="80">
            </div>
            <h5 class="card-title text-center m-0" style="font-weight: var(--font-extra-bold); color: var(--title-color)">{{ $student->name }}</h5>
            <p class="text-center" style="font-size: var(--small-font-size); color: var(--text-color-light)">{{ $student->class->class_level}} <span>{{ $student->class->major->major_name }}</span></p>
            <ul class="list-group list-group-flush" style="font-size: var(--small-font-size); --bs-list-group-bg: transparent;">
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">NISN :</span><strong>{{ $student->nisn }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Nama :</span><strong>{{ $student->name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Kelas :</span><strong>{{ $student->class->class_level . ' ' . $student->class->major->major_name . ' ' . $student->class->classroom }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Jenis Kelamin :</span><strong>{{ $student->gender }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Tempat Lahir :</span><strong>{{ $student->place_of_birth }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Tanggal Lahir :</span><strong>{{ $student->date_of_birth }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Agama :</span><strong>{{ $student->religion }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Nomor Telepon :</span><strong>{{ $student->phone_number }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Alamat :</span><strong>{{ $student->address }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Wali :</span><strong>{{ $student->guardian_name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">No Wali :</span><strong>{{ $student->guardian_phone_number }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Email :</span><strong>{{ $student->email }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Status :</span><strong>{{ $student->status->status_name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Tanggal Masuk :</span><strong>{{ $student->admission_date }}</strong></li>
            </ul>
          </div>
        </div>

        
      </div>
        
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