@extends('layouts.dashboard')

@section('content')
  <div>
    <div class="content">
      <div class="row pt-4">
        <div class="mb-4">
          <div class="p-0" style="min-height: 500px">
            <div class="row g-2 mb-2">
              <div class="col-lg-8 m-0">
                <div class="custCard">
                  <div class="px-2 py-0">
                    <div class="row no-gutters">
                      <div class="col-lg ps-4 pe-0">
                        <div class="text-card1 mb-lg-3 mt-lg-3">Selamat datang kembali, <b>User Testing</b></div>
                        <div class="text2-card1 text-white">Terima kasih anda telah mengakses layanan bimbingan
                          konseling. Kami siap membantu Anda dalam mengatasi berbagai tantangan dan mencapai
                          perkembangan yang lebih baik di sekolah.</div>
                      </div>
                      <div class="col-lg-auto p-0 ms-3">
                        <img src="img/1.png" class="img-fluid" alt="" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 m-0">
                <div class="card">
                  <img src="..." class="card-img-top placeholder" alt="...">
                  <div class="card-body">
                    <p class="card-text">Card ini berisi informasi terbaru mengenai karir dan peluang pekerjaan yang
                      dapat membantu Anda dalam mengembangkan karir Anda lebih lanjut.</p>
                  </div>
                </div>
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
                        <p class="mb-0 card-detail_text">Data Siswa</p>
                        <h4 class="my-1 card-detail_data">0</h4>
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
                        <p class="mb-0 card-detail_text">Informasi Karir</p>
                        <h4 class="my-1 card-detail_data">0</h4>
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
                        <p class="mb-0 card-detail_text">Form Masuk</p>
                        <h4 class="my-1 card-detail_data">0</h4>
                      </div>
                    </div>
                  </div>
                  <div class="abstract1"></div>
                  <div class="abstract2"></div>
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
