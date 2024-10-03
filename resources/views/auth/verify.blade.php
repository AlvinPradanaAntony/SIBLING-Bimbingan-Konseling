@extends('layouts.app')

@section('content')
  <div class="container  min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card border-0">
      <div class="card-body p-0">
        <div class="p-5">
          <div class="text-center">
            <h1 class="h4 text-gray-900 mb-2">Verifikasi Alamat Email Anda</h1>
            <p class="mb-4">Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.</p>
          </div>
          @if (session('resent'))
            <div class="alert alert-success" role="alert">
              Tautan verifikasi baru telah dikirim ke alamat email Anda.
            </div>
          @endif
          <form class="user" method="POST" action="">
            @csrf
            <button type="submit" class="btn btn-primary btn-user btn-block">
              Kirim Ulang Tautan Verifikasi
            </button>
          </form>
          <hr>
          <div class="text-center">
            <a class="small" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">Kembali ke halaman login</a>
          </div>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
