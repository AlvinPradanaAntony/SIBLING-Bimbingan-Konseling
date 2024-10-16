@extends('layouts.app')

@section('content')
  <div class="container min-vh-100 d-flex justify-content-center align-items-center" id="register">
    <div class="card border-0">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-lg-3 d-none d-lg-flex banner flex-column justify-content-center">
            <img src="img/wavy-lines.svg" class="wavy-lines" alt="..." />

            <img src="img/12.png" class="img-fluid" width="420" alt="" />
          </div>
          <div class="col-lg-9 p-5 py-4">
            <div>
              {{-- Navigation back to login --}}
              <a href="{{ route('login') }}" class="text-decoration-none">
                <i class="uil uil-arrow-left"></i>
                <span>Kembali</span>
              </a>
              <div class="text-center mt-2">
                <a href="/" class="text-decoration-none">
                  <img src="img/app_logo_extend.png" class="img-fluid" alt=""
                  width="120" />
                </a>
              </div>

            </div>
            
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
              <div>
                <label for="nip">NIP/NUPTK</label>
                <input id="nip" type="text" placeholder="NIP/NUPTK" name="nip" value="{{ old('nip') }}"
                  required autocomplete="nip" autofocus></input>
              </div>
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
              <div class="row">
                <div class="col-lg-6">
                  <div class="wrapper">
                    <label for="passInput">Kata Sandi</label>
                    <input id="passInput" type="password" name="password" placeholder="Masukan Kata Sandi" required
                      autocomplete="current-password">
                    <span class="eye" id="spanEye">
                      <i class="uil uil-eye-slash show-hide" toggle="#passInput" id="iconShowHide"></i>
                    </span>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="wrapper">
                    <label for="password-confirm">Konfirmasi Kata Sandi</label>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Masukan Ulang Kata Sandi" required
                      autocomplete="new-password">
                    <span class="eye" id="spanEye2">
                      <i class="uil uil-eye-slash show-hide2" toggle="#password-confirm" id="iconShowHide2"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div>
                <label for="role_id">Akses</label>
                <select id="role_id" name="role_id"  required>
                  <option value="" selected disabled>Pilih Role</option>
                  <option value="1">Siswa</option>
                  <option value="2">Wali Kelas</option>
                  <option value="3">Guru BK</option>
                  <option value="4">Admin</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary w-100 mt-4" id="btnSubmit">
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
