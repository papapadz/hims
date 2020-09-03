@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Employees
            <button class="btn btn-outline-success btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalAddEmployee">
              <i class="fa fa-plus"></i> Add
            </button>
        </h5>
      </div>
      <div class="card-body ">
        <table id="tblEmployees" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Employee No.</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->emp_no }}</td>
                    <td>{{ $employee->last_name }}, {{ $employee->first_name }} {{ $employee->middle_name[0] }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>
                      <a href="{{ url('employee/profile/'.$employee->emp_no) }}" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                        <i class="fa fa-arrow-right"></i>
                      </a>
                      <a 
                        href="{{ url('employee/delete/'.$employee->emp_no) }}" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round"
                        onclick="return confirm('Are you sure you want to delete this employee record?');">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
      </div>
  </div>
</div>

<form action="{{ url('employees/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddEmployee" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Employee Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <h4>Personal Information</h4>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Employee ID</label>
                <input type="text" name="emp_no" class="form-control" placeholder="Employee ID" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Surname</label>
                <input type="text" name="last_name" class="form-control" placeholder="Surname" required />
              </div>
              <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="First Name" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Middle Name</label>
                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name"/>
              </div>
              <div class="col-md-4">
                <label>Name Extension</label>
                <input type="text" name="extension" class="form-control" placeholder="Jr./Sr./III"/>
              </div>
              <div class="col-md-2">
                <label>Sex</label><br>
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
                <label>Birthdate</label>
                <input type="date" name="birthdate" class="form-control" placeholder="Birthdate" required/>
              </div>
              <div class="col-md-6">
                <label>Place of Birth</label>
                <textarea name="birthplace" class="form-control" placeholder="Place of Birth" required></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Citizenship</label>
                <select name="citizenship_id" class="form-control" required>
                  <option selected disabled>Select Citizenship</option>
                  @foreach($countries as $country)
                  <option value="{{ $country->id }}">{{ $country->nationality }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label>Civil Status</label>
                <select name="civil_stat" class="form-control" required>
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
                <label>Height</label>
                <input type="text" name="height" class="form-control" placeholder="Height (m)" required/>
              </div>
              <div class="col-md-6">
                <label>Weight</label>
                <input type="text" name="weight" class="form-control" placeholder="Weight (kg)" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Blood Type</label>
                <select name="blood_type" class="form-control" required>
                  <option selected disabled>Select Blood Type</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="AB">AB</option>
                  <option value="O">O</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Upload Picture</label>
                <div class="custom-file">
                  <input type="file" name="profile_img" class="custom-file-input">
                  <label class="custom-file-label f1" >Choose image file...</label>
                </div>
              </div>
            </div>
            <hr>

            <h4>Residential Address</h4>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>House/Block/Lot No.</label>
                <input type="text" name="house_no" class="form-control" placeholder="House/Block/Lot No." />
              </div>
              <div class="col-md-6">
                <label>Street</label>
                <input type="text" name="street" class="form-control" placeholder="Street" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Subdivision/Village</label>
                <input type="text" name="subdivision" class="form-control" placeholder="Subdivision/Village" />
              </div>
              <div class="col-md-6">
                <label>Province</label>
                <select name="province" id="province" class="form-control" required>
                  <option selected disabled>Select Province</option>
                  @foreach($provinces as $province)
                  <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>City/Municipality</label>
                <select name="citymun" id="citymun" class="form-control" required>
                  <option selected disabled>Select City/Municipality</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Barangay</label>
                <select name="brgy" id="brgy" class="form-control" required>
                  <option selected disabled>Select Barangay</option>
                </select>
              </div>
            </div>
            <hr>

            <h4>Permanent Address</h4>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>House/Block/Lot No.</label>
                <input type="text" name="house_no2" class="form-control" placeholder="House/Block/Lot No." />
              </div>
              <div class="col-md-6">
                <label>Street</label>
                <input type="text" name="street2" class="form-control" placeholder="Street" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Subdivision/Village</label>
                <input type="text" name="subdivision2" class="form-control" placeholder="Subdivision/Village" />
              </div>
              <div class="col-md-6">
                <label>Province</label>
                <select name="province2" id="province2" class="form-control" required>
                  <option selected disabled>Select Province</option>
                  @foreach($provinces as $province)
                  <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>City/Municipality</label>
                <select name="citymun2" id="citymun2" class="form-control" required>
                  <option selected disabled>Select City/Municipality</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Barangay</label>
                <select name="brgy2" id="brgy2" class="form-control" required>
                  <option selected disabled>Select Barangay</option>
                </select>
              </div>
            </div>
            <hr>

            <h5 class="modal-title">Other Information</h5>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>GSIS No.</label>
                <input type="text" name="gsis" class="form-control" placeholder="GSIS No." />
              </div>
              <div class="col-md-6">
                <label>PAG-IBIG No.</label>
                <input type="text" name="pagibig" class="form-control" placeholder="PAG-IBIG No." />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>PHILHEALTH No.</label>
                <input type="text" name="phic" class="form-control" placeholder="PHILHEALTH No." />
              </div>
              <div class="col-md-6">
                <label>SSS No.</label>
                <input type="text" name="sss" class="form-control" placeholder="SSS No." />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>TIN No.</label>
                <input type="text" name="tin" class="form-control" placeholder="TIN No." />
              </div>
              <div class="col-md-6">
                <label>Mobile No.</label>
                <input type="text" name="contact_no" class="form-control" placeholder="Mobile No." />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Telephone No.</label>
                <input type="text" name="telphone" class="form-control" placeholder="Telephone No." />
              </div>
              <div class="col-md-6">
                <label>Email Address</label>
                <input type="text" name="email" class="form-control" placeholder="Email Address" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Account No.</label>
                <input type="text" name="acct_no" class="form-control" placeholder="Account No." required/>
              </div>
            </div>
            <hr>

            <h5>Employment Details</h5>
            <div class="row mb-3">
              <div class="col-md-6">
                <select name="eligibility_id" class="form-control">
                  <option value="" selected>None</option>
                  @foreach($eligibilities as $eligibility)
                    <option value="{{ $eligibility->id }}">{{ $eligibility->e_title }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <select name="profession" class="form-control" required>
                  <option selected disabled>Select Profession</option>
                  @foreach($professions as $profession)
                    <option value="{{ $profession->profession }}">{{ $profession->profession }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <select name="position_id" class="form-control" required>
                  <option selected disabled>Position</option>
                  @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->position }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <select name="department_id" class="form-control" required>
                  <option selected disabled>Department</option>
                  @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Upload PDS</label>
                <div class="custom-file">
                  <input type="file" name="pds" required>
                  <label class="custom-file-label f2" >Choose a file...</label>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection

@section('script')
<script type="text/javascript">
  $('#tblEmployees').DataTable();
  $('#tblDTR').DataTable();

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

    $('#province2').on('change', function() {
      $.ajax ({
        url : '{{ url("get/citymun") }}/'+$(this).val()
        ,method : 'GET'
        ,cache : false
      }).done( function(response){
        $('.onChangeCityMun2').remove();
        for (var key in response) {
            $('#citymun2').append('<option class="onChangeCityMun2" value="'+response[key]['citymunCode']+'">'+response[key]['citymunDesc']+'</option>');
        }
      });
    }); 

    $('#citymun2').on('change', function() {
      $.ajax ({
        url : '{{ url("get/brgy") }}/'+$(this).val()
        ,method : 'GET'
        ,cache : false
      }).done( function(response){
        $('.onChangeBrgy2').remove();
        for (var key in response) {
            $('#brgy2').append('<option class="onChangeBrgy2" value="'+response[key]['id']+'">'+response[key]['brgyDesc']+'</option>');
        }
      });
    });  
  });

</script>
@endsection