<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/hospital-logo.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/hospital-logo.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Hospital Information Management System
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  @include('includes.styles')
  <style>
body {
  background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
}

.btn-google {
  color: white !important;
  background-color: #ea4335;
}

.btn-facebook {
  color: white !important;
  background-color: #3b5998;
}

  </style>
    </head>


<body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
           <div class="card border-0 shadow rounded-3 my-5">
            <div class="card-body p-4 p-sm-5">
                @if(session('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sorry!</strong> {{ session('danger') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif  
              <h5 class="card-title text-center mb-5 fw-light fs-5">Create Account</h5>
              <form class="d-inline" method="POST" action="{{ url('patient/verified/create-account') }}">
                @csrf
                <input type="text" name="hosp_no" class="form-control" value="{{ $hosp_no }}" hidden/>
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required/>
                <label>Password</label>
                <input type="password" name="password" class="form-control" required/>
                <label>Re-type Password</label>
                <input type="password" name="password2" class="form-control" required/>
                <hr>
                <button type="submit" class="btn btn-primary align-baseline">{{ __('Create Account') }}</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  
@include('includes.scripts')
</html>