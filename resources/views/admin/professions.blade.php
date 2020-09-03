@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Professions
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm float-right" data-toggle="modal" data-target="#modalAddProfession">
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
                    <th>Profession</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($professions as $profession)
                <tr>
                    <td>{{ $profession->id }}</td>
                    <td>{{ $profession->profession }}</td>
                    <td>
                      <a 
                        href="{{ url('settings/profession/delete/'.$profession->id) }}" 
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

<form action="{{ url('settings/profession/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddProfession" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Profession Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <input type="text" name="profession" class="form-control" placeholder="Profession" required />
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