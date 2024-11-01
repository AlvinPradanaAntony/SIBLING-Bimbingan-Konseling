@extends('layouts.dashboard')
@section('content')
<div>
    <div class="content">
        <div class="row pt-4">
            <div class="mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text-primary">Tabel Absensi Siswa</h5>
                        @can('Tambah Absensi')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
                            Tambah Absensi
                        </button>
                        @endcan
                        <!-- Modal Tambah Data Absensi Bulanan -->
                        <div class="modal fade" id="addAttendanceModal" tabindex="-1" aria-labelledby="addMonthlyAttendanceModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAttendanceModalLabel">Tambah Absensi Bulanan Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('attendance.store') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="student_id" class="form-label">Pilih Siswa</label>
                                                <select name="student_id" class="form-select" id="student_id" required>
                                                    @foreach ($students as $student)
                                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="month" class="form-label">Bulan</label>
                                                <select name="month" class="form-select" id="month" required>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="year" class="form-label">Tahun</label>
                                                <input type="number" name="year" class="form-control" id="year" required>
                                            </div>
                                            <label class="form-label">Status Kehadiran</label>
                                            <div class="mb-3">
                                                @foreach ($dates as $date)
                                                    <div class="form-check">
                                                        <label>{{ \Carbon\Carbon::parse($date['date'])->format('d') }}</label><br>
                                                        <div class="d-flex">
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Hadir" id="hadir_{{ $date['date'] }}">
                                                                <label class="form-check-label" for="hadir_{{ $date['date'] }}">Hadir</label>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Alpa" id="alpa_{{ $date['date'] }}">
                                                                <label class="form-check-label" for="alpa_{{ $date['date'] }}">Alpa</label>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Ijin" id="ijin_{{ $date['date'] }}">
                                                                <label class="form-check-label" for="ijin_{{ $date['date'] }}">Ijin</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Sakit" id="sakit_{{ $date['date'] }}">
                                                                <label class="form-check-label" for="sakit_{{ $date['date'] }}">Sakit</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Tambah Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row filter-row mt-5">
                        <form method="GET" action="{{ route('attendance.index') }}" class="form-inline">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <select name="class" class="select floating">
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                                                {{ $class->class_level }} {{ $class->major->major_name }} {{ $class->classroom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="focus-label">Pilih Kelas</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <select name="month" class="select floating">
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
                                    <label class="focus-label">Pilih Bulan</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <select name="year" class="select floating">
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <label class="focus-label">Pilih Tahun</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <button type="submit" class="btn btn-success btn-block"> Search </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" style="width:100%">
                                <thead style="background-color: #007bff; color: white;">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>L/P</th>
                                        @foreach ($dates as $date)
                                            <th>{{ \Carbon\Carbon::parse($date['date'])->format('d') }}</th>
                                        @endforeach
                                        <th>Total Hadir</th>
                                        <th>Total Alpa</th>
                                        <th>Total Ijin</th>
                                        <th>Total Sakit</th>
                                        <th>Persentase Kehadiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        @php
                                            $totalHadir = 0;
                                            $totalAlpa = 0;
                                            $totalIjin = 0;
                                            $totalSakit = 0;
                                            $totalDays = 0; // Menghitung total hari (tanpa sabtu, minggu, dan hari besar)
                                            $datesInMonth = collect($dates)->where('isWeekend', false); // Hanya hari kerja
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->gender === 'Laki-laki' ? 'L' : 'P' }}</td>
                                            @foreach ($dates as $date)
                                                @php
                                                    $attendance = $attendances->where('student_id', $student->id)->where('date', $date['date'])->first();
                                                    if ($attendance) {
                                                        switch ($attendance->presence_status) {
                                                            case 'Hadir':
                                                                $presenceStatus = 'H';
                                                                $totalHadir++;
                                                                break;
                                                            case 'Alpa':
                                                                $presenceStatus = 'A';
                                                                $totalAlpa++;
                                                                break;
                                                            case 'Ijin':
                                                                $presenceStatus = 'I';
                                                                $totalIjin++;
                                                                break;
                                                            case 'Sakit':
                                                                $presenceStatus = 'S';
                                                                $totalSakit++;
                                                                break;
                                                            default:
                                                                $presenceStatus = '-'; // Jika status tidak dikenali
                                                                break;
                                                        }
                                                    } else {
                                                        $presenceStatus = '-'; // Jika tidak ada data absensi
                                                    }
                                                @endphp
                                                <td style="{{ $date['isWeekend'] ? 'background-color: #f8d7da;' : '' }}">
                                                    {{ $presenceStatus }}
                                                </td>
                                            @endforeach
                                            @php
                                                // Menghitung total hari kerja
                                                $totalDays = $datesInMonth->count();
                                                // Menghitung persentase kehadiran
                                                $persentaseKehadiran = $totalDays > 0 ? ($totalHadir / $totalDays) * 100 : 0;
                                            @endphp
                                            <td>{{ $totalHadir }}</td>
                                            <td>{{ $totalAlpa }}</td>
                                            <td>{{ $totalIjin }}</td>
                                            <td>{{ $totalSakit }}</td>
                                            <td>{{ number_format($persentaseKehadiran, 2) }}%</td>
                                            <td>
                                                @can('Ubah Absensi')
                                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_data{{ $student->id }}">Edit</a>
                                                @endcan
                                                @can('Hapus Absensi')
                                                <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete_data{{ $student->id }}">Hapus</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($students as $student)
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="edit_data{{ $student->id }}" tabindex="-1" aria-labelledby="editLabel{{ $student->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editLabel{{ $student->id }}">Edit Absensi Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('attendance.update', $student->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        
                                                        <!-- Form untuk mengubah status kehadiran untuk setiap tanggal -->
                                                        <div class="mb-3">
                                                            @foreach ($dates as $date)
                                                                <label for="presence_status_{{ $date['date'] }}" class="form-label">
                                                                    Tanggal {{ \Carbon\Carbon::parse($date['date'])->format('d-m-Y') }}
                                                                </label>
                                                                <div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Hadir" id="hadir_{{ $student->id }}_{{ $date['date'] }}" 
                                                                            {{ $attendances->where('student_id', $student->id)->where('date', $date['date'])->first()?->presence_status == 'Hadir' ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="hadir_{{ $student->id }}_{{ $date['date'] }}">Hadir</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Alpa" id="alpa_{{ $student->id }}_{{ $date['date'] }}" 
                                                                            {{ $attendances->where('student_id', $student->id)->where('date', $date['date'])->first()?->presence_status == 'Alpa' ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="alpa_{{ $student->id }}_{{ $date['date'] }}">Alpa</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Ijin" id="ijin_{{ $student->id }}_{{ $date['date'] }}" 
                                                                            {{ $attendances->where('student_id', $student->id)->where('date', $date['date'])->first()?->presence_status == 'Ijin' ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="ijin_{{ $student->id }}_{{ $date['date'] }}">Ijin</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="presence_status[{{ $date['date'] }}]" value="Sakit" id="sakit_{{ $student->id }}_{{ $date['date'] }}" 
                                                                            {{ $attendances->where('student_id', $student->id)->where('date', $date['date'])->first()?->presence_status == 'Sakit' ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="sakit_{{ $student->id }}_{{ $date['date'] }}">Sakit</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                                        
                                                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                                                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach ($students as $student)
                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="delete_data{{ $student->id }}" tabindex="-1" aria-labelledby="deleteLabel{{ $student->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteLabel{{ $student->id }}">Hapus Data Absensi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus data absensi siswa <strong>{{ $student->name }}</strong> untuk bulan ini?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" action="{{ route('attendance.destroy', $student->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                                                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    @php
                                        $totalHadirPerHari = array_fill(0, count($dates), 0);
                                        $totalAlpaPerHari = array_fill(0, count($dates), 0);
                                        $totalIjinPerHari = array_fill(0, count($dates), 0);
                                        $totalSakitPerHari = array_fill(0, count($dates), 0);
                                    @endphp
                                    @foreach ($students as $student)
                                        @foreach ($dates as $index => $date)
                                            @php
                                                $attendance = $attendances->where('student_id', $student->id)->where('date', $date['date'])->first();
                                                if ($attendance) {
                                                    switch ($attendance->presence_status) {
                                                        case 'Hadir':
                                                            $totalHadirPerHari[$index]++;
                                                            break;
                                                        case 'Alpa':
                                                            $totalAlpaPerHari[$index]++;
                                                            break;
                                                        case 'Ijin':
                                                            $totalIjinPerHari[$index]++;
                                                            break;
                                                        case 'Sakit':
                                                            $totalSakitPerHari[$index]++;
                                                            break;
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td colspan="3"><strong>Total Hadir Per Hari</strong></td>
                                        @foreach ($totalHadirPerHari as $totalHadir)
                                            <td>{{ $totalHadir }}</td>
                                        @endforeach
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Total Alpa Per Hari</strong></td>
                                        @foreach ($totalAlpaPerHari as $totalAlpa)
                                            <td>{{ $totalAlpa }}</td>
                                        @endforeach
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Total Ijin Per Hari</strong></td>
                                        @foreach ($totalIjinPerHari as $totalIjin)
                                            <td>{{ $totalIjin }}</td>
                                        @endforeach
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Total Sakit Per Hari</strong></td>
                                        @foreach ($totalSakitPerHari as $totalSakit)
                                            <td>{{ $totalSakit }}</td>
                                        @endforeach
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Persentase Kehadiran</strong></td>
                                        @foreach ($totalHadirPerHari as $index => $totalHadir)
                                            <td>
                                                @php
                                                    $totalSiswa = $students->count();
                                                    $persentaseKehadiranHari = $totalSiswa > 0 ? ($totalHadir / $totalSiswa) * 100 : 0;
                                                @endphp
                                                {{ number_format($persentaseKehadiranHari, 2) }}%
                                            </td>
                                        @endforeach
                                        <td colspan="5">Persentase Kehadiran Bulanan</td>
                                        @php
                                            $totalStudents = count($students);
                                            $totalDaysInMonth = count(array_filter($dates, fn($date) => !$date['isWeekend']));
                                            $totalKehadiranBulanan = array_sum($totalHadirPerHari);
                                            $persentaseKehadiranBulanan = $totalStudents > 0 && $totalDaysInMonth > 0 ? ($totalKehadiranBulanan / ($totalStudents * $totalDaysInMonth)) * 100 : 0;
                                        @endphp
                                        <td colspan="{{ count($dates) }}">{{ number_format($persentaseKehadiranBulanan, 2) }}%</td>
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
@endsection
