@extends('layouts.user_type.guest')

@section('content')

  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-left bg-transparent d-flex flex-column align-items-center">
                  <img src="../assets/img/logos/maju_motor.png" alt="maju-motor" width="100" class="mb-3">
                  <h3 class="font-weight-bolder text-info text-gradient text-center">MAJU MOTOR</h3>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="/session">
                    @csrf
                    <label>Username</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="username" id="username" placeholder="username" value="admin" aria-label="username">
                      @error('username')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="secret" aria-label="Password" aria-describedby="password-addon">
                      @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="register" class="text-info text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Bagian gambar tetap dipertahankan -->
            <div class="col-md-6 d-none d-md-block">
              <div class="oblique position-absolute top-0 h-100 me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" 
                     style="background-image:url('../assets/img/curved-images/curved6.jpg')">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
