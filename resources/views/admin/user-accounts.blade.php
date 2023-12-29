@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">User Accounts 
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-plus"></i> Add
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalAddUserAccount">Add User Account</a>
              {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalAddPatientAccount">Add Patient Account</a> --}}
            </div>
          </div>
        </h5>
      </div>
      <div class="card-body ">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#users" role="tab" aria-selected="true">User Accounts</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#patients" role="tab" aria-selected="false">Patient Accounts</a>
          </li> --}}
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
        <br>
          <div class="tab-pane active" id="users" role="tabpanel">
            <table id="tblUserAccounts" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Employee No.</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Account Type</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                      @if($user->account_type==3)
                        <i class="fa fa-circle text-primary"></i>
                      @elseif($user->account_type==2)
                        <i class="fa fa-circle text-warning"></i>
                      @else
                        <i class="fa fa-circle text-success"></i>
                      @endif
                      {{ $user->emp_no }}
                    </td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->last_name }}, {{ $user->first_name }} {{ $user->middle_name[0] }}</td>
                    <td>{{ $user->position }}</td>
                    <td>{{ $user->department }}</td>
                    <td>
                      @if($user->account_type==3)
                        Patient Account
                      @elseif($user->account_type==2)
                        Employee Account
                      @else
                        Admin
                      @endif
                    </td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-id="{{ $user->id }}" 
                        data-empno="{{ $user->emp_no }}" 
                        data-username="{{ $user->username }}" 
                        data-accounttype="{{ $user->account_type }}" 
                        data-toggle="modal" 
                        data-target="#modalEditAccount">
                          <i class="fa fa-edit"></i>
                        </button>
                      <a class="btn btn-sm btn-danger btn-fab btn-icon btn-round" href="{{ url('user-accounts/delete/'.$user->id) }}" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="patients" role="tabpanel">
            <table id="tblPatientAccounts" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Hospital No.</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($patients as $patient)
                <tr>
                    <td>
                      <i class="fa fa-circle text-primary"></i>
                      {{ $patient->hosp_no }}
                    </td>
                    <td>{{ $patient->username }}</td>
                    <td>{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name[0] }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen2" 
                        data-id="{{ $patient->id }}" 
                        data-hospno="{{ $patient->hosp_no }}" 
                        data-username="{{ $patient->username }}" 
                        data-toggle="modal" 
                        data-target="#modalEditPatientAccount">
                          <i class="fa fa-edit"></i>
                        </button>
                      <a class="btn btn-sm btn-danger btn-fab btn-icon btn-round" href="{{ url('user-accounts/delete/'.$patient->id) }}" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <div class="legend">
          {{-- <i class="fa fa-circle text-primary"></i> Patient Account --}}
          <i class="fa fa-circle text-warning"></i> Employee Account
          <i class="fa fa-circle text-success"></i> Admin
        </div>
      </div>
  </div>
</div>

<form action="{{ url('user-accounts/add') }}" method="POST">
  @csrf
<div id="modalAddUserAccount" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Employee No.</label>
            <input type="text" name="emp_no" class="form-control" required />
            <label>Username</label>
            <input type="text" name="username" class="form-control" required/>
            <label>Password</label>
            <input type="password" name="password" class="form-control" required/>
            <label>Account Type</label>
            <select name="account_type" class="form-control" required>
              <option value="1">Admin</option>
              <option value="2">Employee Account</option>
              {{-- <option value="3">Patient Account</option> --}}
            </select>
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

<form action="{{ url('user-accounts/edit') }}" method="POST">
  @csrf
  <input type="text" name="username_id" id="username_id" class="form-control" hidden/>
<div id="modalEditAccount" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Employee No.</label>
            <input type="text" name="emp_no" id="edit_emp_no" class="form-control" required />
            <label>Username</label>
            <input type="text" name="username" id="edit_username" class="form-control" required/>
            <label>Password</label>
            <input type="password" name="password" class="form-control" required/>
            <label>Account Type</label>
            <select name="account_type" id="edit_account_type" class="form-control" required>
              <option value="1">System Administrator</option>
              <option value="2">Employee Account</option>
              {{-- <option value="3">Patient Account</option> --}}
            </select>
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

<form action="{{ url('patient/add-account') }}" method="POST">
  @csrf
<div id="modalAddPatientAccount" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patient Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Hospital No.</label>
            <input type="text" name="hosp_no" class="form-control" required />
            <label>Username</label>
            <input type="text" name="username" class="form-control" required/>
            <label>Password</label>
            <input type="password" name="password" class="form-control" required/>
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

<form action="{{ url('patient/edit-account') }}" method="POST">
  @csrf
  <input type="text" name="username_id" id="username_pat_id" class="form-control" hidden/>
<div id="modalEditPatientAccount" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patient Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Hospital No.</label>
            <input type="text" name="hosp_no" id="edit_hosp_no" class="form-control" required />
            <label>Username</label>
            <input type="text" name="username" id="edit_pat_username" class="form-control" required/>
            <label>Password</label>
            <input type="password" name="password" class="form-control" required/>
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

  $('#tblUserAccounts').DataTable();
  $('#tblPatientAccounts').DataTable();

  $(document).on("click", ".btn-modalOpen", function () {

    $("#username_id").val( $(this).data('id') );
    $("#edit_emp_no").val( $(this).data('empno') );
    $("#edit_username").val( $(this).data('username') );
    $("#edit_account_type").val( $(this).data('accounttype') );

  });

  $(document).on("click", ".btn-modalOpen2", function () {

    $("#username_pat_id").val( $(this).data('id') );
    $("#edit_hosp_no").val( $(this).data('hospno') );
    $("#edit_pat_username").val( $(this).data('username') );

  });
</script>
@endsection