@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Medical Supplies 
          <button class="btn btn-outline-success btn-round btn-sm float-right" data-toggle="modal" data-target="#modalAddSupply">
                  <i class="fa fa-plus"></i> Add
                </button>
        </h5>
      </div>
      <div class="card-body ">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#supplies" role="tab" aria-selected="true">Medicines</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#lab" role="tab" aria-selected="false">Laboratory Exams</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#xray" role="tab" aria-selected="false">X-Ray Exams</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#misc" role="tab" aria-selected="false">Miscellaneous</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
        <br>
          <div class="tab-pane active" id="supplies" role="tabpanel">
            <table id="tblSupplies" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Supply</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($supplies->WHERE('category_id',1) as $supply)
                <tr>
                    <td>{{ $supply->id }}</td>
                    <td>{{ $supply->supply }}</td>
                    <td>{{ $supply->unit }}</td>
                    <td>{{ $supply->price }}</td>
                    <td>{{ $supply->category }}</td>
                    <td>{{ $supply->qty }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-toggle="modal" 
                        data-id="{{ $supply->id }}" 
                        data-supply="{{ $supply->supply }}"
                        data-unit="{{ $supply->unit }}"
                        data-price="{{ $supply->price }}"
                        data-category="{{ $supply->category_id }}"
                        data-qty="{{ $supply->qty }}" 
                        data-target="#modalEditSupply">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="{{ url('supply/delete/'.$supply->id) }}" 
                        onclick="return confirm('Are you sure you want to delete this supply?');" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round">
                          <i class="fa fa-trash"></i>
                      </a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="misc" role="tabpanel">
            <table id="tblLabExams" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Supply</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($supplies->WHERE('category_id',4) as $supply)
                <tr>
                    <td>{{ $supply->id }}</td>
                    <td>{{ $supply->supply }}</td>
                    <td>{{ $supply->unit }}</td>
                    <td>{{ $supply->price }}</td>
                    <td>{{ $supply->category }}</td>
                    <td>{{ $supply->qty }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-toggle="modal" 
                        data-id="{{ $supply->id }}" 
                        data-supply="{{ $supply->supply }}"
                        data-unit="{{ $supply->unit }}"
                        data-price="{{ $supply->price }}"
                        data-category="{{ $supply->category_id }}"
                        data-qty="{{ $supply->qty }}" 
                        data-target="#modalEditSupply">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="{{ url('supply/delete/'.$supply->id) }}" 
                        onclick="return confirm('Are you sure you want to delete this supply?');" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round">
                          <i class="fa fa-trash"></i>
                      </a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="xray" role="tabpanel">
            <table id="tblXRayExams" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Supply</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($supplies->WHERE('category_id',3) as $supply)
                <tr>
                    <td>{{ $supply->id }}</td>
                    <td>{{ $supply->supply }}</td>
                    <td>{{ $supply->unit }}</td>
                    <td>{{ $supply->price }}</td>
                    <td>{{ $supply->category }}</td>
                    <td>{{ $supply->qty }}</td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-toggle="modal" 
                        data-id="{{ $supply->id }}" 
                        data-supply="{{ $supply->supply }}"
                        data-unit="{{ $supply->unit }}"
                        data-price="{{ $supply->price }}"
                        data-category="{{ $supply->category_id }}"
                        data-qty="{{ $supply->qty }}" 
                        data-target="#modalEditSupply">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="{{ url('supply/delete/'.$supply->id) }}" 
                        onclick="return confirm('Are you sure you want to delete this supply?');" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round">
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
  </div>
</div>

<form action="{{ url('supply/edit') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="text" name="supply_id" id="supply_id" class="form-control" hidden/>
<div id="modalEditSupply" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Supply Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Supply</label>
                <input type="text" name="supply" id="supply" class="form-control" placeholder="Supply" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Unit</label>
                <input type="text" name="unit" id="unit" class="form-control" placeholder="Unit" required/>
              </div>
              <div class="col-md-6">
                <label>Price</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="Price" step="any" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Qty</label>
                <input type="number" name="qty" id="qty" class="form-control" placeholder="Quantity" required/>
              </div>
              <div class="col-md-6">
                <label>Category</label>
                <select name="category_id" id="category" class="form-control" required>
                  <option selected disabled>Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->category }}</option>
                  @endforeach
                </select>
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

<form action="{{ url('supply/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddSupply" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Supply Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <input type="text" name="supply" class="form-control" placeholder="Supply" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" name="unit" class="form-control" placeholder="Unit" required/>
              </div>
              <div class="col-md-6">
                <input type="number" name="price" class="form-control" placeholder="Price" step="any" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="number" name="qty" class="form-control" placeholder="Quantity" required/>
              </div>
              <div class="col-md-6">
                <select name="category_id" class="form-control" required>
                  <option selected disabled>Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->category }}</option>
                  @endforeach
                </select>
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

<form action="{{ url('supply-category/edit') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalEditSupplyCat" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Supply Category Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" name="category_id" id="category_id" class="form-control" hidden />
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Category</label>
                <input type="text" name="category" id="category" class="form-control" placeholder="Category" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="Description" required></textarea>
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

<form action="{{ url('supply-category/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddSupplyCat" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Supply Category Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <input type="text" name="category" class="form-control" placeholder="Category" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <textarea class="form-control" name="description" placeholder="Description" required></textarea>
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
  $('#tblSupplies').DataTable();
  $('#tblLabExams').DataTable();
  $('#tblXRayExams').DataTable();

  $(document).on("click", ".btn-modalOpen", function () {

    $("#supply_id").val( $(this).data('id') );
    $("#supply").val( $(this).data('supply') );
    $("#unit").val( $(this).data('unit') );
    $("#price").val( $(this).data('price') );
    $("#category").val( $(this).data('category') );
    $("#qty").val( $(this).data('qty') );
  });
  
</script>
@endsection
