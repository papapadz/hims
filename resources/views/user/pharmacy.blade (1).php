@extends('layouts.app')

@section('content')
<div class="row">

  <div class="col-md-4">
    <form action="{{ url('pharmacy/pay') }}" method="POST">
    <div class="card">
      <div class="card-header">
        <h5>Medicine Cart</h5>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-12">
            <label>OR Number</label>
            <input type="text" name="payee" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <label>Payee's Name</label>
            <input type="text" name="or_num" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <table id="tblCart" class="table" style="width:100%">
              <thead>
                <th>Item ID</th>
                <th>Item</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Total</th>
              </thead>
              <tbody>
                
              </tbody>
              <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right">Total:</th>
                    <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-success" style="width: 100%">Pay</button>
      </div>
    </div>
    </form>
  </div>

  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5>Supplies</h5>
      </div>
      <div class="card-body">
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
                @foreach($supplies as $supply)
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
                        data-target="#modalAddCart">
                          <i class="fa fa-plus"></i>
                      </button>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
      </div>
    </div>
  </div>
</div>

<!-- Modals -->
<div id="modalAddCart" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Medicine Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12">
            <label>ID</label>
            <input type="text" id="temp_id" value="" class="form-control" readonly>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <label>Item Name</label>
            <input type="text" id="temp_name" value="" class="form-control" readonly>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <label>Unit Price</label>
            <input type="number" id="temp_price" value="" class="form-control" readonly>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <label>Qty</label>
            <input type="number" id="temp_qty" min="0" class="form-control" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btnAddToCart" class="btn btn-primary" data-dismiss="modal">Add</button>
      </div>      
    </div>
  </div>
</div>
<!-- END MODALS -->

@endsection

@section('script')
<script type="text/javascript">
  
  $(document).ready(function() {
  // DataTable initialisation

  $('#tblSupplies').DataTable();
  var tbl_cart = $('#tblCart').DataTable(
    {
      "paging":   false,
      "searching": false,
      "ordering": false,
      "drawCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(total);
        }
      }
    );

  $(document).on("click", ".btn-modalOpen", function () {
       
    $("#temp_id").val( $(this).data('id') );
    $("#temp_name").val( $(this).data('supply') );
    $("#temp_price").val( $(this).data('price') );
  });

  $('#btnAddToCart').on('click', function() {
    var sub = $('#temp_price').val() * $('#temp_qty').val();
    tbl_cart.row.add([
      '<input type="text" name="supply_id[]" class="form-control-plaintext" value="'+$('#temp_id').val()+'" readonly/>',
      '<input type="text" class="form-control-plaintext" value="'+$('#temp_name').val()+'" readonly/>',
      '<input type="text" name="price[]" class="form-control-plaintext" value="'+$('#temp_price').val()+'" readonly/>',
      '<input type="text" name="qty[]" class="form-control-plaintext" value="'+$('#temp_qty').val()+'" readonly/>',
      sub,
    ]).draw(true);
    $('#temp_qty').val(1);
  });

  });
</script>
@endsection
