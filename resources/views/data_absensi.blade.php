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
                        <h5 class="m-0 text-primary">Tabel Absensi Siswa</h5>
                        <div class="row filter-row">
                            <form method="GET" action="{{ route('attendance.index') }}" class="form-inline">
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
                        @can('Tambah Absensi')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
                            Tambah
                        </button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importAbsensiModal">
                            Import
                        </button>
                        <a href="{{ route('attendance.export') }}" class="btn btn-success">
                            Ekspor
                        </a>
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
                        <!-- Import Modal -->
                        <div class="modal fade" id="importAbsensiModal" tabindex="-1" aria-labelledby="importAbsensiModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="importAbsensiModalLabel">Import Data Absensi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="{{ route('attendance.import') }}" method="POST" enctype="multipart/form-data">
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
                                        <table class="table table-hover" style="width:100%; --bs-table-bg: white;">
                                            <thead class="text-nowrap table-light rounded-header"
                                            style="--bs-table-bg: #eef2f7; --bs-table-border-color: #eef2f7;">
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
                                                    <th>Point Absensi</th>
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
                                                        $pointAbsensi = 0;
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
                                                                            $pointAbsensi += 10;
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
                                                        <td>{{ $pointAbsensi }}</td>
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
        </div>
    </div>
</div>
@endsection
