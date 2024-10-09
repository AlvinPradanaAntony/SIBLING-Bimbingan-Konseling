@extends('layouts.app')

@section('content')
  <div class="container min-vh-100 d-flex justify-content-center align-items-center" id="verify">
    @if (session('resent'))
      <script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            icon: 'success',
            title: 'Verifikasi Email',
            text: 'Tautan verifikasi baru telah dikirim ke alamat email Anda.',
          });
        });
      </script>
    @endif
    <div class="card border-0 mx-5">
      <div class="card-body p-0">
        <div class="p-5 py-3">
          <div class="text-center">
            <img src="../img/verify.gif" alt="" />
            <h1 class="h4 mb-2">Verifikasi Alamat Email Anda</h1>
            <p class="mb-4">Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.</p>
          </div>
          @if (session('resent'))
            <div class="alert alert-success" role="alert">
              Tautan verifikasi baru telah dikirim ke alamat email Anda.
            </div>
          @endif
          <form class="text-center" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-user btn-block px-4 ">
              Kirim Ulang Tautan Verifikasi
            </button>
          </form>
          <hr>
          <div class="text-center">
            <a class="small text-decoration-none" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">Kembali ke
              halaman login</a>
          </div>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
