@push('styles')
<link href="{{ asset('css/style_absensi.css') }}" rel="stylesheet" />
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/line-awesome.min.css') }}" rel="stylesheet" />
@endpush

<div>
  <div class="row filter-row mt-5">
    <div class="col-sm-6 col-md-3">
      <div class="form-group form-focus">
        <input type="text" class="form-control floating" />
        <label class="focus-label">Student</label>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="form-group form-focus select-focus">
        <select class="select floating">
          <option>-</option>
          <option>Jan</option>
          <option>Feb</option>
          <option>Mar</option>
          <option>Apr</option>
          <option>May</option>
          <option>Jun</option>
          <option>Jul</option>
          <option>Aug</option>
          <option>Sep</option>
          <option>Oct</option>
          <option>Nov</option>
          <option>Dec</option>
        </select>
        <label class="focus-label">Pilih bulan</label>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="form-group form-focus select-focus">
        <select class="select floating">
          <option>-</option>
          @foreach($majors as $major)
            <option>{{ $major->major_name }}</option>
          @endforeach
        </select>
        <label class="focus-label">Pilih Jurusan</label>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <a href="#" class="btn btn-success btn-block"> Search </a>
    </div>
  </div>

  <?php
  $employees = [
      [
          'name' => 'John Doe',
          'avatar' => 'assets/img/profiles/avatar-09.jpg',
          'attendance' => [1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 1, 0, 1, 1],
          // 1 = hadir, 0 = tidak hadir
      ],
      [
          'name' => 'Jane Smith',
          'avatar' => 'assets/img/profiles/avatar-10.jpg',
          'attendance' => [1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
      ],
      [
          'name' => 'Robert Brown',
          'avatar' => 'assets/img/profiles/avatar-11.jpg',
          'attendance' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
      ],
      [
          'name' => 'Emily Davis',
          'avatar' => 'assets/img/profiles/avatar-12.jpg',
          'attendance' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
      ],
      [
          'name' => 'Michael Wilson',
          'avatar' => 'assets/img/profiles/avatar-13.jpg',
          'attendance' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
      ],
      [
          'name' => 'Sarah Johnson',
          'avatar' => 'assets/img/profiles/avatar-14.jpg',
          'attendance' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
      ],
  ];
  
  ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table class="table table-striped custom-table table-nowrap mb-0">
          <thead>
            <tr>
              <th>Siswa</th>
              <?php for ($i = 1; $i <= 31; $i++): ?>
              <th>
                <?= $i ?>
              </th>
              <?php endfor; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($employees as $employee): ?>
            <tr>
              <td>
                <h2 class="table-avatar">
                  <a class="avatar avatar-xs" href="profile.html"><img alt="" src="<?= $employee['avatar'] ?>"></a>
                  <a href="profile.html">
                    <?= $employee['name'] ?>
                  </a>
                </h2>
              </td>
              <?php for ($i = 1; $i <= 31; $i++): 
                                  $attendance = isset($employee['attendance'][$i-1]) ? $employee['attendance'][$i-1] : ''; // cek apakah ada data kehadiran
                                  ?>
              <td>
                <?php if ($attendance == 1): ?>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info"><i
                    class="uil uil-check text-success"></i></a>
                <?php elseif ($attendance == 0): ?>
                <i class="uil uil-check text-danger"></i>
                <?php elseif ($attendance == 0.5): ?>
                <div class="half-day">
                  <?php if ($i == 8 || $i == 24): // contoh untuk hari ke-8 dan 24 ?>
                  <span class="first-off"><a href="" data-toggle="modal"
                      data-target="#attendance_info"><i class="uil uil-check text-success"></i></a></span>
                  <span class="first-off"><i class="uil uil-times text-danger"></i></span>
                  <?php else:  ?>
                  <span class="first-off"><i class="uil uil-times text-danger"></i></span>
                  <span class="first-off"><a href="" data-toggle="modal"
                      data-target="#attendance_info"><i class="uil uil-check text-success"></i></a></span>
                  <?php endif; ?>
                </div>
                <?php endif; ?>
              </td>
              <?php endfor; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal custom-modal fade" id="attendance_info" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Attendance Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="card punch-status">
                <div class="card-body">
                  <h5 class="card-title">Timesheet <small class="text-muted">11 Mar 2019</small></h5>
                  <div class="punch-det">
                    <h6>Punch In at</h6>
                    <p>Wed, 11th Mar 2019 10.00 AM</p>
                  </div>
                  <div class="punch-info">
                    <div class="punch-hours">
                      <span>3.45 hrs</span>
                    </div>
                  </div>
                  <div class="punch-det">
                    <h6>Punch Out at</h6>
                    <p>Wed, 20th Feb 2019 9.00 PM</p>
                  </div>
                  <div class="statistics">
                    <div class="row">
                      <div class="col-md-6 col-6 text-center">
                        <div class="stats-box">
                          <p>Break</p>
                          <h6>1.21 hrs</h6>
                        </div>
                      </div>
                      <div class="col-md-6 col-6 text-center">
                        <div class="stats-box">
                          <p>Overtime</p>
                          <h6>3 hrs</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card recent-activity">
                <div class="card-body">
                  <h5 class="card-title">Activity</h5>
                  <ul class="res-activity-list">
                    <li>
                      <p class="mb-0">Punch In at</p>
                      <p class="res-activity-time">
                        <i class="fa fa-clock-o"></i>
                        10.00 AM.
                      </p>
                    </li>
                    <li>
                      <p class="mb-0">Punch Out at</p>
                      <p class="res-activity-time">
                        <i class="fa fa-clock-o"></i>
                        11.00 AM.
                      </p>
                    </li>
                    <li>
                      <p class="mb-0">Punch In at</p>
                      <p class="res-activity-time">
                        <i class="fa fa-clock-o"></i>
                        11.15 AM.
                      </p>
                    </li>
                    <li>
                      <p class="mb-0">Punch Out at</p>
                      <p class="res-activity-time">
                        <i class="fa fa-clock-o"></i>
                        1.30 PM.
                      </p>
                    </li>
                    <li>
                      <p class="mb-0">Punch In at</p>
                      <p class="res-activity-time">
                        <i class="fa fa-clock-o"></i>
                        2.00 PM.
                      </p>
                    </li>
                    <li>
                      <p class="mb-0">Punch Out at</p>
                      <p class="res-activity-time">
                        <i class="fa fa-clock-o"></i>
                        7.30 PM.
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@push('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/absensi.js') }}"></script>
@endpush