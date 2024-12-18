@extends('layouts.dashboard')

@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="p-0">
            <div class="row mb-2">
              <div class="col-lg-8 m-0">
                <div class="custCard mb-4" style="padding: 20px">
                  <img src="img/footer-bg.png" class="ornament" alt="">
                  <div class="order-2 position-relative z-10">
                    <img src="img/cardChar.png" width="200" alt="">
                  </div>
                  <div class="mt-2 order-1 flex-fill align-content-center">
                    <h3>
                      Selamat Pagi, <span style="font-family: NunitoSans-ExtraBold">{{ auth()->user()->name }}</span>
                    </h3>
                    <p class="mt-2 m-0" style="line-height: 1.625;">Semoga harimu menyenangkan di tempat kerja</p>
                    <p>Kelola data sesi bimbingan Anda!</p>
    
                    <button class="btn mt-3 text-white">
                      Lihat data
                    </button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card" id="data1">
                      <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="card-icon text-white">
                            <i class="uil uil-users-alt"></i>
                          </div>
                          <div class=" ms-auto card-detail">
                            <p class="mb-0 card-detail_text">Data Bimbingan</p>
                            <h4 class="my-1 card-detail_data">{{ $total_guidances }}</h4>
                          </div>
                        </div>
                      </div>
                      <div class="abstract1"></div>
                      <div class="abstract2"></div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card" id="data2">
                      <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="card-icon text-white">
                            <i class="uil uil-database"></i>
                          </div>
                          <div class=" ms-auto card-detail">
                            <p class="mb-0 card-detail_text">Data Kasus</p>
                            <h4 class="my-1 card-detail_data">{{ $total_cases }}</h4>
                          </div>
                        </div>
                      </div>
                      <div class="abstract1"></div>
                      <div class="abstract2"></div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card" id="data3">
                      <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                          <div class="card-icon text-white">
                            <i class="uil uil-notes"></i>
                          </div>
                          <div class=" ms-auto card-detail">
                            <p class="mb-0 card-detail_text">Data Loker</p>
                            <h4 class="my-1 card-detail_data">{{ $total_job_vacancies }}</h4>
                          </div>
                        </div>
                      </div>
                      <div class="abstract1"></div>
                      <div class="abstract2"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 m-0">
                @include('partials.calender')
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
    <div class="col-lg-3 m-0">
    </div>
  </div>
  </div>
@endsection
