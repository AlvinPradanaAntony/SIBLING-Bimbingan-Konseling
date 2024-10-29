@extends('layouts.dashboard')

@section('content')
  <div>
    <div class="d-flex my-2 align-items-center">
      <h4 class="m-0 flex-grow-1" style="font-family: NunitoSans-ExtraBold; color: var(--title-color);line-height: 75px;">
        Data Siswa</h4>
      <a href="{{ route('student.create') }}" class="btn btn-primary"><i class="uil uil-plus me-2"></i>Tambah Data</a>
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
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                Apakah Anda yakin ingin menghapus data {{ $student->name }}?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
              <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" class="rounded-circle" alt="Student Photo" width="80" height="80">
            </div>
            <h5 class="card-title text-center m-0" style="font-weight: var(--font-extra-bold); color: var(--title-color)">{{ $student->name }}</h5>
            <p class="text-center" style="font-size: var(--small-font-size); color: var(--text-color-light)">{{ $student->class->class_level}} <span>{{ $student->class->major->major_name }}</span></p>
            <ul class="list-group list-group-flush" style="font-size: var(--small-font-size); --bs-list-group-bg: transparent;">
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">NISN :</span><strong>{{ $student->nisn }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Nama :</span><strong>{{ $student->name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between border-0"><span class="mb-0">Kelas :</span><strong>{{ $student->class->class_level }}</strong></li>
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
