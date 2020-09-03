@extends('layouts.app')

@section('content')
<form action="{{ url('payroll/edit/save') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
  <div class="col-2">
  </div>
  <div class="col-8">
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <div class="row mb-2">
            <div class="col-md-2">
              Name:
            </div>
            <div class="col">
              <b>{{ $payroll->last_name }}, {{ $payroll->first_name }} {{ $payroll->middle_name }}</b>
            </div>      
          </div>
          <div class="row mb-2">
            <div class="col-md-2">
              Position:
            </div>
            <div class="col">
              <b>{{ $payroll->position }}</b>
            </div>      
          </div>
          <div class="row mb-2">
            <div class="col-md-2">
              Payroll Date:
            </div>
            <div class="col">
              <b>
              @php
                $d = Carbon\Carbon::parse($payroll->payroll_date);
                echo $d->format('F');
                if($d->day==1)
                    echo ' 1-15';
                else
                    echo ' 16-'.$d->lastOfMonth()->day;
                echo ', '.$d->format('Y');
                @endphp
              </b>
            </div>      
          </div>
          <hr>
            <input type="text" name="id" value="{{ $payroll->id }}" hidden="true" />
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
                          <td><b>Amount</b></td>
                        </tr>
                        <tr>
                          <td>Accrued Income</td>
                          <td>
                            <input type="number" step="0.01" name="amount5" id="amount5" class="form-control" value="{{ $payroll->accrued_income }}" />
                          </td>
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
                            <input type="number" step="0.01" name="salary_diff" id="salary_diff" class="form-control" min="0"  
                            value="{{ $payroll->salary_diff }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>SALARY INCREASE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="salary_increase" id="salary_increase" class="form-control" min="0" 
                            value="{{ $payroll->salary_increase }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>PERSONNEL ECONOMIC RELIEF ALLOWANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="personnel_allowance" id="personnel_allowance" class="form-control" min="0" 
                            value="{{ $payroll->personnel_allowance }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>REFUND CG</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="refund" id="refund" class="form-control" min="0" 
                            value="{{ $payroll->refund }}">
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
                            <input type="number" step="0.01" name="hazard" id="hazard" class="form-control" min="0.00" 
                            value="{{ $payroll->salary_diff }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>SUBSISTENCE AND LAUNDRY ALLOWANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="subs_laundry" id="subs_laundry" class="form-control" min="0.00" 
                            value="{{ $payroll->subs_laundry }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>FOOD ALLOWANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="food_allowance" id="food_allowance" class="form-control" min="0.00" 
                            value="0.00">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>TRAVEL ALLOWANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="travel_allowance" id="travel_allowance" class="form-control" min="0.00" 
                            value="0.00">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>CLOTHING ALLOWANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="clothing_allowance" id="clothing_allowance" class="form-control" min="0.00" 
                            value="0.00">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>ADJUSTMENTS</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="adjustments" id="adjustments" class="form-control" min="0" 
                            value="0.00">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>OTHER BENEFITS</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="other_benefits" id="other_benefits" class="form-control" min="0" 
                            value="{{ $payroll->other_benefits }}">
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
                            <input type="number" step="0.01" name="gsis" id="gsis" class="form-control" min="0" 
                            value="{{ $payroll->gsis }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>BIR WITHOLDING TAX</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="tax" id="tax" class="form-control" min="0" 
                            value="{{ $payroll->tax }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>PHILHEALTH CONTRIBUTIONN</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="philhealth" id="philhealth" class="form-control" min="0" 
                            value="{{ $payroll->philhealth }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>HDMF (PAG-IBIG) CONRIBUTION-PREMIUMS</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="pagibig" id="pagibig" class="form-control" min="0" 
                            value="{{ $payroll->pagibig }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>HDMF (PAG-IBIG) CONRIBUTION-MP2</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="pagibig2" id="pagibig2" class="form-control" min="0" 
                            value="{{ $payroll->pagibig2 }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>HDMF - MPL</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="hdmf" id="hdmf" class="form-control" min="0" 
                            value="{{ $payroll->hdmf }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>GSIS - SALARY LOAN</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="salary_loan" id="salary_loan" class="form-control" min="0" 
                            value="{{ $payroll->salary_loan }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>GSIS POLICY LOAN</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="policy_loan" id="policy_loan" class="form-control" min="0" 
                            value="{{ $payroll->policy_loan }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>GSIS CASH ADVANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="cash_advance" id="cash_advance" class="form-control" min="0" 
                            value="{{ $payroll->cash_advance }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>GSIS - UMID CASH ADVANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="umid_cash" id="umid_cash" class="form-control" min="0" 
                            value="{{ $payroll->umid_cash }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>GSIS - CONSOLIDATED LOAN</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="conso_loan" id="conso_loan" class="form-control" min="0" 
                            value="{{ $payroll->conso_loan }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>GSIS - EMERGENCY LOAN</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="emergency_loan" id="emergency_loan" class="form-control" min="0" 
                            value="{{ $payroll->emergency_loan }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>GSIS - HOUSING LOAN</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="housing_loan" id="housing_loan" class="form-control" min="0" 
                            value="{{ $payroll->housing_loan }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>SDMPC - LOAN SALARIES</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="sdmpc_loan" id="sdmpc_loan" class="form-control" min="0" 
                            value="{{ $payroll->sdmpc_loan }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>SDMPC - COOP SHARE (ADDITIONAL)</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="sdmpc_coop" id="sdmpc_coop" class="form-control" min="0" 
                            value="{{ $payroll->sdmpc_coop }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>LANDBANK MOBILE - LOAN SAVER</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="landbank" id="landbank" class="form-control" min="0" 
                            value="{{ $payroll->landbank }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>DORM FEES</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="dorm_fee" id="dorm_fee" class="form-control" min="0" 
                            value="{{ $payroll->dorm_fee }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>MORTUARY FUND</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="mortuary_fund" id="mortuary_fund" class="form-control" min="0" 
                            value="{{ $payroll->mortuary_fund }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>BEREAVEMENT ASSISTANCE</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="bereavement_asst" id="bereavement_asst" class="form-control" min="0" 
                            value="{{ $payroll->bereavement_asst }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>ASSOCIATION MOTHLY DUES</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="assoc_due" id="assoc_due" class="form-control" min="0" 
                            value="{{ $payroll->assoc_due }}">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>OTHERS</label>
                          </td>
                          <td>
                            <input type="number" step="0.01" name="other_deductions" id="other_deductions" class="form-control" min="0" 
                            value="{{ $payroll->other_deductions }}">
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row mb-2">
                <div class="col-md-3">
                  <b>Accrued Income</b>
                </div>
                <div class="col">
                  <input type="number" step="0.01" name="accrued_income" id="accrued_income" value="0.00" class="form-control" readonly>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-3">
                  <b>Gross Income (Net Pay)</b>
                </div>
                <div class="col">
                  <input type="number" step="0.01" name="gross_income" id="gross_income" class="form-control" value="0.00" readonly>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-3">
                  <b>Total Deduction</b>
                </div>
                <div class="col">
                  <input type="number" step="0.01" name="total_deduction" id="total_deduction" class="form-control" value="0.00" readonly>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-3">
                  <b>Net Income</b>
                </div>
                <div class="col">
                  <input type="number" step="0.01" name="net_income" id="net_income" class="form-control" value="0.00" readonly>
                </div>
              </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
  <div class="col-2">
  </div>
</div>
</form>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
      amt5 = 0.00;
      otherBenefits = grossIncome = totalDeductions = netIncome = 0.00;
      compute();

      $('input').on('change', function() {
        
        compute();
      });

  });

    function compute() {
      amt5 = $('#amount5').val();
      $('#accrued_income').val(amt5);

      otherBenefits = Number($('#food_allowance').val()) + Number($('#travel_allowance').val()) + Number($('#clothing_allowance').val()) + Number($('#adjustments').val()) + Number($('#other_benefits').val());
      totalBenefits = Number($('#hazard').val()) + Number($('#subs_laundry').val()) + Number(otherBenefits);
      grossIncome = Number($('#salary_diff').val()) + Number($('#salary_increase').val()) + Number($('#personnel_allowance').val()) + Number($('#refund').val()) + Number(totalBenefits);

      totalDeductions = Number($('#gsis').val())+Number($('#tax').val())+Number($('#philhealth').val())+Number($('#pagibig').val())+Number($('#pagibig2').val())+Number($('#hdmf').val())+Number($('#salary_loan').val())+Number($('#policy_loan').val())+Number($('#cash_advance').val())+Number($('#umid_cash').val())+Number($('#conso_loan').val())+Number($('#emergency_loan').val())+Number($('#housing_loan').val())+Number($('#sdmpc_loan').val())+Number($('#sdmpc_coop').val())+Number($('#landbank').val())+Number($('#dorm_fee').val())+Number($('#mortuary_fund').val())+Number($('#bereavement_asst').val())+Number($('#assoc_due').val())+Number($('#other_deductions').val());

      netIncome = (Number($('#accrued_income').val()) + grossIncome) - totalDeductions;

      //$('#accrued_income').val(accruedIncome);
      $('#gross_income').val(grossIncome);
      $('#total_deduction').val(totalDeductions);
      $('#net_income').val(netIncome);
    }
</script>
@endsection