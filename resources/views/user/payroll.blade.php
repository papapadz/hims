@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Payroll
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-warning btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalBatchPrint">
              <i class="fa fa-print"></i> Batch Print
            </button>
            <button class="btn btn-outline-primary btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalUpload">
              <i class="fa fa-upload"></i> Upload
            </button>
            <button class="btn btn-outline-success btn-round btn-sm" type="button" id="dropdownMenuButton" data-toggle="modal" data-target="#modalAddPayroll">
              <i class="fa fa-plus"></i> Add
            </button>
            <button class="btn btn-outline-warning btn-round btn-sm float-right" type="button" data-toggle="modal" data-target="#modalSearch">
              <i class="fa fa-search"></i> Search
            </button>
          </div> 
        </h5>
      </div>
      <div class="card-body ">
         <table id="tblPayroll" class="table table-bordered table-responsive" style="width:100%">
              <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee No.</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Accrued Income</th>
                    <th>Earnings</th>
                    <th>Gross Income</th>
                    <th>Total Deductions</th>
                    <th>Net Income</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($payrolls as $payroll)
                <tr>
                    <td>
                      @php
                          $d = Carbon\Carbon::parse($payroll->payroll_date);
                          echo $d->format('F');
                          if($d->day==1)
                              echo ' 1-15';
                          else
                              echo ' 16-'.$d->lastOfMonth()->day;
                          echo ', '.$d->format('Y');
                      @endphp
                    </td>
                    <td>{{ $payroll->emp_no }}</td>
                    <td>{{ $payroll->last_name }}, {{ $payroll->first_name }} {{ $payroll->middle_name[0] }}</td>
                    <td>{{ $payroll->department }}</td>
                    <td>{{ $payroll->position }}</td>
                    <td>
                      @php
                        $totalaccrued = $payroll->accrued_income + $payroll->salary_diff + $payroll->salary_increase + $payroll->personnel_allowance + $payroll->refund;

                        echo number_format($totalaccrued,2); 
                      @endphp
                    </td>
                    <td>
                      @php
                        $totalEarnings = $payroll->hazard + $payroll->subs_laundry + $payroll->food_allowance + $payroll->travel_allowance + $payroll->clothing_allowance + $payroll->adjustments + $payroll->other_benefits;

                        echo number_format($totalEarnings,2);
                      @endphp
                    </td>
                    <td>
                      @php
                        $gross = $totalaccrued + $totalEarnings;
                        echo number_format($gross,2);
                      @endphp
                    </td>
                    <td>
                      @php
                        $totalDeductions = $payroll->gsis + $payroll->tax + $payroll->philhealth + $payroll->pagibig + $payroll->pagibig2 + $payroll->hdmf + $payroll->salary_loan + $payroll->policy_loan + $payroll->cash_advance + $payroll->umid_cash + $payroll->conso_loan + $payroll->emergency_loan + $payroll->housing_loan + $payroll->sdmpc_loan + $payroll->sdmpc_coop + $payroll->landbank + $payroll->dorm_fee + $payroll->mortuary_fund + $payroll->bereavement_asst + $payroll->assoc_due + $payroll->other_deductions;

                        echo number_format($totalDeductions,2);
                      @endphp
                    </td>
                    <td>
                      @php
                        $net = $gross - $totalDeductions;

                        echo number_format($net,2);
                      @endphp
                    </td>
                    <td>
                      <a 
                        href="{{ url('payroll/payslip/'.$payroll->id) }}"
                        class="btn btn-sm btn-warning btn-fab btn-icon btn-round"
                      >
                        <i class="fa fa-print"></i>
                      </a>
                      <a 
                        href="{{ url('payroll/edit/'.$payroll->id) }}"
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round"
                      >
                        <i class="fa fa-edit"></i>
                      </a>
                      <a 
                        href="{{ url('payroll/delete/'.$payroll->id) }}" 
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

<form action="{{ url('payroll/add') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalAddPayroll" class="modal" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payroll Details</h5>
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
            <div class="col-md-6">
              <input type="text" name="position" id="position" class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <input type="text" name="department" id="department" class="form-control" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <select class="form-control" name="payroll_date" id="payroll_date">
                <option selected disabled>Select Date</option>
                <option value="1">1 - 15</option>
                <option value="2">16 - 31</option>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <select class="form-control" name="payroll_month" id="payroll_month">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <select class="form-control" name="payroll_year" id="payroll_year">
                <option selected disabled>Select Year</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#income" role="tab" aria-selected="true">Income</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#earning" role="tab" aria-selected="false">Earning</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#benefits" role="tab" aria-selected="false">Other Benefits</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#deductions" role="tab" aria-selected="false">Deductions</a>
              </li>
            </ul>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <div class="tab-content">
                <div class="tab-pane active" id="income" role="tabpanel">
                  <table style="width: 100%">
                    <tr>
                      <td style="width: 35%"></td>
                      <td><b>Hours</b></td>
                      <td><b>Rate</b></td>
                      <td><b>Amount</b></td>
                    </tr>
                    <tr>
                      <td>Regular Days</td>
                      <td>
                        <input type="number" step="0.01" name="regular_days" id="regular_days" class="form-control" min="0" value="0.00" />
                      </td>
                      <td>
                        <input type="number" step="0.01" name="rate1" id="rate1" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="amount1" id="amount1" class="form-control" readonly />
                      </td>
                    </tr>
                    <tr>
                      <td>Saturdays</td>
                      <td>
                        <input type="number" step="0.01" name="saturdays1" id="saturdays1" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="rate2" id="rate2" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="amount2" id="amount2" class="form-control" readonly />
                      </td>
                    </tr>
                    <tr>
                      <td>Sundays</td>
                      <td>
                        <input type="number" step="0.01" name="sundays1" id="sundays1" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="rate3" id="rate3" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="amount3" id="amount3" class="form-control" readonly />
                      </td>
                    </tr>
                    <tr>
                      <td>Overtime</td>
                      <td>
                        <input type="number" step="0.01" name="overtime1" id="overtime1" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="rate4" id="rate4" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="amount4" id="amount4" class="form-control" readonly />
                      </td>
                    </tr>
                    <tr>
                      <td>Night Shift</td>
                      <td>
                        <input type="number" step="0.01" name="night_shift1" id="night_shift1" class="form-control" min="0" value="0.00"/>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="rate5" id="rate5" class="form-control" min="0" value="0.00" />
                      </td>
                      <td>
                        <input type="number" step="0.01" name="amount5" id="amount5" class="form-control" readonly />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3">Total</td>
                      <td><input type="number" step="0.01" name="total1" id="total1" class="form-control" readonly /></td>
                    </tr>
                  </table>
                </div>
                <div class="tab-pane" id="earning" role="tabpanel">
                  <table style="width: 100%">
                    <tr>
                      <td><b>Earning</b></td>
                      <td><b>Amount</b></td>
                    </tr>
                    <tr>
                      <td>
                        <label>SALARY DIFFERENTIAL</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="salary_diff" id="salary_diff" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>SALARY INCREASE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="salary_increase" id="salary_increase" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>PERSONNEL ECONOMIC RELIEF ALLOWANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="personnel_allowance" id="personnel_allowance" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>REFUND CG</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="refund" id="refund" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="tab-pane" id="benefits" role="tabpanel">
                   <table style="width: 100%">
                    <tr>
                      <td><b>Benefit</b></td>
                      <td><b>Amount</b></td>
                    </tr>
                    <tr>
                      <td>
                        <label>HAZARD PAY</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="hazard" id="hazard" class="form-control" min="0" value="0.00"/>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>SUBSISTENCE AND LAUNDRY ALLOWANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="subs_laundry" id="subs_laundry" class="form-control" min="0" value="0.00"/>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>FOOD ALLOWANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="food_allowance" id="food_allowance" class="form-control" min="0" value="0.00"/>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>TRAVEL ALLOWANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="travel_allowance" id="travel_allowance" class="form-control" min="0" value="0.00"/>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>CLOTHING ALLOWANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="clothing_allowance" id="clothing_allowance" class="form-control" min="0" value="0.00"/>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>ADJUSTMENTS</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="adjustments" id="adjustments" class="form-control" min="0" value="0.00"/>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>OTHER BENEFITS</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="other_benefits" id="other_benefits" class="form-control" min="0" value="0.00"/>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="tab-pane" id="deductions" role="tabpanel">
                  <table style="width: 100%">
                    <tr>
                      <td style="width: 70%"><b>Deductions</b></td>
                      <td><b>Amount</b></td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS CONTRIBUTION</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="gsis" id="gsis" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>BIR WITHOLDING TAX</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="tax" id="tax" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>PHILHEALTH CONTRIBUTIONN</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="philhealth" id="philhealth" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>HDMF (PAG-IBIG) CONRIBUTION-PREMIUMS</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="pagibig" id="pagibig" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>HDMF (PAG-IBIG) CONRIBUTION-MP2</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="pagibig2" id="pagibig2" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>HDMF - MPL</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="hdmf" id="hdmf" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS - SALARY LOAN</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="salary_loan" id="salary_loan" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS POLICY LOAN</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="policy_loan" id="policy_loan" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS CASH ADVANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="cash_advance" id="cash_advance" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS - UMID CASH ADVANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="umid_cash" id="umid_cash" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS - CONSOLIDATED LOAN</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="conso_loan" id="conso_loan" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS - EMERGENCY LOAN</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="emergency_loan" id="emergency_loan" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>GSIS - HOUSING LOAN</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="housing_loan" id="housing_loan" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>SDMPC - LOAN SALARIES</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="sdmpc_loan" id="sdmpc_loan" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>SDMPC - COOP SHARE (ADDITIONAL)</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="sdmpc_coop" id="sdmpc_coop" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>LANDBANK MOBILE - LOAN SAVER</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="landbank" id="landbank" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>DORM FEES</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="dorm_fee" id="dorm_fee" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>MORTUARY FUND</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="mortuary_fund" id="mortuary_fund" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>BEREAVEMENT ASSISTANCE</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="bereavement_asst" id="bereavement_asst" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>ASSOCIATION MOTHLY DUES</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="assoc_due" id="assoc_due" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>OTHERS</label>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="other_deductions" id="other_deductions" class="form-control" min="0" value="0.00">
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <b>Accrued Income</b>
            </div>
            <div class="col-md-6">
              <input type="number" step="0.01" name="accrued_income" id="accrued_income" class="form-control" >
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <b>Gross Income (Net Pay)</b>
            </div>
            <div class="col-md-6">
              <input type="number" step="0.01" name="gross_income" id="gross_income" class="form-control" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <b>Total Deduction</b>
            </div>
            <div class="col-md-6">
              <input type="number" step="0.01" name="total_deduction" id="total_deduction" class="form-control" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <b>Net Income</b>
            </div>
            <div class="col-md-6">
              <input type="number" step="0.01" name="net_income" id="net_income" class="form-control" readonly>
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

<form action="{{ url('payroll/upload') }}" method="POST" enctype="multipart/form-data">
  @csrf
<input type="text" name="file_type" value="payroll" hidden />
<div id="modalUpload" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Upload CSV File</label>
            <div class="custom-file">
              <input type="file" name="fileupload" class="custom-file-input" required>
              <label class="custom-file-label f1" >Choose a csv file...</label>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
      </div>
    </div>
  </div>
</form>

<form action="{{ url('payroll/search') }}" method="POST" enctype="multipart/form-data">
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
            <label>Search by Payroll Period</label>
            <select class="form-control" name="payroll_month">
                <option selected disabled>Select Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
              <select class="form-control" name="payroll_year">
                <option selected disabled>Select Year</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
              <select class="form-control" name="payroll_date">
                <option selected disabled>Select Date</option>
                <option value="1">1 - 15</option>
                <option value="16">16 - 31</option>
              </select>
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

<form action="{{ url('payroll/batch-print') }}" method="POST" enctype="multipart/form-data">
  @csrf
<div id="modalBatchPrint" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Batch Print</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
            <label>Search by Payroll Period</label>
            <select class="form-control" name="payroll_month">
                <option selected disabled>Select Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
              <select class="form-control" name="payroll_year">
                <option selected disabled>Select Year</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
              <select class="form-control" name="payroll_date">
                <option selected disabled>Select Date</option>
                <option value="1">1 - 15</option>
                <option value="16">16 - 31</option>
                <option value="0">1 - 31</option>
              </select>
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
  $('#tblPayroll').DataTable();
  $( ".select_emp_no" ).select2({
      theme: 'bootstrap'
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {

    $('#payroll_year').on('change', function() {

      $.ajax ({
        url : '{{ url("get/attendance") }}/'+$('#emp_no').val()+'/'+$('#payroll_date').val()+'/'+$('#payroll_month').val()+'/'+$(this).val()
        ,method : 'GET'
        ,cache : false
      }).done( function(response){
        $('#regular_days').val( response.weekdays );
        $('#saturdays1').val( response.sat );
        $('#sundays1').val( response.sun );
        $('#overtime1').val( response.ot );
      });
    });

    amt1 = amt2 = amt3 = amt4 = amt5 = amt6 = amt7 = amt8 = amt9 = amt10 = amt11 = amt12 = 0.00;

    otherBenefits = grossIncome = totalDeductions = netIncome = 0.00;

    $('input').on('change', function() {
      amt1 = $('#regular_days').val() * $('#rate1').val();
      $('#amount1').val(amt1);

      amt2 = $('#saturdays1').val() * $('#rate2').val();
      $('#amount2').val(amt2);

      amt3 = $('#sundays1').val() * $('#rate3').val();
      $('#amount3').val(amt3);

      amt4 = $('#overtime1').val() * $('#rate4').val();
      $('#amount4').val(amt4);

      amt5= $('#night_shift1').val() * $('#rate5').val();
      $('#amount5').val(amt5);

      otherBenefits = Number($('#food_allowance').val()) + Number($('#travel_allowance').val()) + Number($('#clothing_allowance').val()) + Number($('#adjustments').val()) + Number($('#other_benefits').val());

      totalBenefits = Number($('#hazard').val()) + Number($('#subs_laundry').val()) + Number(otherBenefits);
      grossIncome = Number($('#salary_diff').val()) + Number($('#salary_increase').val()) + Number($('#personnel_allowance').val()) + Number($('#refund').val()) + Number(totalBenefits);

      //accruedIncome = amt1+amt2+amt3+amt4+amt5;

      totalDeductions = Number($('#gsis').val())+Number($('#tax').val())+Number($('#philhealth').val())+Number($('#pagibig').val())+Number($('#pagibig2').val())+Number($('#hdmf').val())+Number($('#salary_loan').val())+Number($('#policy_loan').val())+Number($('#cash_advance').val())+Number($('#umid_cash').val())+Number($('#conso_loan').val())+Number($('#emergency_loan').val())+Number($('#housing_loan').val())+Number($('#sdmpc_loan').val())+Number($('#sdmpc_coop').val())+Number($('#landbank').val())+Number($('#dorm_fee').val())+Number($('#mortuary_fund').val())+Number($('#bereavement_asst').val())+Number($('#assoc_due').val())+Number($('#other_deductions').val());

      netIncome = (Number($('#accrued_income').val()) + grossIncome) - totalDeductions;

      $('#total1').val(amt1+amt2+amt3+amt4+amt5);
      //$('#accrued_income').val(accruedIncome);
      $('#gross_income').val(grossIncome);
      $('#total_deduction').val(totalDeductions);
      $('#net_income').val(netIncome);
    });

    $('#emp_no').on('change', function() {
        //If user selects an employee from the dropdown, get the details of that employee
        $.ajax ({
          url : "{{ url('get/employee') }}/"+$(this).val()
          ,type : 'GET'
          ,success: function(response) {
            $('#position').val(response.position);
            $('#department').val(response.department);      
          }
      });
    });
  });
</script>
@endsection