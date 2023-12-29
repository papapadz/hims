@extends('layouts.app')

@section('content')
<div class="row">

  <div class="col-md-3">
    <div class="row">
      <div class="col-12">
        <div class="card" >
          <img class="card-img-top" style="width: 90%; align-self: center" src="{{ asset('assets/img/faces/'.$patient->profile_img) }}" alt="">
          <div class="card-body">
            <h3 class="card-text text-center">{{ $patient->hosp_no }}</h3>
          </div>
        </div>
      </div>
    </div>
    @if($patient->discharge_date == NULL)
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-primary btn-round float-center forAdmin forMED" data-toggle="modal" data-target="#modalAddDiagnosis" hidden="true">
              Add Diagnosis
            </button>
        </div>
      </div>
      {{-- <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-primary btn-round float-center forAdmin forMED" data-toggle="modal" data-target="#modalAddLabRequest" hidden="true">
              Add Lab Request
            </button>
        </div>
      </div> --}}
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-primary btn-round float-center forAdmin forMED" data-toggle="modal" data-target="#modalAddXRayRequest" hidden="true">
              Add X-Ray Request
            </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-primary btn-round float-center forAdmin forMED" data-toggle="modal" data-target="#modalAddMiscRequest" hidden="true">
              Add Miscellaneous Request
            </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-primary btn-round float-center forAdmin forMED" data-toggle="modal" data-target="#modalAddPrescription" hidden="true">
              Add Prescription
            </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-primary btn-round float-center forAdmin forPHR forNRS" data-toggle="modal" data-target="#modalSellSupply" hidden="true">
            Add Medicine
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-danger btn-round float-center forAdmin forBLL" data-toggle="modal" data-target="#modalBillOut" hidden="true">
            Bill Out
          </button>
        </div>
      </div>
    @else
      <div class="row">
        <div class="col-md-12">
          <button style="width: 100%" class="btn btn-warning btn-round float-center" onclick="printThis('printable','Billing Statement','','2');">Print Billing Statement</button>
        </div>
      </div>
    @endif
  </div>

  <div class="col-md-9">
    
    <div class="row">
    	<div class="col-12">
    		<div class="card">
    			<div class="card-body">
    				<div class="row mb-2">
    					<div class="col-md-3">
    						<label class="col-form-label">Date of Consultation:</label>
    					</div>
    					<div class="col-md-3">
    						{{ Carbon\Carbon::parse($patient->create_at)->toFormattedDateString() }}
    					</div>
    					<div class="col-md-3">
    						<label class="col-form-label">Ward\Room\Clinic:</label>
    					</div>
    					<div class="col-md-3">
    						{{ $patient->room }}
    					</div>
    				</div>
    				<div class="row mb-2">
    					<div class="col-md-3">
    						<label class="col-form-label">Complaint:</label>
    					</div>
    					<div class="col-md-9">
    						{{ $patient->complaint }}
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header ">
            <h5 class="card-title">{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }} 
              @if($patient->discharge_date == NULL)
                <span class="float-right col-form-label text-success"><i class="fa fa-circle text-success"></i> Active</span>
              @else
                <span class="float-right col-form-label text-muted"><i class="fa fa-circle text-muted"></i> Inactive</span>
              @endif
            </h5>
          </div>
          <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#patient-info" role="tab" aria-selected="true">Patient Info</a>
              </li>
              <li class="nav-item forAdmin forMED forNRS forPatient" hidden="true">
                <a class="nav-link" data-toggle="tab" href="#diagnosis" role="tab" aria-selected="false">Diagnosis</a>
              </li>
              {{-- <li class="nav-item forAdmin forMED forNRS forPatient" hidden="true">
                <a class="nav-link" data-toggle="tab" href="#lab" role="tab" aria-selected="false">Laboratory</a>
              </li> --}}
              <li class="nav-item forAdmin forMED forNRS forPatient" hidden="true">
                <a class="nav-link" data-toggle="tab" href="#xray" role="tab" aria-selected="false">X-Ray</a>
              </li>
              <li class="nav-item forAdmin forMED forNRS forPatient" hidden="true">
                <a class="nav-link" data-toggle="tab" href="#prescription" role="tab" aria-selected="false">Prescriptions</a>
              </li>
              <li class="nav-item forAdmin forBLL forPatient" hidden="true">
                <a class="nav-link" data-toggle="tab" href="#bill" role="tab" aria-selected="false">Bill</a>
              </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <br>
              <div class="tab-pane active" id="patient-info" role="tabpanel">
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
                      <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="gender">
                        <option @if($patient->gender=='Male') selected @endif value="Male">Male</option>
                        <option @if($patient->gender=='Femake') selected @endif value="Female">Female</option>
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
                 <label class="col-sm-2 col-form-label">Blood Type:</label>
                  <div class="col-sm-4">
                    <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="blood_type">
                        <option @if($patient->civil_stat=='A') selected @endif value="A">A</option>
                        <option @if($patient->civil_stat=='B') selected @endif value="B">B</option>
                        <option @if($patient->civil_stat=='AB') selected @endif value="AB">AB</option>
                        <option @if($patient->civil_stat=='O') selected @endif value="O">O</option>
                      </select>
                  </div>
                 </div>
                 <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Address:</label>
                  <div class="col-sm-10">
                    <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="address" value="{{ $patient->address }}">
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
              <div class="tab-pane" id="diagnosis" role="tabpanel" aria-labelledby="profile-tab">
                <table id="tblDiagnosis" class="table" style="width:100%">
                  <thead>
                    <tr>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Doctor</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($diagnosis as $diag)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($diag->created_at)->toDateString() }}</td>
                      <td>{{ $diag->diagnosis }}</td>
                      <td>{{ $diag->last_name }}, {{ $diag->first_name }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="lab" role="tabpanel">
                <table id="tblLabResults" class="table" style="width:100%">
                  <thead>
                    <tr>
                        <th>Date</th>
                        <th>Request</th>
                        <th>Doctor</th>
                        <th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($results->WHERE('category_id',2) as $result)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($result->created_at)->toDateString() }}</td>
                      <td>{{ $result->supply }}</td>
                      <td>{{ $result->last_name }}, {{ $result->first_name }}</td>
                      @if($result->result == null)
                        <td><span class="text-warning">Result pending...</span></td>
                      @else
                        <td>{{ $result->result }} <a class="btn btn-sm btn-primary btn-fab btn-icon btn-round" target="_blank" href="{{ asset('uploads/lab-results/'.$result->result_file) }}"><i class="fa fa-file"></i></a></td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="xray" role="tabpanel">
                <table id="tblXRayResults" class="table" style="width:100%">
                  <thead>
                    <tr>
                        <th>Date</th>
                        <th>Request</th>
                        <th>Doctor</th>
                        <th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($results->WHERE('category_id',3) as $result)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($result->created_at)->toDateString() }}</td>
                      <td>{{ $result->supply }}</td>
                      <td>{{ $result->last_name }}, {{ $result->first_name }}</td>
                      @if($result->result == null)
                        <td><span class="text-warning">Result pending...</span></td>
                      @else
                        <td>{{ $result->result }} <a class="btn btn-sm btn-primary btn-fab btn-icon btn-round" target="_blank" href="{{ asset('uploads/lab-results/'.$result->result_file) }}"><i class="fa fa-file"></i></a></td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="prescription" role="tabpanel">
                <table id="tblPrescriptions" class="table" style="width:100%">
                  <thead>
                    <tr>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Prescription</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($prescriptions as $presc)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($presc->created_at)->toDateString() }}</td>
                      <td>{{ $presc->last_name }}, {{ $presc->first_name }}</td>
                      <td>{{ $presc->prescription }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="bill" role="tabpanel">
                <table id="tblBills" class="table" style="width:100%">
                  <thead>
                    <tr>
                        <th>Date</th>
                        <th>Item</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                        <th class="forAdmin forBLL" hidden="true">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($bills as $bill)
                    <tr>
                      <td>{{ Carbon\Carbon::parse($bill->created_at)->toDateString() }}</td>
                      <td>{{ $bill->supply }}</td>
                      <td>{{ $bill->unit }}</td>
                      <td>{{ $bill->price }}</td>
                      <td>{{ $bill->qty }}</td>
                      <td>{{ $bill->sub_total }}</td>
                      <td class="forAdmin forBLL" hidden="true">
                        @if($patient->discharge_date == NULL)
                          <a href="{{ url('billing/delete/'.$bill->bill_id) }}" class="btn btn-sm btn-danger btn-fab btn-icon btn-round" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                          </a>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><b>Grand Total</b></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- MODALS -->
<form action="{{ url('consult/add-diagnosis') }}" method="POST">
@csrf
<input type="text" name="consult_id" value="{{ $patient->consult_id }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAddDiagnosis">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Consultation ID: {{ $patient->consult_id }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-12">
              <label>Complaint:</label>
              <p>{{ $patient->complaint }}</p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label>Diagnosis:</label>
              <textarea class="form-control" name="diagnosis" required></textarea>
            </div>
            <div class="col-md-6">
              
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

<form action="{{ url('consult/add-lab-request') }}" method="POST">
@csrf
<input type="text" name="consult_id" value="{{ $patient->consult_id }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAddLabRequest">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lab Request for Consultation ID: {{ $patient->consult_id }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-md-12">
            	<select class="form-control" name="result_type">
            		@foreach($resultTypes->WHERE('category_id',2) as $resultType)
            		<option value="{{ $resultType->id }}">{{ $resultType->supply }} - Php {{ $resultType->price }}</option>
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

<form action="{{ url('consult/add-misc-request') }}" method="POST">
  @csrf
  <input type="text" name="consult_id" value="{{ $patient->consult_id }}" hidden>
  <div class="modal" tabindex="-1" role="dialog" id="modalAddMiscRequest">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Miscellaneous Request for Consultation ID: {{ $patient->consult_id }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <select class="form-control" name="result_type">
                  @foreach($resultTypes->WHERE('category_id',4) as $resultType)
                  <option value="{{ $resultType->id }}">{{ $resultType->supply }} - Php {{ $resultType->price }}</option>
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

<form action="{{ url('consult/add-xray-request') }}" method="POST">
@csrf
<input type="text" name="consult_id" value="{{ $patient->consult_id }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAddXRayRequest">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">X-Ray Request for Consultation ID: {{ $patient->consult_id }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-md-12">
              <select class="form-control" name="result_type">
                @foreach($resultTypes->WHERE('category_id',3) as $resultType)
                <option value="{{ $resultType->id }}">{{ $resultType->supply }} - Php {{ $resultType->price }}</option>
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

<form action="{{ url('consult/add-prescription') }}" method="POST">
@csrf
<input type="text" name="consult_id" value="{{ $patient->consult_id }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAddPrescription">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Consultation ID: {{ $patient->consult_id }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-12">
              <label>Prescription</label>
              <textarea name="prescription" class="form-control" required></textarea>
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

<form action="{{ url('patient/bill-out') }}" method="POST">
@csrf
<input type="text" name="consult_id" value="{{ $patient->consult_id }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalBillOut">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Consultation ID: {{ $patient->consult_id }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBillOutBody">
        <div class="row mb-3">
            <div class="col-12">
              <label>OR Number</label>
              <input type="text" name="or_num" class="form-control" placeholder="xxxxxxxxx" required />
            </div>
          </div>
        <div class="row">
          <div class="col-12">
            <label>Payee Name</label>
            <input type="text" name="payee" class="form-control" placeholder="Last Name, First Name MI." required />
          </div>
        </div>
        <hr>
        <div id="printable"> 
          <div class="row">
            <div class="col-12">
              <h5>Billing Statement</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              Hospital No: <b>{{ $patient->hosp_no }}</b>
            </div>
            <div class="col-6">
              Consult Date: <b>{{ Carbon\Carbon::parse($patient->created_at)->toFormattedDateString() }}</b>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              Patient Name: <b>{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }}</b>
            </div>
            <div class="col-6">
              Discharge Date: 
              <b>
                @if($patient->discharge_date == NULL)
                  {{ Carbon\Carbon::now()->toFormattedDateString() }} 
                @else
                  {{ Carbon\Carbon::parse($patient->discharge_date)->toFormattedDateString() }}
                @endif
              </b>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <table class="table" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($billGrouped as $bill)
                    <tr>
                      <td>{{ $bill->supply }}</td>
                      <td>{{ $bill->unit }}</td>
                      <td>{{ number_format($bill->price,2,'.',',') }}</td>
                      <td>{{ $bill->sumQty }}</td>
                      <td>{{ number_format($bill->sumSubTotal,2,'.',',') }}</td>
                    </tr>
                  @endforeach
                  <tr>
                    <td colspan="4"><b>Grand Total</b></td>
                    <td><b style="border-bottom: 3px double;">P {{ number_format($billGrouped->sum('sumSubTotal'),2,'.',',') }}</b></td>
                  </tr>
                </tbody>
              </table> 
            </div>
          </div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Discharge Patient</button>
        @if(Auth::User()->account_type !=3)
        <button type="button" class="btn btn-warning" onclick="printThis('printable','Billing Statement','','2');">Print</button>
        @endif
      </div>
    </div>
  </div>
</div>
</form>

<form action="{{ url('patient/add-medicine') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalSellSupply" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Medicine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" name="hosp_no" value="{{ $patient->hosp_no }}" hidden>
          <div class="row mb-3">
            <div class="col-md-12">
              <label>Supply</label>
              <select class="form-control" name="supply_id" required>
                @foreach($supplies as $supply)
                  <option value="{{ $supply->id }}">{{ $supply->supply }} - {{ $supply->unit }} Php {{ $supply->price }} ({{ $supply->qty }} left)</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label>qty</label>
              <input type="number" name="qty" class="form-control" />
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
<!-- END MODALS -->

@endsection

@section('script')
<script type="text/javascript">
  
  $('#btnEditFields').on('click', function() {
    $('.fieldToEdit').prop('readonly',false);
    $('.fieldToEdit').prop('disabled',false);
    $('.fieldToEdit').prop('class','form-control fieldToEdit');
    $('#divEditFields').prop('hidden',false);
    $('#btnEditFields').hide();
  });

  $('#btnCancelEdit').on('click', function() {
    $('.fieldToEdit').prop('readonly',true);
    $('.fieldToEdit').prop('disabled',true);
    $('.fieldToEdit').prop('class','form-control-plaintext fieldToEdit');
    $('#divEditFields').prop('hidden',true);
    $('#btnEditFields').show();
  });

</script>

<script type="text/javascript">
  $('#tblConsults').DataTable();
  $('#tblDiagnosis').DataTable();
  $('#tblLabResults').DataTable();
  $('#tblXRayResults').DataTable();
  $('#tblPrescriptions').DataTable();
  
  $(document).ready(function() {
  // DataTable initialisation
  $('#tblBills').DataTable(
    {
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api();
        nb_cols = api.columns().nodes().length;
        var j = 4;
        while(j < nb_cols){
          var pageTotal = api
                .column( j )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal);
          j++;
        } 
      }
    }
  );
});

</script>
@endsection
