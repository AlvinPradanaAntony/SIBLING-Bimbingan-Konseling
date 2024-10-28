@extends('layouts.dashboard')
@section('content')
  <div>
    <h4 class="my-2" style="font-family: NunitoSans-ExtraBold; color: var(--title-color);line-height: 75px;">Data Rekap Absensi</h4>
    <div class="card border-0 shadowNavbar" id="panel">
      <div class="card-body">
        <div class="row mt-2 mb-2">
          <div class="col-sm-4">
            <div id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="btn btn-outline-primary active"  id="v-pills-simple-tab" data-bs-toggle="pill" data-bs-target="#v-pills-simple" type="button" role="tab" aria-controls="v-pills-simple" aria-selected="true">Simple</button>
              <button class="btn btn-outline-primary" id="v-pills-tables-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tables" type="button" role="tab" aria-controls="v-pills-tables" aria-selected="false">Tabel</button>
            </div>
          </div>
          <div class="col-sm-8">
              <div class="text-sm-end">
                  <button type="button" class="btn btn-success mb-2 me-1">Import</button>
                  <button type="button" class="btn btn-secondary mb-2">Export</button>
              </div>
          </div><!-- end col-->
      </div>

      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-simple" role="tabpanel" aria-labelledby="v-pills-simple-tab" tabindex="0">
          @include('partials.grid_absensi')
        </div>
        <div class="tab-pane fade" id="v-pills-tables" role="tabpanel" aria-labelledby="v-pills-tables-tab" tabindex="0">
          <div class="table-responsive">
            <table id="example" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>Tanggal</th>
                  <th>Status Kehadiran</th>
                  <th>Keterangan</th>
                  <th>Wali Kelas</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($attendances as $attendance)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->student->name }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->presence_status }}</td>
                    <td>{{ $attendance->description }}</td>
                    <td>{{ $attendance->user->name }}</td>
                    <td>
                      <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#edit_data{{ $attendance->id }}">Edit</a>
                      <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#delete_data{{ $attendance->id }}">Hapus</a>

                      <!-- Edit Modal -->
                      <div class="modal fade" id="edit_data{{ $attendance->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $attendance->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel{{ $attendance->id }}">Edit Data:
                                {{ $attendance->name }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">

                                <div class="mb-3">
                                  <label for="name" class="col-form-label">Nama:</label>
                                  <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $attendance->name }}">
                                </div>
                                <div class="mb-3">
                                  <label for="email" class="col-form-label">Email:</label>
                                  <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $attendance->email }}">
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
                      <div class="modal fade" id="delete_data{{ $attendance->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel{{ $attendance->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="deleteModalLabel{{ $attendance->id }}">Hapus Data:
                                {{ $attendance->name }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Apakah Anda yakin ingin menghapus data {{ $attendance->name }}?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                              <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST">
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
                  <th>Email</th>
                  <th>Role</th>
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
@endsection
