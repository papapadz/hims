@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Positions
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm float-right" data-toggle="modal" data-target="#modalAddPosition">
            <i class="fa fa-plus"></i> Add
          </button>
          </div> 
        </h5>
      </div>
      <div class="card-body ">
       <table id="tblPositions" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Salary Grade</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($positions as $position)
                <tr>
                    <td>{{ $position->id }}</td>
                    <td>{{ $position->position }}</td>
                    <td>P {{ number_format($position->salary,2) }}</td>
                    <td>{{ $position->salary_grade }}</td>
                    <td>{{ $position->created_at }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-toggle="modal" 
                        data-id="{{ $position->id }}" 
                        data-position="{{ $position->position }}"
                        data-salary="{{ $position->salary }}"
                        data-target="#modalEditPosition">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="{{ url('settings/positions/delete/'.$position->id) }}" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round"
                        onclick="return confirm('Are you sure you want to delete this record?');">
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

<form action="{{ url('settings/positions/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddPosition" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Position Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Position</label>
                <input type="text" name="position" class="form-control" placeholder="Position" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Salary Grade</label>
                <input type="number" name="salary_grade" class="form-control" placeholder="Salary Grade" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Salary</label>
                <input type="number" name="salary" class="form-control" placeholder="Salary" required />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form action="{{ url('settings/positions/edit') }}" method="POST" enctype="multipart/form-data">
  @csrf
<input type="text" name="position_id" id="position_id" hidden>
<div id="modalEditPosition" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Position Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Position</label>
                <input type="text" name="position" id="position" class="form-control" placeholder="Position" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Salary</label>
                <input type="number" name="salary" id="salary" class="form-control" placeholder="Salary" required />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('script')
<script type="text/javascript">
  $('#tblPositions').DataTable();

  $(document).on("click", ".btn-modalOpen", function () {

    $("#position_id").val( $(this).data('id') );
    $("#position").val( $(this).data('position') );
    $("#salary").val( $(this).data('salary') );
  });
</script>
@endsection