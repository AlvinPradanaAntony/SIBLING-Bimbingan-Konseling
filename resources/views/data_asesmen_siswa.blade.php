@extends('layouts.dashboard')
@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h5 class="m-0 text-primary">Tabel Data Asesmen</h5>
              @can('Tambah Asesmen Siswa')
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentAssessmentModal">
                Tambah
              </button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importAsesmenSiswaModal">
                Import
              </button>
              <a href="{{ route('student_assessment.export') }}" class="btn btn-success">
                Ekspor
              </a>
              @endcan
              <div class="modal fade" id="addStudentAssessmentModal" tabindex="-1" aria-labelledby="addStudentAssessmentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addStudentAssessmentModalLabel">Tambah Asesmen Baru</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('student_assessment.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="student_id" class="col-form-label">Nama Siswa</label>
                          <select class="form-control" id="student_id" name="student_id" required>
                            <option value="">-- Pilih Nama Siswa --</option>
                            @foreach ($students as $student)
                              <option value="{{ $student->id }}" {{ $student->id == $student->student_id ? 'selected' : '' }}>
                                {{ $student->name }}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        @foreach ($assessments as $assessment)
                          <div class="mb-3">
                            <label for="question_{{ $assessment->id }}" class="col-form-label">{{ $assessment->question }}</label>
                            <div class="d-flex">
                              <input type="radio" id="question_{{ $assessment->id }}_iya" name="answers[{{ $assessment->id }}]" value="1" required>
                              <label for="question_{{ $assessment->id }}_iya" class="ms-2">Iya</label>
                              <div class="ms-3"></div> <!-- Menambahkan jarak -->
                              <input type="radio" id="question_{{ $assessment->id }}_tidak" name="answers[{{ $assessment->id }}]" value="0" required>
                              <label for="question_{{ $assessment->id }}_tidak" class="ms-2">Tidak</label>
                            </div>
                          </div>
                        @endforeach
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
              <div class="modal fade" id="importAsesmenSiswaModal" tabindex="-1" aria-labelledby="importAsesmenSiswaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="importAsesmenSiswaModalLabel">Import Data Asesmen Siswa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('student_assessment.import') }}" method="POST" enctype="multipart/form-data">
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
                            <th>Kelas</th>
                            <th>Nama Siswa</th>
                            @foreach ($assessments as $assessment)
                              <th>{{ $assessment->id }}</th>
                            @endforeach
                            <th>Total</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                            $totalScores = array_fill(0, count($assessments), 0); // Array untuk menyimpan total skor setiap assessment
                            $overallTotalScore = 0; // Variabel untuk menyimpan total skor keseluruhan
                            $fieldTotals = []; // Array untuk menyimpan total skor per field
                          @endphp
                          @foreach ($students as $student)
                            @if ($student->student_assessments()->whereNotNull('answer')->exists())
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->class->class_level . ' ' . $student->class->major->major_name . ' ' . $student->class->classroom }}</td>
                                <td>{{ $student->name }}</td>
                                @php $studentTotalScore = 0; @endphp
                                @foreach ($assessments as $key => $assessment)
                                  @php
                                    $student_assessment = $student->student_assessments()->where('assessment_id', $assessment->id)->first();
                                    $answer = $student_assessment ? $student_assessment->answer : null;
                                    if ($answer === 1) {
                                      $studentTotalScore++; // Menjumlahkan nilai 1 jika jawabannya "1"
                                      $totalScores[$key]++; // Menambahkan ke total score assessment
                                      // Menambahkan skor per field
                                      $fieldTotals[$assessment->field] = ($fieldTotals[$assessment->field] ?? 0) + 1;
                                    }
                                  @endphp
                                  <td style="background-color: 
                                    @switch($assessment->field)
                                      @case('Pribadi')
                                        #d4edda; /* hijau */
                                        @break
                                      @case('Sosial')
                                        #fff3cd; /* kuning */
                                        @break
                                      @case('Belajar')
                                        #ffeeba; /* orange */
                                        @break
                                      @case('Karir')
                                        #f8d7da; /* merah muda */
                                        @break
                                      @default
                                        transparent; /* warna default jika kategori tidak terdaftar */
                                    @endswitch
                                  ">
                                    {{ $answer === 1 ? '1' : ($answer === 0 ? '0' : '-') }}
                                  </td>
                                @endforeach
                                <td>{{ $studentTotalScore }}</td> <!-- Menampilkan total skor siswa -->
                                <td>
                                  @can('Ubah Asesmen Siswa')
                                  <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_data{{ $student->id }}">Edit</a>
                                  @endcan
                                  @can('Hapus Asesmen Siswa')
                                  <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete_data{{ $student->id }}">Hapus</a>
                                  @endcan
                                </td>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="edit_data{{ $student->id }}" tabindex="-1" aria-labelledby="edit_data{{ $student->id }}Label" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="edit_data{{ $student->id }}Label">Edit Data Asesmen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{ route('student_assessment.update', $student->id) }}" method="POST">
                                          @csrf
                                          @method('PUT')
                                          <div class="mb-3">
                                            <label for="student_id" class="col-form-label">Nama Siswa</label>
                                            <select class="form-control" id="student_id" name="student_id" required>
                                              <option value="">-- Pilih Nama Siswa --</option>
                                              @foreach ($students as $std)
                                                <option value="{{ $std->id }}" {{ $student->id == $std->id ? 'selected' : '' }}>
                                                  {{ $std->name }}
                                                </option>
                                              @endforeach
                                            </select>
                                          </div>
                                          @foreach ($assessments as $assessment)
                                            @php
                                              $student_assessment = $student->student_assessments()->where('assessment_id', $assessment->id)->first();
                                              $answer = $student_assessment ? $student_assessment->answer : null;
                                            @endphp
                                            <div class="mb-3">
                                              <label for="question_{{ $assessment->id }}" class="col-form-label">{{ $assessment->question }}</label>
                                              <div class="d-flex">
                                                <input type="radio" id="question_{{ $assessment->id }}_iya" name="answers[{{ $assessment->id }}]" value="1" {{ $answer === 1 ? 'checked' : '' }} required>
                                                <label for="question_{{ $assessment->id }}_iya" class="ms-2">Iya</label>
                                                <div class="ms-3"></div> <!-- Menambahkan jarak -->
                                                <input type="radio" id="question_{{ $assessment->id }}_tidak" name="answers[{{ $assessment->id }}]" value="0" {{ $answer === 0 ? 'checked' : '' }} required>
                                                <label for="question_{{ $assessment->id }}_tidak" class="ms-2">Tidak</label>
                                              </div>
                                            </div>
                                          @endforeach
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="modal fade" id="delete_data{{ $student->id }}" tabindex="-1" aria-labelledby="delete_data{{ $student->id }}Label" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="delete_data{{ $student->id }}Label">Hapus Data Asesmen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus semua data asesmen untuk <strong>{{ $student->name }}</strong>?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('student_assessment.destroy', $student->id) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </tr>
                              @php
                                $overallTotalScore += $studentTotalScore; // Menjumlahkan total skor siswa ke dalam total keseluruhan
                              @endphp
                            @endif
                          @endforeach
                        </tbody>
                          <tfoot style="background-color: #007bff; color: white;">
                            <tr>
                              <th colspan="3" style="text-align: right;">Jumlah Konseli</th>
                              @foreach ($assessments as $key => $assessment)
                                <th>{{ $totalScores[$key] }}</th> <!-- Menampilkan total untuk setiap assessment -->
                              @endforeach
                              <th>{{ $overallTotalScore }}</th> <!-- Menampilkan total keseluruhan -->
                              <th></th>
                            </tr>
                            <tr>
                              <th colspan="3" style="text-align: right;">Persentase Butir</th>
                              @foreach ($totalScores as $score)
                                <th>
                                  @if ($overallTotalScore > 0) <!-- Menghindari pembagian dengan nol -->
                                    {{ number_format(($score / $overallTotalScore) * 100, 2) }}%
                                  @else
                                    0%
                                  @endif
                                </th>
                              @endforeach
                              <th>100%</th> <!-- Kolom Aksi dibiarkan kosong -->
                            </tr>
                            <tr>
                              <th colspan="3" style="text-align: right;">Jumlah per Bidang</th>
                              @php
                                $fieldTotal = array_sum($fieldTotals);
                              @endphp
                              @foreach (['Pribadi', 'Sosial', 'Belajar', 'Karir'] as $field)
                                @php
                                  $fieldCount = count(array_filter($assessments->toArray(), fn($a) => $a['field'] === $field));
                                @endphp
                                <th colspan="{{ $fieldCount }}" style="text-align: center;">
                                  {{ $fieldTotals[$field] ?? 0 }}
                                </th>
                              @endforeach
                              <th>{{ $fieldTotal }}</th>
                              <th></th>
                            </tr>
                            <!-- Persentase per Field -->
                            @php
                              $overallTotalScore = array_sum($fieldTotals);
                            @endphp
                            <tr>
                              <th colspan="3" style="text-align: right;">Persentase per Bidang</th>
                              @foreach (['Pribadi', 'Sosial', 'Belajar', 'Karir'] as $field)
                                @php
                                  $fieldPercentage = $fieldTotal > 0 ? ($fieldTotals[$field] ?? 0) / $fieldTotal * 100 : 0;
                                  $fieldCount = count(array_filter($assessments->toArray(), fn($a) => $a['field'] === $field));
                                @endphp
                                <th colspan="{{ $fieldCount }}" style="text-align: center;">
                                  {{ number_format($fieldPercentage, 2) }}%
                                </th>
                              @endforeach
                              <th>100%</th>
                              <th></th>
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
