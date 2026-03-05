@extends('auth.Auth')

@section('tittle')
<title>Login | Larkon - Admin & Dashboard Template</title>
@endsection

<div class="container-fluid position-relative d-flex p-0">
    <!-- Sign In Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.html" class="">
                            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Surat Desa</h3>
                        </a>
                        <h3>Sign In</h3>
                    </div>
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="floatingInput"
                                name="email"
                                value="{{ old('email') }}"
                                required autofocus
                                placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="floatingPassword"
                                name="password"
                                required
                                placeholder="Password">
                            <label for="floatingPassword">Password</label>
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="">Forgot Password</a>
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Sign In End -->
</div>