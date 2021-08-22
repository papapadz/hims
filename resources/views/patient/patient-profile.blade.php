@extends('layouts.app')

@section('content')
<form action="{{ url('patients/profile/save') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="text" name="hosp_no" value="{{ $patient->hosp_no }}" hidden>
<div class="row">

  <div class="col-md-3">
    <div class="row">
      <div class="col-12">
        <div class="card" >
          <img class="card-img-top" style="width: 90%; align-self: center" src="{{ asset('assets/img/faces/'.$patient->profile_img) }}" alt="Card image cap">
          <div class="card-body">
            <h3 class="card-text text-center">{{ $patient->hosp_no }}</h3>
          </div>
          <div id="divEditProfileImg" class="card-footer" hidden="true">
            <label>Change Profile Image</label>
            <input type="file" name="profile_img" />
          </div>
        </div>
      </div>
    </div>
    @if($patient->patient_stat==null)
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-success btn-round float-center forAdmin forPAT" id="btnAdmitPatient" data-toggle="modal" data-target="#modalAdmitPatient" hidden="true">
              Admit Patient
            </button>
        </div>
      </div>
    @endif
    <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-success btn-round float-center forAdmin forPAT" data-toggle="modal" data-target="#modalAddAppointment" hidden="true">
              Add Appointment
            </button>
        </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="row" style="width: 100%">
      <div class="card col-12">
        <div class="card-header ">
          <h5 class="card-title">{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }} 
            <button type="button" class="btn btn-outline-primary btn-round btn-sm float-right forAdmin forPat" id="btnEditFields" hidden="true">
              <i class="fa fa-pencil"></i> Edit
            </button>
            <div id="divEditFields" hidden="true">
              <button type="submit" class="btn btn-outline-success btn-round btn-sm float-right" id="btnSaveFields">
                <i class="fa fa-save"></i> Save
              </button>
              <button type="button" class="btn btn-outline-danger btn-round btn-sm float-right" id="btnCancelEdit">
                <i class="fa fa-times"></i> Cancel
              </button>
            </div>
          </h5>
        </div>
        <div class="card-body ">
         <form>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Last Name:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="last_name" value="{{ $patient->last_name }}">
            </div>
            <label class="col-sm-2 col-form-label">First Name:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="first_name" value="{{ $patient->first_name }}">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Middle Name:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="middle_name" value="{{ $patient->middle_name }}">
            </div>
            <label class="col-sm-2 col-form-label">Gender:</label>
            <div class="col-sm-4">
                <select readonly="true" class="form-control-plaintext fieldToEdit" name="gender">
                  <option @if($patient->gender=='Male') selected @endif value="Male">Male</option>
                  <option @if($patient->gender=='Female') selected @endif value="Female">Female</option>
                </select>
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Birthdate:</label>
            <div class="col-sm-4">
              <input type="date" readonly="true" class="form-control-plaintext fieldToEdit" name="birthdate" value="{{ $patient->birthdate }}">
            </div>
            <label class="col-sm-2 col-form-label">Age:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext" value="{{ Carbon\Carbon::now()->diffInYears($patient->birthdate) }} yrs old">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Civil Status:</label>
            <div class="col-sm-4">
              <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="civil_stat">
                  <option @if($patient->civil_stat=='Single') selected @endif value="Single">Single</option>
                  <option @if($patient->civil_stat=='Married') selected @endif value="Married">Married</option>
                  <option @if($patient->civil_stat=='Separated') selected @endif value="Separated">Separated</option>
                  <option @if($patient->civil_stat=='Widowed') selected @endif value="Widowed">Widowed</option>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">Contact No:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="contact_no" value="{{ $patient->contact_no }}">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Address:</label>
            <div class="col-sm-10">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="address" value="{{ $patient->address->brgyDesc }}, {{ $patient->address->cityMun->citymunDesc }}, {{ $patient->address->cityMun->province->provDesc }}">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">PhilHealth No:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="philhealth_no" value="{{ $patient->philhealth_no }}">
            </div>
            <label class="col-sm-2 col-form-label">Blood Type:</label>
            <div class="col-sm-4">
              <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="blood_type">
                  <option @if($patient->blood_type=='A') selected @endif value="A">A</option>
                  <option @if($patient->blood_type=='B') selected @endif value="B">B</option>
                  <option @if($patient->blood_type=='AB') selected @endif value="AB">AB</option>
                  <option @if($patient->blood_type=='O') selected @endif value="O">O</option>
                </select>
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Patient Type:</label>
            <div class="col-sm-4">
              <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="patient_type">
                <option @if($patient->patient_type==1) selected @endif value="1">Regular Patient</option>
                <option @if($patient->patient_type==2) selected @endif value="2">Mental Patient</option>
              </select>
            </div>
           </div>
         </form> 
        </div>
      </div>
    </div>

  <div class="row" style="width: 100%">
    <div class="card col-12">
        <div class="card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#consults" role="tab" aria-selected="true">Consultations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#appointments" role="tab" aria-selected="false">Appointments</a>
              </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <br>
            <div class="tab-pane active" id="consults" role="tabpanel">
              <table id="tblConsults" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Complaint</th>
                    <th>Ward/Room/Clinic</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($consults as $consult)
                    <tr
                    @if($consult->discharge_date != NULL)
                      class="bg-danger"
                    @endif>
                      <td>{{ Carbon\Carbon::parse($consult->created_at)->toDateString() }}</td>
                      <td>{{ $consult->complaint }}</td>
                      <td>{{ $consult->room }}</td>
                      <td>
                        @if($consult->discharge_date == NULL)
                          Active
                        @else
                          Inactive
                        @endif
                      </td>
                      <td>
                        <a href="{{ url('patients/consult/'.$consult->id) }}" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                          <i class="fa fa-arrow-right"></i>
                        </a>
                        <a href="{{ url('patient/chart/'.$consult->id) }}" class="btn btn-sm btn-warning btn-fab btn-icon btn-round forAdmin forMED forNRS forPAT" hidden="true">
                          <i class="fa fa-file"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="tab-pane" id="appointments" role="tabpanel">
              <table id="tblAppointments" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($appointments as $appointment)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($appointment->consult_date)->toDateString() }} @ {{ Carbon\Carbon::parse($appointment->consult_date)->toTimeString() }}</td>
                      <td>{{ $appointment->last_name }}, {{ $appointment->first_name }} {{ $appointment->last_name[0] }}</td>
                      <td>{{ $appointment->remarks }}</td>
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

<!-- MODALS -->
<form action="{{ url('patients/admit') }}" method="POST">
  @csrf
  <input type="text" name="hosp_no" value="{{ $patient->hosp_no }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAdmitPatient">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Admit Patient {{ $patient->hosp_no }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-12">
              <label>Complaint</label>
              <textarea name="complaint" class="form-control"></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Admission Type</label>
              <select class="form-control" name="consult_type">
                <option value="OPD">Out Patient</option>
                <option value="ADM">In Patient</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>Ward/Room/Clinic</label>
              <select class="form-control" name="room_id">
                @foreach($rooms as $room)
                  <option value="{{ $room->id }}">{{ $room->room }}</option>
                @endforeach
              </select>
            </div>
          </div>    
        </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>

<form action="{{ url('consult/add-appointment') }}" method="POST">
  @csrf
  <input type="text" name="hosp_no" value="{{ $patient->hosp_no }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAddAppointment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Schedule Patient {{ $patient->hosp_no }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-12">
              <label>Doctor</label>
              <select class="form-control" name="emp_no">
                @foreach($employees as $employee)
                  <option value="{{ $employee->emp_no }}">{{ $employee->last_name }}, {{ $employee->first_name }} {{ $employee->middle_name[0] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
              <div class="col-12">
                <label>Date</label>
                <input type="date" name="consult_date" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label>Time</label>
                <input type="time" name="consult_time" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label>Remarks</label>
                <textarea class="form-control" name="appointment_remarks"></textarea>
              </div>
            </div>
        </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- END MODALS -->
@endsection

@section('script')
<script type="text/javascript">
  
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

</script>

<script type="text/javascript">
  $('#tblConsults').DataTable({
    "order": [[ 0, "desc" ]]
  });
  $('#tblAppointments').DataTable({
    "order": [[ 0, "desc" ]]
  });
</script>
@endsection