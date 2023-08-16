@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Facilities
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm float-right" data-toggle="modal" data-target="#modalAddRoom">
            <i class="fa fa-plus"></i> Add
          </button>
          </div> 
        </h5>
      </div>
      <div class="card-body ">
       <table class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Classification</th>
                    <th>Bed Capacity</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($facilities as $facility)
                <tr>
                    <td>{{ $facility->facility_name }}</td>
                    <td>{{ $facility->facility_code }}</td>
                    <td>{{ $facility->brgy }}</td>
                    <td>{{ $facility->facility_type }}</td>
                    <td>{{ $facility->facility_classification }}</td>
                    <td>{{ $facility->bed_capacity }}</td>
                    <td>{{ $facility->contact_num }}</td>
                    <td>{{ $facility->email_address }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-toggle="modal" 
                        data-id="{{ $facility->id }}" 
                        data-name="{{ $facility->name }}"
                        data-code="{{ $facility->facility_code }}"
                        data-type="{{ $facility->facility_type }}"
                        data-classification="{{ $facility->facility_classification }}"
                        data-capacity="{{ $facility->bed_capacity }}"
                        data-email="{{ $facility->email_address }}"
                        data-contact="{{ $facility->contact_num }}"
                        data-target="#modalEdit">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="{{ url('facility/delete/'.$facility->id) }}" 
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

<form action="{{ url('settings/rooms/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddRoom" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Room Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room</label>
                <input type="text" name="room" class="form-control" placeholder="Room" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Type</label>
                <select class="form-control" name="room_type_id" required>
                  <option value="1">Service Ward</option>
                  <option value="2">Pay Ward</option>
                  <option value="3">OPD</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Fee</label>
                <input type="number" name="fee" class="form-control" placeholder="Room Fee" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Max Occupancy</label>
                <input type="number" name="max_occupancy" class="form-control" placeholder="Max Occupancy" required />
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

<form action="{{ url('settings/rooms/edit') }}" method="POST" enctype="multipart/form-data">
  @csrf
<input type="text" name="room_id" id="room_id" hidden>
<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Room Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room</label>
                <input type="text" name="room" id="room" class="form-control" placeholder="Room" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Type</label>
                <select class="form-control" name="room_type_id" id="room_type_id" required>
                  <option value="1">Service Ward</option>
                  <option value="2">Pay Ward</option>
                  <option value="3">OPD</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Fee</label>
                <input type="number" name="fee" id="fee" class="form-control" placeholder="Room Fee" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Max Occupancy</label>
                <input type="number" name="max_occupancy" id="max_occupancy" class="form-control" placeholder="Max Occupancy" required />
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

    $("#room_id").val( $(this).data('id') );
    $("#room").val( $(this).data('room') );
    $("#room_type_id select").val( $(this).data('roomType') );
    $("#max_occupancy").val( $(this).data('max') );
    $("#fee").val( $(this).data('fee') );
  });
</script>
@endsection