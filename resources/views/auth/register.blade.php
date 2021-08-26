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

    {{-- <div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="https://fifarma.org/wp-content/uploads/2020/05/Mesa-de-trabajo-4-copia.jpg">
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ url('login') }}">
                        @csrf
        
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
        
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
        
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div> --}}

    <!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

<body>
    <div class="container">
      <div class="row">
        <div class="mx-auto">
          <div class="card border-0 shadow rounded-3 my-5">
            <div class="card-body p-4 p-sm-5">
              <h5 class="card-title text-center mb-5 fw-light fs-5">Register</h5>
              <form action="{{ url('patients/add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" />
                      </div>
                      <div class="col-md-6">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" />
                      </div>
                      <div class="col-md-6">
                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="gender" id="gender_m" value="Male"> Male
                            <span class="form-check-sign"></span>
                          </label>
                        </div>
                        <div class="form-check form-check-radio form-check-inline">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="gender" id="gender_f" value="Female"> Female
                            <span class="form-check-sign"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <input type="date" name="birthdate" class="form-control" placeholder="Birthdate" />
                      </div>
                      <div class="col-md-6">
                        <select name="civil_stat" class="form-control">
                          <option selected disabled>Civil Status</option>
                          <option value="Single">Single</option>
                          <option value="Married">Married</option>
                          <option value="Separated">Separated</option>
                          <option value="Widowed">Widowed</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <input type="text" name="contact_no" class="form-control" placeholder="Contact No." />
                      </div>
                      <div class="col-md-6">
                        <input type="text" name="email" class="form-control" placeholder="Email Address" required/>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <input type="text" name="philhealth_no" class="form-control" placeholder="PhilHealth No." />
                      </div>
                    </div>
                    {{-- <div class="row mb-3">
                      <div class="col-md-12">
                        <textarea name="address" class="form-control" placeholder="Address"></textarea>
                      </div>
                    </div> --}}
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <select name="province" id="province" class="form-control" required>
                          <option selected disabled>Select Province</option>
                          @php
                            $provinces = \DB::table('tbl_province')->ORDERBY('provDesc')->GET();
                          @endphp
                          @foreach($provinces as $province)
                          <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                        <select name="citymun" id="citymun" class="form-control" required>
                          <option selected disabled>Select City/Municipality</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <select name="brgy" id="brgy" class="form-control" required>
                          <option selected disabled>Select Barangay</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <select name="blood_type" class="form-control">
                          <option selected disabled>Blood Type</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="AB">AB</option>
                          <option value="O">O</option>
                        </select>
                      </div>
                    </div>
                    {{-- <div class="row mb-3">
                      <div class="col-md-6">
                        <select name="blood_type" class="form-control">
                          <option selected disabled>Blood Type</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="AB">AB</option>
                          <option value="O">O</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <select name="patient_type" class="form-control">
                          <option selected disabled>Patient Type</option>
                          <option value="1">Normal Patient</option>
                          <option value="2">Mental Patient</option>
                        </select>
                      </div>
                    </div> --}}
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="custom-file">
                          <input type="file" name="profile_img" class="custom-file-input">
                          <label class="custom-file-label f1" >Choose image file...</label>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                      Up</button>
                  </div>
                  <hr class="my-4">
                  <a class="text-info" href="{{ url('register') }}">
                      <i class="fab fa-google me-2"></i>Already signed up? Click here to Login
                  </a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  
@include('includes.scripts')
<script type="text/javascript">

    $(document).ready(function(){
        $('#province').on('change', function() {
          $.ajax ({
            url : '{{ url("get/citymun") }}/'+$(this).val()
            ,method : 'GET'
            ,cache : false
          }).done( function(response){
            $('.onChangeCityMun').remove();
            for (var key in response) {
                $('#citymun').append('<option class="onChangeCityMun" value="'+response[key]['citymunCode']+'">'+response[key]['citymunDesc']+'</option>');
            }
          });
        }); 
    
        $('#citymun').on('change', function() {
          $.ajax ({
            url : '{{ url("get/brgy") }}/'+$(this).val()
            ,method : 'GET'
            ,cache : false
          }).done( function(response){
            $('.onChangeBrgy').remove();
            for (var key in response) {
                $('#brgy').append('<option class="onChangeBrgy" value="'+response[key]['id']+'">'+response[key]['brgyDesc']+'</option>');
            }
          });
        });
      });
    
    </script>
</html>