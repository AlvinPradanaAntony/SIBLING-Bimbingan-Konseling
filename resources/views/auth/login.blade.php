@extends('layouts.app')

@section('content')
  <div class="container min-vh-100 d-flex justify-content-center align-items-center" id="login">
    <div class="card border-0">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-lg-6 d-none d-lg-flex banner flex-column justify-content-center">
            <img src="img/ornamen3.svg" class="wavy-lines" alt="..." />
            <img src="img/character1.png" class="img-fluid" width="420" alt="" />
          </div>
          <div class="col-lg-6 p-5 py-4">
            <a href="/" class="text-decoration-none">
              <img src="img/app_logo_extend.png" class="img-fluid ms-auto d-block" alt="" width="120" />
            </a>
            <form method="POST" action="{{ route('login') }}" id="formLogin" class="mt-4">
              @csrf
              <h2>Login</h2>
              @if ($errors->any())
                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    let errorMessage = "{{ $errors->has('email') ? 'Silakan hubungi administrator untuk didaftarkan.' : 'Masukkan Kata Sandi Dengan Benar.' }}";
                    Swal.fire({
                      icon: 'error',
                      title: '{{ $errors->first() }}',
                      text: errorMessage,
                    });
                  });
                </script>
              @endif
              <div>
                <label>Email</label>
                <input id="email" type="email" placeholder="example@gmail.com" name="email"
                  value="{{ old('email') }}" required autocomplete="email" autofocus></input>
              </div>
              <div class="wrapper">
                <label class="f-12 font2" for="passInput">Kata Sandi</label>
                <input id="passInput" type="password" name="password" placeholder="password" required
                  autocomplete="current-password">
                <span class="eye" id="spanEye">
                  <i class="uil uil-eye-slash show-hide" toggle="#passInput" id="iconShowHide"></i>
                </span>
              </div>
              @if (Route::has('password.request'))
                <div class="forgotPassword d-flex justify-content-end">
                  <a href="{{ route('password.request') }}">Lupa
                    Password ?</a>
                </div>
              @endif
              <button type="submit" class="btn btn-primary w-100" id="btnSubmit">
                <span class="text_btn">Masuk</span>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                  style="display: none;"></span>
              </button>
            </form>
            <div>
              <p class="text-center mt-4 small">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
