@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title clearfix">Employees
            <button class="btn btn-outline-warning btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalBatchPrint">
              <i class="fa fa-print"></i> Batch Print
            </button>
            <button class="btn btn-outline-success btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalAddAttendance">
              <i class="fa fa-plus"></i> Add
            </button>
            <button class="btn btn-outline-primary btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalUpload">
              <i class="fa fa-upload"></i> Upload
            </button>
            <button class="btn btn-outline-warning btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalViewDtr">
              <i class="fa fa-search"></i> Search
            </button>
        </h5>
      </div>
      <div class="card-body ">
        <table id="tblDTR" class="table table-bordered" style="width:100%">
              <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee No.</th>
                    <th>Name</th>
                    <th>AM IN</th>
                    <th>AM OUT</th>
                    <th>PM IN</th>
                    <th>PM OUT</th>
                    <th>OT IN</th>
                    <th>OT OUT</th>
                    <th>HRS</th>
                    <th>OT</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($attendances as $attendance)
                <tr>
                    <td><a href="{{ url('dtr/'.$attendance->id) }}">{{ Carbon\Carbon::parse($attendance->dtr_date)->toDateString() }}</a></td>
                    <td>{{ $attendance->emp_no }}</td>
                    <td>{{ $attendance->last_name }}, {{ $attendance->first_name }} {{ $attendance->middle_name[0] }}</td>
                    <td>{{ $attendance->timein_am }}</td>
                    <td>{{ $attendance->timeout_am }}</td>
                    <td>{{ $attendance->timein_pm }}</td>
                    <td>{{ $attendance->timeout_pm }}</td>
                    <td>{{ $attendance->timein_ot }}</td>
                    <td>{{ $attendance->timeout_ot }}</td>
                    <td>{{ $attendance->total_hrs }}</td>
                    <td>{{ $attendance->total_ot }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round"
                        data-toggle="modal" 
                        data-target="#modalEditDtr"
                        data-id = "{{ $attendance->id }}"
                        data-date = "{{ Carbon\Carbon::parse($attendance->dtr_date)->toDateString() }}" 
                        data-tia =  "{{ $attendance->timein_am }}" 
                        data-toa =  "{{ $attendance->timeout_am }}" 
                        data-tip =  "{{ $attendance->timein_pm }}" 
                        data-top =  "{{ $attendance->timeout_pm }}" 
                        data-tit =  "{{ $attendance->timein_ot }}" 
                        data-tot =  "{{ $attendance->timeout_ot }}" 
                      >
                        <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="{{ url('dtr/delete/'.$attendance->id) }}" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round"
                        onclick="return confirm('Are you sure you want to delete this record?');">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                   <!--  <td>
                      <a 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round" 
                        target="_blank" 
                        href="{{ asset('uploads/dtr/') }}">
                          <i class="fa fa-file"></i>
                      </a>
                      <a 
                        href="{{ url('attendance/delete-upload/') }}" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round"
                        onclick="return confirm('Are you sure you want to delete this attendance data?');">
                          <i class="fa fa-trash"></i>
                      </a>
                    </td> -->
                </tr>
                @endforeach
              </tbody>
            </table>
      </div>
    </div>
  </div>
</div>

<form action="{{ url('attendance/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddAttendance" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Attendance Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <select class="form-control select_emp_no" name="emp_no" style="width: 100%" required>
                  <option selected disabled>Select an Employee</option>
                  @foreach($employees as $employee)
                    <option value="{{ $employee->emp_no }}">{{ $employee->emp_no }} - {{ $employee->last_name }}, {{ $employee->first_name }} </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Date</label>
                <input type="date" name="dtr_date" class="form-control" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Morning IN</label>
                <input type="time" name="timein_am" class="form-control" />
              </div>
              <div class="col-md-6">
                <label>Morning OUT</label>
                <input type="time" name="timeout_am" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Afternoon IN</label>
                <input type="time" name="timein_pm" class="form-control" />
              </div>
              <div class="col-md-6">
                <label>Afternoon OUT</label>
                <input type="time" name="timeout_pm" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Overtime IN</label>
                <input type="time" name="timein_ot" class="form-control" />
              </div>
              <div class="col-md-6">
                <label>Overtime OUT</label>
                <input type="time" name="timeout_ot" class="form-control" />
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

<form action="{{ url('dtr/view') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalViewDtr" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Search DTR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <select class="form-control select_emp_no" style="width: 100%" name="emp_no" required>
              <option selected disabled>Select an Employee</option>
                @foreach($employees as $employee)
                  <option value="{{ $employee->emp_no }}">{{ $employee->emp_no }} - {{ $employee->last_name }}, {{ $employee->first_name }} </option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>From</label>
            <input type="date" name="fromdate" class="form-control" required/>
          </div>
          <div class="col-md-6">
            <label>To</label>
            <input type="date" name="todate" class="form-control" required/>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">View</button>
      </div>
    </div>
  </div>
</div>
</form>

<form action="{{ url('dtr/edit') }}" method="POST" enctype="multipart/form-data">
  @csrf
<input type="text" name="dtr_id" id="edit_dtr_id" hidden>
<div id="modalEditDtr" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit DTR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Date</label>
            <input type="date" name="dtr_date" id="edit_dtr_date" class="form-control">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Time In AM</label>
            <input type="time" name="timein_am" id="edit_timein_am" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Time Out AM</label>
            <input type="time" name="timeout_am" id="edit_timeout_am" class="form-control">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Time In PM</label>
            <input type="time" name="timein_pm" id="edit_timein_pm" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Time Out PM</label>
            <input type="time" name="timeout_pm" id="edit_timeout_pm" class="form-control">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Time In OT</label>
            <input type="time" name="timein_ot" id="edit_timein_ot" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Time Out OT</label>
            <input type="time" name="timeout_ot" id="edit_timeout_ot" class="form-control">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>
</form>

<form action="{{ url('dtr/upload') }}" method="POST" enctype="multipart/form-data">
  @csrf
<input type="text" name="file_type" value="DTR" hidden />
<div id="modalUpload" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Upload CSV File</label>
            <div class="custom-file">
              <input type="file" name="fileupload" class="custom-file-input" required>
              <label class="custom-file-label f1" >Choose a csv file...</label>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
      </div>
    </div>
  </div>
</form>

<form action="{{ url('dtr/batch-print') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalBatchPrint" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Batch Print</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <select class="form-control select_emp_no" style="width: 100%" name="department">
              <option selected disabled>Search by Department</option>
                @foreach($departments as $department)
                  <option value="{{ $department->id }}">{{ $department->department }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <hr>
        <div class="row mb-3">
          <div class="col-md-12">
            <select class="form-control" name="month" required>
                <option selected disabled>Select Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
              <select class="form-control" name="year" required>
                <option selected disabled>Select Year</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection

@section('script')
<script type="text/javascript">
  $('#tblDTR').DataTable();
  $( ".select_emp_no" ).select2({
      theme: 'bootstrap'
  });

  $('#modalEditDtr').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  
  $('#edit_dtr_id').val(button.data('id'));
  $('#edit_dtr_date').val(button.data('date'));
  $('#edit_timein_am').val(button.data('tia')); // Extract info from data-* attributes
  $('#edit_timeout_am').val(button.data('toa'));
  $('#edit_timein_pm').val(button.data('tip')); // Extract info from data-* attributes
  $('#edit_timeout_pm').val(button.data('top'));
  $('#edit_timein_ot').val(button.data('tit')); // Extract info from data-* attributes
  $('#edit_timeout_ot').val(button.data('tot'));
  

})
</script>
@endsection