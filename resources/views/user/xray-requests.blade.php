@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Lab Requests</h5>
      </div>
      <div class="card-body ">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#pending" role="tab" aria-selected="true">Pending Requests</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#all" role="tab" aria-selected="false">All Requests</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
        <br>
          <div class="tab-pane active" id="pending" role="tabpanel">
            <table id="tblAllRequests" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Request</th>
                    <th>Patient Name</th>
                    <th>Requested By</th>
                    <th>Date</th>
                    <th>Result</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($xrayRequests->WHERE('result',null) as $xrayRequest)
                <tr>
                    <td>{{ $xrayRequest->id }}</td>
                    <td>{{ $xrayRequest->supply }}</td>
                    <td>{{ $xrayRequest->patient_last_name }}, {{ $xrayRequest->patient_first_name }} {{ $xrayRequest->patient_middle_name[0] }}</td>
                    <td>{{ $xrayRequest->emp_last_name }}, {{ $xrayRequest->emp_first_name }} {{ $xrayRequest->emp_middle_name[0] }}</td>
                    <td>{{ Carbon\Carbon::parse($xrayRequest->created_at)->toFormattedDateString() }}</td>
                    <td>
                      @if($xrayRequest->result==null)
                        <span class="text-warning">Result pending...</span>
                      @else
                        {{ $xrayRequest->result }}
                      @endif
                    </td>
                    <td>
                      @if($xrayRequest->result==null)
                        <button class="btn btn-sm btn-success btn-fab btn-icon btn-round btn-modalOpen" data-toggle="modal" data-id="{{ $xrayRequest->id }}" data-target="#modalAddResult"><i class="fa fa-plus"></i></button>
                        <a class="btn btn-sm btn-danger btn-fab btn-icon btn-round" href="{{ url('xray/delete-request/'.$xrayRequest->id) }}" onclick="return confirm('Are you sure you want to delete this request?');"><i class="fa fa-trash"></i></a>
                      @else
                        <a class="btn btn-sm btn-primary btn-fab btn-icon btn-round" target="_blank" href="{{ asset('uploads/xray-results/'.$xrayRequest->result_file) }}"><i class="fa fa-file"></i></a>
                      @endif
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="all" role="tabpanel">
            <table id="tblPendingRequests" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Request</th>
                    <th>Patient Name</th>
                    <th>Requested By</th>
                    <th>Date</th>
                    <th>Result</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($xrayRequests->WHERE('result','!=',NULL) as $xrayRequest)
                <tr>
                    <td>{{ $xrayRequest->id }}</td>
                    <td>{{ $xrayRequest->supply }}</td>
                    <td>{{ $xrayRequest->patient_last_name }}, {{ $xrayRequest->patient_first_name }} {{ $xrayRequest->patient_middle_name[0] }}</td>
                    <td>{{ $xrayRequest->emp_last_name }}, {{ $xrayRequest->emp_first_name }} {{ $xrayRequest->emp_middle_name[0] }}</td>
                    <td>{{ Carbon\Carbon::parse($xrayRequest->created_at)->toFormattedDateString() }}</td>
                    <td>
                      @if($xrayRequest->result==null)
                        <span class="text-warning">Result pending...</span>
                      @else
                        {{ $xrayRequest->result }}
                      @endif
                    </td>
                    <td>
                      @if($xrayRequest->result==null)
                        <button class="btn btn-sm btn-success btn-fab btn-icon btn-round btn-modalOpen" data-toggle="modal" data-id="{{ $xrayRequest->id }}" data-target="#modalAddResult"><i class="fa fa-plus"></i></button>
                        <a class="btn btn-sm btn-danger btn-fab btn-icon btn-round" href="{{ url('xray/delete-request/'.$xrayRequest->id) }}" onclick="return confirm('Are you sure you want to delete this request?');"><i class="fa fa-trash"></i></a>
                      @else
                        <a class="btn btn-sm btn-primary btn-fab btn-icon btn-round" target="_blank" href="{{ asset('uploads/xray-results/'.$xrayRequest->result_file) }}"><i class="fa fa-file"></i></a>
                      @endif
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

<form action="{{ url('xray/add-result') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddResult" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add X-Ray Results</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" name="xray_id" id="xray_id" value="" hidden>
          <div class="row mb-3">
            <div class="col-md-12">
              <label>Description</label>
              <textarea class="form-control" name="result" required></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <div class="custom-file">
                <input type="file" name="result_file" class="custom-file-input" required>
                <label class="custom-file-label f1" >Choose a PDF file...</label>
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
  $('#tblAllRequests').DataTable();
  $('#tblPendingRequests').DataTable();

  $(document).on("click", ".btn-modalOpen", function () {

    var id = $(this).data('id');
    $(".modal-body #xray_id").val( id );
  });

</script>
@endsection