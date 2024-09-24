<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/png" href="/img/app_logo.png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login | SMKN 7 Negeri Jember</title>

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <div class="login container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5 loginCard">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block Side banner">
                <div class="text-center Title2">
                  <div class="d-block w-100">
                    <img src="img/character1.png" alt="" class="img-fluid" width="380" />
                    <h2 class="font1 f-24 mt-2">SIBLING</h2>
                    <p class="f-14">Sistem Bimbingan Konseling</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 Side rght">
                <div class="p-5 py-4">
                  <div class="login">
                    <div class="logo">
                      <img src="img/app_logo_extend.png" alt="" class="LogoLogin" />
                    </div>
                    <form method="POST" action="{{ route('login') }}" id="formLogin">
                      @csrf

                      <h1 class="font1">Login</h1>
                      @error('email')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                          <span>
                            <b>{{ $message }}</b>
                          </span>
                        </div>
                      @enderror
                      <div>
                        <label class="f-12 font2"> Email</label>
                        <input id="email" type="email" placeholder="example@gmail.com" name="email"
                          value="{{ old('email') }}" required autocomplete="email" autofocus></input>
                      </div>
                      <div class="wrapper">
                        <label class="f-12 font2" for="passInput">Password</label>
                        <input id="passInput" type="password" name="password" placeholder="password" required autocomplete="current-password">
                        <span class="eye hidden" id="spanEye">
                          <i class="uil uil-eye-slash show-hide" toggle="#passInput" id="iconShowHide"></i>
                        </span>
                      </div>
                      @if (Route::has('password.request'))
                        <div class="forgotPassword">
                          <a href="{{ route('password.request') }}" class="f-12 font2 linkForgotPassword">Lupa
                            Password?</a>
                        </div>
                      @endif
                      <div class="login1">
                        <button type="submit" class="btn btn-primary customBtnSignIn">
                          Masuk
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
