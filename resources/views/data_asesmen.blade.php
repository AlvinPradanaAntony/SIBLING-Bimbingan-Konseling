@extends('layouts.dashboard')
@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Asesmen</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssessmentModal">
                Tambah Asesmen
              </button>
              <div class="modal fade" id="addAssessmentModal" tabindex="-1" aria-labelledby="addAssessmentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addAssessmentModalLabel">Tambah Asesmen Baru</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('assessment.store') }}" method="POST">
                        @csrf
                        <!-- Field Nama -->
                        <div class="mb-3">
                          <label for="question" class="col-form-label">Pertanyaan</label>
                          <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                        <div class="mb-3">
                          <label for="field" class="col-form-label">Pilih Bidang</label>
                          <select class="form-select" id="field" name="field" required>
                            <option value="" disabled selected>-- Pilih Bidang--</option>
                            <option value="Pribadi">Pribadi</option>
                            <option value="Sosial">Sosial</option>
                            <option value="Belajar">Belajar</option>
                            <option value="Karir">Karir</option>
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
                      <th>Pertanyaan</th>
                      <th>Bidang</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($assessments as $assessment)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $assessment->question }}</td>
                        <td>{{ $assessment->field }}</td>
                        <td>
                          <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit_data{{ $assessment->id }}">Edit</a>
                          <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete_data{{ $assessment->id }}">Hapus</a>

                          <!-- Edit Modal -->
                          <div class="modal fade" id="edit_data{{ $assessment->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $assessment->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{ $assessment->id }}">Edit Data:
                                    {{ $assessment->question }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <form action="{{ route('assessment.update', $assessment->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">

                                    <div class="mb-3">
                                      <label for="question" class="col-form-label">Pertanyaan</label>
                                      <input type="text" class="form-control" id="question" name="question"
                                        value="{{ $assessment->question }}">
                                    </div>
                                    <div class="mb-3">
                                      <label for="field" class="col-form-label">Pilih Bidang</label>
                                      <select class="form-select" id="field" name="field" required>
                                        <option value="" disabled {{ !$assessment->field ? 'selected' : '' }}>-- Pilih Bidang --</option>
                                        <option value="Pribadi" {{ $assessment->field === 'Pribadi' ? 'selected' : '' }}>Pribadi</option>
                                        <option value="Sosial" {{ $assessment->field === 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                        <option value="Belajar" {{ $assessment->field === 'Belajar' ? 'selected' : '' }}>Belajar</option>
                                        <option value="Karir" {{ $assessment->field === 'Karir' ? 'selected' : '' }}>Karir</option>
                                      </select>
                                    </div>
                                    <!-- Add more fields as needed -->

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                      data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>

                          <!-- Delete Modal -->
                          <div class="modal fade" id="delete_data{{ $assessment->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $assessment->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel{{ $assessment->id }}">Hapus Data:
                                    {{ $assessment->question }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda yakin ingin menghapus data {{ $assessment->question }}?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                  <form action="{{ route('assessment.destroy', $assessment->id) }}" method="POST">
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
                      <th>Pertanyaan</th>
                      <th>Bidang</th>
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