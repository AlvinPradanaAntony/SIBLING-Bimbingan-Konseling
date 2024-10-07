@extends('layouts.app')

@section('content')
  <div class="container min-vh-100 d-flex justify-content-center align-items-center" id="register">
    <div class="card border-0">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-lg-3 d-none d-lg-flex banner flex-column justify-content-center">
            {{-- <img src="img/wavy-lines.svg" class="wavy-lines" alt="..." /> --}}

            <img src="img/12.png" class="img-fluid" width="420" alt="" />
          </div>
          <div class="col-lg-9 p-5 py-4">
            <a href="/" class="text-decoration-none">
              <img src="img/app_logo_extend.png" class="img-fluid ms-auto me-auto d-block" alt=""
                width="120" />
            </a>
            <form method="POST" action="{{ route('register') }}" id="formLogin" class="mt-4">
              @csrf
              <h2>Daftar</h2>
              @if ($errors->any())
                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                      icon: 'error',
                      title: 'Terdapat Kesalahan',
                      text: '{{ $errors->first() }}',
                    });
                  });
                </script>
              @endif
              <div class="row">
                <div class="col-lg-6">
                  <label for="name">Nama</label>
                  <input id="name" type="text" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}"
                    required autocomplete="name" autofocus></input>
                </div>
                <div class="col-lg-6">
                  <label for="email">Email</label>
                  <input id="email" type="email" placeholder="example@gmail.com" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus></input>
                </div>
              </div>
              <div class="wrapper">
                <label for="passInput">Kata Sandi</label>
                <input id="passInput" type="password" name="password" placeholder="Masukan Kata Sandi" required
                  autocomplete="current-password">
                <span class="eye" id="spanEye">
                  <i class="uil uil-eye-slash show-hide" toggle="#passInput" id="iconShowHide"></i>
                </span>
              </div>
              <div class="wrapper">
                <label for="password-confirm">Konfirmasi Kata Sandi</label>
                <input id="password-confirm" type="password" name="password_confirmation" placeholder="Masukan Ulang Kata Sandi" required
                  autocomplete="new-password">
                <span class="eye" id="spanEye2">
                  <i class="uil uil-eye-slash show-hide2" toggle="#password-confirm" id="iconShowHide2"></i>
                </span>
              </div>
              <button type="submit" class="btn btn-primary w-100" id="btnSubmit">
                <span class="text_btn">Daftar</span>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                  style="display: none;"></span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
