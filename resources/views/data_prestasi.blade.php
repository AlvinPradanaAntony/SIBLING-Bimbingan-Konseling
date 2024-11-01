@extends('layouts.dashboard')
@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Prestasi</h5>
              @can('Tambah Prestasi')
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddAchievementModal">
                Tambah Data
              </button>
              @endcan
              <div class="modal fade" id="AddAchievementModal" tabindex="-1" aria-labelledby="AddAchievementModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="AddAchievementModalLabel">Tambah Data Baru</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('achievement.store') }}" method="POST" enctype="multipart/form-data">
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
                          <label for="ranking" class="col-form-label">Peringkat</label>
                          <input type="text" class="form-control" id="ranking" name="ranking" required>
                        </div>
                        <div class="mb-3">
                          <label for="achievements_name" class="col-form-label">Kejuaraan</label>
                          <input type="text" class="form-control" id="achievements_name" name="achievements_name"
                            required>
                        </div>
                        <div class="mb-3">
                          <label for="level" class="col-form-label">Tingkat</label>
                          <select class="form-control" id="level" name="level">
                            <option value="kecamatan">Kecamatan</option>
                            <option value="kabupaten">Kabupaten</option>
                            <option value="provinsi">Provinsi</option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="type" class="col-form-label">Tipe</label>
                          <select class="form-control" id="type" name="type">
                            <option value="individu">Individu</option>
                            <option value="kelompok">Kelompok</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="date" class="col-form-label">Tanggal</label>
                          <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                          <label for="recognition" class="col-form-label">Penyelenggara</label>
                          <input type="text" class="form-control" id="recognition" name="recognition" required>
                        </div>
                        <div class="mb-3">
                          <label for="certificate" class="col-form-label">Sertifikat</label>
                          <input type="file" class="form-control" id="certificate" name="certificate" accept="image/*" onchange="loadFile(event)" required>
                        </div>
                        <div style="display: flex; justify-content: center; align-items: center;">
                          <img id="output" style="width: 90px; height: 90px; object-fit: cover;"/>
                        </div>
                        <div class="mb-3">
                          <label for="description" class="col-form-label">Deskripsi</label>
                          <textarea type="text" class="form-control" id="description" name="description" required></textarea>
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
                      <th>Peringkat</th>
                      <th>Kejuaraan</th>
                      <th>Tingkat</th>
                      <th>Tipe</th>
                      <th>Tanggal</th>
                      <th>Penyelenggara</th>
                      <th>Sertifikat</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($achievements as $achievement)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $achievement->student->name }}</td>
                        <td>{{ $achievement->ranking }}</td>
                        <td>{{ $achievement->achievements_name }}</td>
                        <td>{{ $achievement->level }}</td>
                        <td>{{ $achievement->type }}</td>
                        <td>{{ $achievement->date }}</td>
                        <td>{{ $achievement->recognition }}</td>
                        <td>{{ $achievement->certificate }}</td>
                        <td>{{ $achievement->description }}</td>
                        <td>
                          @can('Ubah Prestasi')
                          <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit_data{{ $achievement->id }}">Edit</a>
                          @endcan
                          @can('Hapus Prestasi')
                          <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete_data{{ $achievement->id }}">Hapus</a>
                          @endcan

                          <!-- Edit Modal -->
                          <div class="modal fade" id="edit_data{{ $achievement->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $achievement->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{ $achievement->id }}">Edit Data:
                                    {{ $achievement->achievements_name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <form action="{{ route('achievement.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">

                                    <div class="mb-3">
                                      <label for="student_id" class="col-form-label">Nama Siswa</label>
                                      <select class="form-control" id="user_id" name="student_id" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($students as $student)
                                          <option value="{{ $student->id }}"
                                            {{ $achievement->student_id == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }}
                                          </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="mb-3">
                                      <label for="ranking" class="col-form-label">Peringkat</label>
                                      <input type="text" class="form-control" id="ranking" name="ranking"
                                        value="{{ $achievement->ranking }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="achievements_name" class="col-form-label">Kejuaraan</label>
                                      <input type="text" class="form-control" id="achievements_name"
                                        name="achievements_name" value="{{ $achievement->achievements_name }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="level" class="col-form-label">Tingkat</label>
                                      <select class="form-control" id="level" name="level">
                                        <option value="Kecamatan" {{ isset($achievement) && $achievement->level == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                        <option value="Kabupaten" {{ isset($achievement) && $achievement->level == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                        <option value="Provinsi" {{ isset($achievement) && $achievement->level == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                        <option value="Nasional" {{ isset($achievement) && $achievement->level == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option value="Internasional" {{ isset($achievement) && $achievement->level == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                      </select>
                                    </div>

                                    <div class="mb-3">
                                      <label for="type" class="col-form-label">Tipe</label>
                                      <select class="form-control" id="type" name="type">
                                        <option value="Individu" {{ isset($achievement) && $achievement->type == 'Individu' ? 'selected' : '' }}>Individu</option>
                                        <option value="Kelompok" {{ isset($achievement) && $achievement->type == 'Kelompok' ? 'selected' : '' }}>Kelompok</option>
                                      </select>
                                    </div>
                                    <div class="mb-3">
                                      <label for="date" class="col-form-label">Tanggal</label>
                                      <input type="date" class="form-control" id="date" name="date"
                                        value="{{ $achievement->date }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="recognition" class="col-form-label">Penyelenggara</label>
                                      <input type="text" class="form-control" id="recognition" name="recognition"
                                        value="{{ $achievement->recognition }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="certificate" class="col-form-label">Sertifikat</label>
                                      <input type="file" class="form-control" id="certificate" name="certificate" accept="image/*" onchange="loadFileUpdate(event)">
                                    </div>
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                      @if($achievement->certificate)
                                        <img src="{{ asset('storage/certificates/' . $achievement->certificate) }}" id="outputUpdate" style="width: 90px; height: 90px; object-fit: cover; " />
                                      @else
                                        <img id="outputUpdate" style="width: 90px; height: 90px; object-fit: cover;" />
                                      @endif
                                    </div>
                                    <div class="mb-3">
                                      <label for="description" class="col-form-label">Deskripsi</label>
                                      <textarea type="text" class="form-control" id="description" name="description">{{ $achievement->description }}</textarea>
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
                          <div class="modal fade" id="delete_data{{ $achievement->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $achievement->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel{{ $achievement->id }}">Hapus Data:
                                    {{ $achievement->achievements_name }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda yakin ingin menghapus data {{ $achievement->name }}?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                  <form action="{{ route('achievement.destroy', $achievement->id) }}" method="POST">
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
                      <th>Nama</th>
                      <th>Peringkat</th>
                      <th>Kejuaraan</th>
                      <th>Tingkat</th>
                      <th>Tipe</th>
                      <th>Tanggal</th>
                      <th>Penyelenggara</th>
                      <th>Sertifikat</th>
                      <th>Deskripsi</th>
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