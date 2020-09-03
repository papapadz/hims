@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Schedules
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm" type="button" id="dropdownMenuButton" data-toggle="modal" data-target="#modalAddSched">
              <i class="fa fa-plus"></i> Add
            </button>
            <button class="btn btn-outline-warning btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalSearch">
              <i class="fa fa-search"></i> Search
            </button>
          </div> 
        </h5>
      </div>
      <div class="card-body ">
         <table id="tblSchedules" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee No.</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->sched_date }}</td>
                    <td>{{ $schedule->emp_no }}</td>
                    <td>{{ $schedule->last_name }}, {{ $schedule->first_name }} {{ $schedule->middle_name[0] }}</td>
                    <td>{{ $schedule->department }}</td>
                    <td>{{ $schedule->position }}</td>
                    <td>{{ Carbon\Carbon::parse($schedule->sched_in)->format('H:i A') }}</td>
                    <td>{{ Carbon\Carbon::parse($schedule->sched_out)->format('H:i A') }}</td>
                    <td>
                      <a 
                        href="{{ url('schedule/delete/'.$schedule->id) }}" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round forAdmin forHRS"
                        onclick="return confirm('Are you sure you want to delete this record?');"
                        hidden="true">
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

<form action="{{ url('schedule/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddSched" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Schedule Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-2">
            <div class="col-md-12">
              <select class="form-control select_emp_no" id="emp_no" name="emp_no" style="width: 100%" required>
                <option selected disabled>Select an Employee</option>
                @foreach($employees as $employee)
                  <option value="{{ $employee->emp_no }}">{{ $employee->emp_no }} - {{ $employee->last_name }}, {{ $employee->first_name }} </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <label>Date</label>
              <input type="date" name="sched_date" class="form-control" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <label>Time In</label>
              <input type="time" name="sched_in" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Time Out</label>
              <input type="time" name="sched_out" class="form-control" required>
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

<form action="{{ url('schedule/search') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalSearch" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Search Payroll</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <select class="form-control select_emp_no" style="width: 100%" name="emp_no">
              <option selected disabled>Search by Employee No.</option>
                @foreach($employees as $employee)
                  <option value="{{ $employee->emp_no }}">{{ $employee->emp_no }} - {{ $employee->last_name }}, {{ $employee->first_name }} </option>
                @endforeach
            </select>
          </div>
        </div>
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
              <label>Search by Date</label>
              <input type="date" name="sched_date" class="form-control">
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
  $(document).ready(function() {
    $( ".select_emp_no" ).select2({
        theme: 'bootstrap'
    });
    $('#tblSchedules').DataTable();
    
  });
</script>
@endsection