@extends('layouts.user_type.guest')

@section('content')

  <section class="d-flex align-items-center justify-content-center min-vh-100 position-relative" style="background-image: url('../assets/img/curved-images/curved14.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <!-- Overlay untuk menutupi seluruh halaman -->
    <div class="overlay"></div>

    <div class="container position-relative">
      <div class="row mt-3">
        <div class="col-xl-7 col-lg-7 col-md-7 mx-auto">
          <div class="card z-index-1">
            <div class="card-body">
              <div class="card-header pb-0 text-left bg-transparent d-flex flex-column align-items-center">
                <img src="../assets/img/logos/maju_motor.png" alt="maju-motor" width="100" class="mb-3">
                <h3 class="font-weight-bolder text-info text-gradient text-center">MAJU MOTOR</h3>
              </div>
              <h5 class="text-center">Register</h5>
              <div class="card-body">
                <form role="form" method="POST" action="/register">
                  @csrf
                  <label>Username</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="username" id="username" placeholder="username" aria-label="username" value="{{ old('username') }}">
                    @error('username')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <label>Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"  aria-label="Password" aria-describedby="password-addon">
                    @error('password')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                  </div>
                  <p class="text-sm mt-3 mb-0 text-center">Already have an account? <a href="login" class="text-dark font-weight-bolder">Sign in</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    /* Mencegah scroll dan memastikan tinggi penuh */
    html, body {
      height: 100vh;
      margin: 0;
      overflow: hidden;
    }

    /* Overlay agar menutupi 1 halaman penuh */
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background: rgba(0, 0, 0, 0.6); /* Transparan agar teks lebih jelas */
      z-index: 0;
    }

    /* Pastikan kontennya di atas overlay */
    .container {
      position: relative;
      z-index: 1;
    }
  </style>

@endsection
