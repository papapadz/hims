@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Payroll Items
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm float-right" data-toggle="modal" data-target="#modalAddItem">
            <i class="fa fa-plus"></i> Add
          </button>
          </div> 
        </h5>
      </div>
      <div class="card-body ">
       <table id="tblItems" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->item }}</td>
                    <td>
                      @if($item->item_type=='ADD')
                        <span class="text-success">ADD</span>
                      @else
                        <span class="text-danger">LESS</span>
                      @endif
                    </td>
                    <td>
                      @if($item->item_stat==1)
                        <span class="text-success">Active</span>
                      @else
                        <span class="text-danger">Inactive</span>
                      @endif
                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-toggle="modal" 
                        data-id="{{ $item->id }}" 
                        data-item="{{ $item->item }}" 
                        data-type="{{ $item->item_type }}" 
                        data-stat="{{ $item->item_stat }}" 
                        data-target="#modalEditItem">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="{{ url('settings/payroll-items/delete/'.$item->id) }}" 
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


<form action="{{ url('settings/payroll-items/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddItem" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payroll Item Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Item</label>
                <input type="text" name="item" class="form-control" placeholder="Item" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Item Type</label>
                <select class="form-control" name="item_type" required>
                  <option value="ADD">Debit (+)</option>
                  <option value="LESS">Deductions (-)</option>
                </select>
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

<form action="{{ url('settings/payroll-items/edit') }}" method="POST" enctype="multipart/form-data">
  @csrf
<input type="text" name="item_id" id="item_id" hidden />
<div id="modalEditItem" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Item Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Item</label>
                <input type="text" name="item" id="item" class="form-control" placeholder="Item" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Item Type</label>
                <select class="form-control" name="item_type" id="item_type" required>
                  <option value="ADD">Debit (+)</option>
                  <option value="LESS">Deductions (-)</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Item Status</label>
                <select class="form-control" name="item_stat" id="item_stat" required>
                  <option value=1>Active</option>
                  <option value=0>Inactive</option>
                </select>
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
  $('#tblItems').DataTable();

  $(document).on("click", ".btn-modalOpen", function () {

    $("#item_id").val( $(this).data('id') );
    $("#item").val( $(this).data('item') );
    $("#item_type").val( $(this).data('type') );
    $("#item_stat").val( $(this).data('stat') );
  });
</script>
@endsection