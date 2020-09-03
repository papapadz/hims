@extends('layouts.app')

@section('content')

<form action="{{ url('employee/profile/save') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="text" name="emp_no" value="{{ $employee->emp_no }}" hidden>
<div class="row">

  <div class="col-md-3">
    <div class="row">
      <div class="col-12">
        <div class="card" >
          <img class="card-img-top" style="width: 90%; align-self: center" src="{{ asset('assets/img/faces/'.$employee->profile_img) }}" alt="Card image cap">
          <div class="card-body">
            <h3 class="card-text text-center">{{ $employee->emp_no }}</h3>
          </div>
          <div id="divEditProfileImg" class="card-footer" hidden="true">
            <label>Change Profile Image</label>
            <input type="file" name="profile_img" class="form-control"/>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="row" style="width: 100%">
      <div class="card col-12">
        <div class="card-header ">
          <h5 class="card-title">{{ $employee->last_name }}, {{ $employee->first_name }} {{ $employee->middle_name }} 
            
          </h5>
        </div>
        <div class="card-body ">
          <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#emp-info" role="tab" aria-selected="true">Employee Info</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#dtr" role="tab" aria-selected="false">Daily Time Record</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#payroll" role="tab" aria-selected="false">Payroll</a>
              </li>
            </ul>
          <!-- Tab panes -->
            <div class="tab-content">
              <br>
              <div class="tab-pane active" id="emp-info" role="tabpanel">
                <div class="row">
                  <div class="col-12">
                    <button type="button" class="btn btn-outline-primary btn-round btn-sm forAdmin forHRS" id="btnEditFields" hidden="true">
                      <i class="fa fa-pencil"></i> Edit
                    </button>
                    <div id="divEditFields" hidden="true">
                      <button type="submit" class="btn btn-outline-success btn-round btn-sm" id="btnSaveFields">
                        <i class="fa fa-save"></i> Save
                      </button>
                      <button type="button" class="btn btn-outline-danger btn-round btn-sm" id="btnCancelEdit">
                        <i class="fa fa-times"></i> Cancel
                      </button>
                    </div>  
                  </div>
                </div>
                <form>
                  <h6>Basic Information</h6>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">SurName:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="last_name" value="{{ $employee->last_name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">First Name:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="first_name" value="{{ $employee->first_name }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Name Extension:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="extension" value="{{ $employee->extension }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Middle Name:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="middle_name" value="{{ $employee->middle_name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Birthdate:</label>
                    <div class="col-sm-4">
                      <input type="date" readonly="true" class="form-control-plaintext fieldToEdit" name="birthdate" value="{{ $employee->birthdate }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Citzenship:</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="citizenship_id">
                        @foreach($countries as $country)
                          <option @if($employee->citizenship_id==$country->id) selected @endif value="{{ $country->id }}">{{ $country->nationality }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Place of Birth:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="birthplace" value="{{ $employee->birthplace }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Sex:</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="gender">
                        <option @if($employee->gender=='Male') selected @endif value="Male">Male</option>
                        <option @if($employee->gender=='Female') selected @endif value="Female">Female</option>
                      </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Civil Status:</label>
                    <div class="col-sm-4">
                      <select  disabled="true" class="form-control-plaintext fieldToEdit" name="civil_stat">
                          <option @if($employee->civil_stat=='Single') selected @endif value="Single">Single</option>
                          <option @if($employee->civil_stat=='Married') selected @endif value="Married">Married</option>
                          <option @if($employee->civil_stat=='Separated') selected @endif value="Separated">Separated</option>
                          <option @if($employee->civil_stat=='Widowed') selected @endif value="Widowed">Widowed</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Eligibility</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="eligibility_id" id="eligibility_id">
                        @foreach($eligibilities as $eligibility)
                          <option @if($employee->eligibility_id==$eligibility->id) selected @endif value="{{ $eligibility->id }}">{{ $eligibility->e_title }}</option>
                        @endforeach
                      </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Profession</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="profession" id="profession">
                        <option selected disabled>Select Profession</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Nurse">Nurse</option>
                        <option value="Radiologist">Radiologist</option>
                        <option value="MedTech">MedTech</option>
                        <option value="Engineer">Engineer</option>
                        <option value="HR">HR</option>
                        <option value="Accountant">Accountant</option>
                        <option value="Admin">Admin</option>
                        <option value="Finance">Finance</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Position</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="position_id">
                        @foreach($positions as $position)
                          <option @if($employee->position_id==$position->id) selected @endif value="{{ $position->id }}">{{ $position->position }}</option>
                        @endforeach
                      </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Department</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="department_id">
                        @foreach($departments as $department)
                          <option @if($employee->department_id==$department->id) selected @endif value="{{ $department->id }}">{{ $department->department }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <h6>Residential Address</h6>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">House/Block/Lot No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="house_no" value="{{ $employee->house_no }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Street:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="street" value="{{ $employee->street }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Subdivision/Village</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="subdivision" value="{{ $employee->subdivision }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Province</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="province" id="province">
                        @foreach($provinces as $province)
                          <option @if($employee->provCode==$province->provCode) selected @endif value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">City/Municipality</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="citymun" id="citymun">
                        @foreach($cityMuns as $citymun)
                          <option class="onChangeCityMun" @if($employee->citymunCode==$citymun->citymunCode) selected @endif value="{{ $citymun->citymunCode }}">{{ $citymun->citymunDesc }}</option>
                        @endforeach
                      </select>
                    </div>
                    <label class="col-sm-2 col-form-label">City/Municipality</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="brgy" id="brgy">
                        @foreach($brgys as $brgy)
                          <option class="onChangeBrgy" @if($employee->brgy_id==$brgy->id) selected @endif value="{{ $brgy->id }}">{{ $brgy->brgyDesc }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <h6>Permanent Address</h6>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">House/Block/Lot No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="house_no2" value="{{ $employee->house_no2 }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Street:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="street2" value="{{ $employee->street2 }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Subdivision/Village</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="subdivision2" value="{{ $employee->subdivision2 }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Province</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="province2" id="province2">
                        @foreach($provinces as $province)
                          <option @if($brgys2->provCode==$province->provCode) selected @endif value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">City/Municipality</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="citymun2" id="citymun2">
                        @foreach($cityMuns2 as $citymun2)
                          <option class="onChangeCityMun2" @if($brgys2->citymunCode==$citymun2->citymunCode) selected @endif value="{{ $citymun2->citymunCode }}">{{ $citymun2->citymunDesc }}</option>
                        @endforeach
                      </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Barangay</label>
                    <div class="col-sm-4">
                      <select disabled="true" class="form-control-plaintext fieldToEdit" name="brgy2" id="brgy2">
                        <option class="onChangeBrgy2" value="{{ $brgys2->id }}">{{ $brgys2->brgyDesc }}</option>
                      </select>
                    </div>
                  </div>
                  <h6>Other Information</h6>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Height:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="height" value="{{ $employee->height }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Weight:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="weight" value="{{ $employee->weight }}">
                    </div>
                   </div>
                   <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Blood Type:</label>
                    <div class="col-sm-4">
                        <select class="form-control-plaintext fieldToEdit" name="blood_type">
                          <option @if($employee->blood_type=='A') selected @endif value="A">A</option>
                          <option @if($employee->blood_type=='B') selected @endif value="B">B</option>
                          <option @if($employee->blood_type=='AB') selected @endif value="AB">AB</option>
                          <option @if($employee->blood_type=='O') selected @endif value="O">O</option>
                        </select>
                    </div>
                   </div>
                   <div class="form-group row">
                    <label class="col-sm-2 col-form-label">GSIS ID No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="gsis" value="{{ $employee->gsis }}">
                    </div>
                    <label class="col-sm-2 col-form-label">PAG-IBIG ID No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="pagibig" value="{{ $employee->pagibig }}">
                    </div>
                   </div>
                   <div class="form-group row">
                    <label class="col-sm-2 col-form-label">PHILHEALTH No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="phic" value="{{ $employee->phic }}">
                    </div>
                    <label class="col-sm-2 col-form-label">SSS No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="sss" value="{{ $employee->sss }}">
                    </div>
                   </div>
                   <div class="form-group row">
                    <label class="col-sm-2 col-form-label">TIN No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="tin" value="{{ $employee->tin }}">
                    </div>
                    <label class="col-sm-2 col-form-label">Account No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="acct_no" value="{{ $employee->acct_no }}">
                    </div>
                   </div>
                   <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Telephone No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="telphone" value="{{ $employee->telphone }}">
                    </div>
                   <label class="col-sm-2 col-form-label">Mobile No:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="contact_no" value="{{ $employee->contact_no }}">
                    </div> 
                   </div>
                   <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email Address:</label>
                   <div class="col-sm-4">
                    <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="email" value="{{ $employee->email }}">
                   </div>
                 </div>
                </form>
              </div>
              <div class="tab-pane" id="dtr" role="tabpanel">
                <div id="printDtr">
                  <table id="tblDtr" style="width: 100%" class="table table-bordered">
                    <thead>
                      <tr>
                        <th>DAY</th>
                        <th><b>AM IN</b></th>
                        <th><b>AM OUT</b></th>
                        <th><b>PM IN</b></th>
                        <th><b>PM OUT</b></th>
                        <th><b>OT IN</b></th>
                        <th><b>OT OUT</b></th>
                        <th><b>TOTAL (HRS)</b></th>
                        <th><b>OT (HRS)</b></th>
                      </tr>
                    </thead>
                    <tbody> 
                    @foreach($attendances as $attendance)
                    <tr>
                      <td><a href="{{ url('dtr/'.$attendance->id) }}">{{ Carbon\Carbon::parse($attendance->dtr_date)->day }}</a></td>
                      <td>
                        @if($attendance->timein_am!=null)
                          {{ Carbon\Carbon::parse($attendance->timein_am)->format('h:i A') }}
                        @endif
                      </td>
                      <td>
                        @if($attendance->timeout_am!=null)
                          {{ Carbon\Carbon::parse($attendance->timeout_am)->format('h:i A') }}
                        @endif
                      </td>
                      <td>
                        @if($attendance->timein_pm!=null)
                          {{ Carbon\Carbon::parse($attendance->timein_pm)->format('h:i A') }}
                        @endif
                      </td>
                      <td>
                        @if($attendance->timeout_pm!=null)
                          {{ Carbon\Carbon::parse($attendance->timeout_pm)->format('h:i A') }}
                        @endif
                      </td>
                      <td>
                        @if($attendance->timein_ot!=null)
                          {{ Carbon\Carbon::parse($attendance->timein_ot)->format('h:i A') }}
                        @endif
                      </td>
                      <td>
                        @if($attendance->timeout_ot!=null)
                          {{ Carbon\Carbon::parse($attendance->timeout_ot)->format('h:i A') }}
                        @endif
                      </td>
                      <td>{{ $attendance->total_hrs }}</td>
                      <td>{{ $attendance->total_ot }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="payroll" role="tabpanel">
                <table id="tblPayroll" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee No.</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Basic Pay</th>
                        <th>Accrued Income</th>
                        <th>Earnings</th>
                        <th>Gross Income</th>
                        <th>Total Deductions</th>
                        <th>Net Income</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($payrolls as $payroll)
                    <tr>
                        <td><a href="{{ url('payroll/payslip/'.$payroll->id) }}">{{ Carbon\Carbon::parse($payroll->payroll_date)->format('F Y') }}</a></td>
                        <td>{{ $payroll->emp_no }}</td>
                        <td>{{ $payroll->last_name }}, {{ $payroll->first_name }} {{ $payroll->middle_name[0] }}</td>
                        <td>{{ $payroll->department }}</td>
                        <td>{{ $payroll->position }}</td>
                        <td>{{ number_format($payroll->basic_pay,2) }}</td>
                        <td>
                          @php
                            $totalaccrued = $payroll->salary_diff + $payroll->salary_increase + $payroll->personnel_allowance + $payroll->refund;

                            echo number_format($totalaccrued,2); 
                          @endphp
                        </td>
                        <td>
                          @php
                            $totalEarnings = $payroll->hazard + $payroll->subs_laundry + $payroll->other_benefits;

                            echo number_format($totalEarnings,2);
                          @endphp
                        </td>
                        <td>
                          @php
                            $gross = $payroll->basic_pay + $totalaccrued + $totalEarnings;
                            echo number_format($gross,2);
                          @endphp
                        </td>
                        <td>
                          @php
                            $totalDeductions = $payroll->gsis + $payroll->tax + $payroll->philhealth + $payroll->pagibig + $payroll->pagibig2 + $payroll->hdmf + $payroll->salary_loan + $payroll->policy_loan + $payroll->cash_advance + $payroll->umid_cash + $payroll->conso_loan + $payroll->emergency_loan + $payroll->housing_loan + $payroll->sdmpc_loan + $payroll->sdmpc_coop + $payroll->landbank + $payroll->dorm_fee + $payroll->mortuary_fund + $payroll->bereavement_asst + $payroll->assoc_due;

                            echo number_format($totalDeductions,2);
                          @endphp
                        </td>
                        <td>
                          @php
                            $net = $gross - $totalDeductions;

                            echo number_format($net,2);
                          @endphp
                          <!-- <a 
                            href="{{ url('employee/delete/'.$payroll->emp_no) }}" 
                            class="btn btn-sm btn-danger btn-fab btn-icon btn-round forAdmin forHRS"
                            onclick="return confirm('Are you sure you want to delete this record?');"
                            hidden="true">
                            <i class="fa fa-trash"></i>
                          </a> -->
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
    </div>

</div>
</form>

<form action="{{ url('attendance/edit') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalEditDTR" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">DTR Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" name="dtr_id" id="dtr_id" class="form-control" hidden />
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Time In</label>
                <input type="time" name="dtr_in" id="dtr_in" class="form-control" required/>
              </div>
              <div class="col-md-6">
                <label>Time Out</label>
                <input type="time" name="dtr_out" id="dtr_out" class="form-control" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Date</label>
                <input type="date" name="dtr_date" id="dtr_date" class="form-control" required/>
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
  
  $('#tblDtr').DataTable();
  $('#tblPayroll').DataTable();

  $('#btnEditFields').on('click', function() {
    $('.fieldToEdit').prop('readonly',false);
    $('.fieldToEdit').prop('disabled',false);
    $('.fieldToEdit').prop('class','form-control fieldToEdit');
    $('#divEditProfileImg').prop('hidden',false);
    $('#divEditFields').prop('hidden',false);
    $('#btnEditFields').hide();
  });

  $('#btnCancelEdit').on('click', function() {
    $('.fieldToEdit').prop('readonly',true);
    $('.fieldToEdit').prop('disabled',true);
    $('.fieldToEdit').prop('class','form-control-plaintext fieldToEdit');
    $('#divEditProfileImg').prop('hidden',true);
    $('#divEditFields').prop('hidden',true);
    $('#btnEditFields').show();
  });

  $(document).on("click", ".btn-modalOpen", function () {

    $("#dtr_id").val( $(this).data('id') );
    $("#dtr_in").val( $(this).data('in') );
    $("#dtr_out").val( $(this).data('out') );
    $("#dtr_date").val( $(this).data('date') );
  });

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
</script>
@endsection