@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Billing
          
        </h5>
      </div>
      <div class="card-body ">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#active-bills" role="tab" aria-selected="true">Active Billings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#paid-bills" role="tab" aria-selected="true">Paid Billings</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
        <br>
          <div class="tab-pane active" id="active-bills" role="tabpanel">
           <table id="tblActiveBills" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Hospital No.</th>
                    <th>Patient Name</th>
                    <th>Room/Ward/Clinic</th>
                    <th>Consult Date</th>
                    <th>Payables</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bills->WHERE('is_paid',0) as $bill)
                <tr>
                    <td>{{ $bill->hosp_no }}</td>
                    <td>{{ $bill->last_name }}, {{ $bill->first_name }} {{ $bill->middle_name }}</td>
                    <td>{{ $bill->room }}</td>
                    <td>{{ Carbon\Carbon::parse($bill->created_at)->toFormattedDateString() }}</td>
                    <td>P {{ number_format($bill->sumSubTotal, 2) }}</td>
                    <td>
                      <a href="{{ url('patients/consult/'.$bill->consult_id) }}" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                        <i class="fa fa-arrow-right"></i>
                      </a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="paid-bills" role="tabpanel">
           <table id="tblPaidBills" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>OR Number</th>
                    <th>Hospital No.</th>
                    <th>Patient Name</th>
                    <th>Payee</th>
                    <th>Amount</th>
                    <th>Date Paid</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bills->WHERE('is_paid',1) as $bill)
                <tr>
                    <td>{{ $bill->or_num }}</td>
                    <td>{{ $bill->hosp_no }}</td>
                    <td>{{ $bill->last_name }}, {{ $bill->first_name }} {{ $bill->middle_name }}</td>
                    <td>{{ $bill->payee }}</td>
                    <td>P {{ number_format($bill->sumSubTotal, 2) }}</td>
                    <td>{{ Carbon\Carbon::parse($bill->updated_at)->toFormattedDateString() }}</td>
                    <td>
                      <a href="{{ url('patients/consult/'.$bill->consult_id) }}" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                        <i class="fa fa-arrow-right"></i>
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
@endsection

@section('script')
<script type="text/javascript">
  $('#tblActiveBills').DataTable();
  $('#tblPaidBills').DataTable();
</script>
@endsection