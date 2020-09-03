@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-2">
  </div>
  <div class="col-8">
    <div class="card">
      <div class="card-header">
        <h4>
          <button class="btn btn-sm btn-warning btn-fab btn-icon btn-round float-right" onclick="printThis('payslipPrint','{{ $payroll->id }}','','4')"><i class="fa fa-print"></i></button>
        </h4>
      </div>
      <div class="card-body" id="payslipPrint">
        <table class="table">
          <tr>
            <td colspan="2"><b>PAYROLL PAYMENT SLIP</b></td>
          </tr>
          <tr>
            <td>OFFICE/DIVISION</td>
            <td>{{ $payroll->department }}</td>
          </tr>
          <tr>
            <td>PAY PERIOD</td>
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
          </tr>
          <tr>
            <td>EMPLOYEE'S NAME</td>
            <td>{{ $payroll->last_name }}, {{ $payroll->first_name }} {{ $payroll->middle_name[0] }}</td>
          </tr>
          <tr>
            <td>POSITION</td>
            <td>{{ $payroll->position }}</td>
          </tr>
          <tr>
            <td>ID No.</td>
            <td>{{ $payroll->emp_no }}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td><b>**EARNINGS**</b></td>
            <td><b>SEMI-MONTHLY</b></td>
          </tr>
          <tr>
            <td>SALARY BASIC</td>
            <td>{{ number_format($payroll->accrued_income,2) }}</td>
          </tr>
          @if($payroll->salary_diff>0)
          <tr>
            <td>SALARY DIFFERENTIAL</td>
            <td>{{ number_format($payroll->salary_diff,2) }}</td>
          </tr>
          @endif
          @if($payroll->salary_increase>0)
          <tr>
            <td>SALARY INCREASE</td>
            <td>{{ number_format($payroll->salary_increase,2) }}</td>
          </tr>
          @endif
          @if($payroll->personnel_allowance>0)
          <tr>
            <td>SALARY INCREASE</td>
            <td>{{ number_format($payroll->personnel_allowance,2) }}</td>
          </tr>
          @endif
          <tr>
            <td></td>
            <td><b><u>
              @php
                $grossEarnings = $payroll->accrued_income + $payroll->salary_diff + $payroll->salary_increase + $payroll->personnel_allowance;
                echo number_format($grossEarnings,2);
              @endphp</u></b>
            </td>
          </tr>
          @if($payroll->refund>0)
          <tr>
            <td>REFUND CG</td>
            <td>{{ number_format($payroll->refund,2) }}</td>
          </tr>
          <tr>
            <td></td>
            <td><b><u>
              @php
                $grossEarnings = $grossEarnings + $payroll->refund;
                echo number_format($grossEarnings,2);
              @endphp</u></b>
            </td>
          </tr>
          @endif
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2"><b>**DEDUCTIONS**</b></td>
          </tr>
          @if($payroll->gsis>0)
          <tr>
            <td>GSIS CONTRIBUTION</td>
            <td>{{ number_format($payroll->gsis,2) }}</td>
          </tr>
          @endif
          @if($payroll->tax>0)
          <tr>
            <td>BIR WITHOLDING TAX</td>
            <td>{{ number_format($payroll->tax,2) }}</td>
          </tr>
          @endif
          @if($payroll->philhealth>0)
          <tr>
            <td>PHILHEALTH CONTRIBUTION</td>
            <td>{{ number_format($payroll->philhealth,2) }}</td>
          </tr>
          @endif
          @if($payroll->pagibig>0)
          <tr>
            <td>HDMF (PAG-IBIG) CONTRIBUTION-PREMIUMS</td>
            <td>{{ number_format($payroll->pagibig,2) }}</td>
          </tr>
          @endif
          @if($payroll->pagibig2>0)
          <tr>
            <td>HDMF (PAG-IBIG) CONTRIBUTION-MP2</td>
            <td>{{ number_format($payroll->pagibig2,2) }}</td>
          </tr>
          @endif
          @if($payroll->hdmf>0)
          <tr>
            <td>HDMF - MPL</td>
            <td>{{ number_format($payroll->hdmf,2) }}</td>
          </tr>
          @endif
          @if($payroll->salary_loan>0)
          <tr>
            <td>GSIS - SALARY LOAN</td>
            <td>{{ number_format($payroll->salary_loan,2) }}</td>
          </tr>
          @endif
          @if($payroll->policy_loan>0)
          <tr>
            <td>GSIS - POLICY LOAN</td>
            <td>{{ number_format($payroll->policy_loan,2) }}</td>
          </tr>
          @endif
          @if($payroll->cash_advance>0)
          <tr>
            <td>GSIS - CASH ADVANCE</td>
            <td>{{ number_format($payroll->cash_advance,2) }}</td>
          </tr>
          @endif
          @if($payroll->umid_cash>0)
          <tr>
            <td>GSIS - UMID CASH ADVANCE</td>
            <td>{{ number_format($payroll->umid_cash,2) }}</td>
          </tr>
          @endif
          @if($payroll->conso_loan>0)
          <tr>
            <td>GSIS - CONSOLIDATED LOAN</td>
            <td>{{ number_format($payroll->conso_loan,2) }}</td>
          </tr>
          @endif
          @if($payroll->emergency_loan>0)
          <tr>
            <td>GSIS - EMERGENCY LOAN</td>
            <td>{{ number_format($payroll->emergency_loan,2) }}</td>
          </tr>
          @endif
          @if($payroll->housing_loan>0)
          <tr>
            <td>GSIS - HOUSING LOAN</td>
            <td>{{ $payroll->housing_loan }}</td>
          </tr>
          @endif
          @if($payroll->sdmpc_loan>0)
          <tr>
            <td>SDMPC - LOAN SALARIES</td>
            <td>{{ number_format($payroll->sdmpc_loan,2) }}</td>
          </tr>
          @endif
          @if($payroll->sdmpc_coop>0)
          <tr>
            <td>SDMPC - COOP SHARE (ADDITIONAL)</td>
            <td>{{ number_format($payroll->sdmpc_coop,2) }}</td>
          </tr>
          @endif
          @if($payroll->landbank>0)
          <tr>
            <td>LANDBANK MOBILE - LOAN SAVER</td>
            <td>{{ number_format($payroll->landbank,2) }}</td>
          </tr>
          @endif
          @if($payroll->dorm_fee>0)
          <tr>
            <td>DORM FEES</td>
            <td>{{ number_format($payroll->dorm_fee,2) }}</td>
          </tr>
          @endif
          @if($payroll->mortuary_fund>0)
          <tr>
            <td>MORTUARY FUND</td>
            <td>{{ number_format($payroll->mortuary_fund,2) }}</td>
          </tr>
          @endif
          @if($payroll->bereavement_asst>0)
          <tr>
            <td>BEREAVEMENT ASSISTANCE</td>
            <td>{{ number_format($payroll->bereavement_asst,2) }}</td>
          </tr>
          @endif
          @if($payroll->assoc_due>0)
          <tr>
            <td>ASSOCIATION MONTHLY DUES</td>
            <td>{{ number_format($payroll->assoc_due,2) }}</td>
          </tr>
          @endif
          <tr>
            <td></td>
            <td>
              <b><u>
              @php
                 $totalDeductions = $payroll->gsis + $payroll->tax + $payroll->philhealth + $payroll->pagibig + $payroll->pagibig2 + $payroll->hdmf + $payroll->salary_loan + $payroll->policy_loan + $payroll->cash_advance + $payroll->umid_cash + $payroll->conso_loan + $payroll->emergency_loan + $payroll->housing_loan + $payroll->sdmpc_loan + $payroll->sdmpc_coop + $payroll->landbank + $payroll->dorm_fee + $payroll->mortuary_fund + $payroll->bereavement_asst + $payroll->assoc_due;

                echo number_format($totalDeductions,2);
              @endphp
              </u></b>
            </td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td><b>TOTAL EARNINGS</b></td>
            <td>
              <b><u>
              @php
                $totalEarnings = $grossEarnings - $totalDeductions;

                echo number_format($totalEarnings,2);
              @endphp
              </u></b>
            </td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2"><b>**OTHER BENEFITS**</b></td>
          </tr>
          <tr>
            <td>HAZARD PAY ({{ Carbon\Carbon::parse($payroll->payroll_date)->format('F Y') }})</td>
            <td>{{ number_format($payroll->hazard,2) }}</td>
          </tr>
          <tr>
            <td>SUBSISTENCE AND LAUNDRY ALLOWANCE ({{ Carbon\Carbon::parse($payroll->payroll_date)->subMonth(1)->format('F Y') }})</td>
            <td>{{ number_format($payroll->subs_laundry,2) }}</td>
          </tr>
          @if($payroll->food_allowance>0)
          <tr>
            <td>FOOD ALLOWANCE</td>
            <td>{{ number_format($payroll->food_allowance,2) }}</td>
          </tr>
          @endif
          @if($payroll->travel_allowance>0)
          <tr>
            <td>TRAVEL ALLOWANCE</td>
            <td>{{ number_format($payroll->travel_allowance,2) }}</td>
          </tr>
          @endif
          @if($payroll->clothing_allowance>0)
          <tr>
            <td>CLOTHING ALLOWANCE</td>
            <td>{{ number_format($payroll->clothing_allowance,2) }}</td>
          </tr>
          @endif
          @if($payroll->adjustments>0)
          <tr>
            <td>ADJUSTMENTS</td>
            <td>{{ number_format($payroll->adjustments,2) }}</td>
          </tr>
          @endif
          @if($payroll->other_benefits>0)
          <tr>
            <td>OTHER BENEFITS</td>
            <td>{{ number_format($payroll->other_benefits,2) }}</td>
          </tr>
          @endif
          <tr>
            <td></td>
            <td>
              <b><u>
              @php
                $totalBenefits = $payroll->hazard + $payroll->subs_laundry + $payroll->food_allowance + $payroll->travel_allowance + $payroll->clothing_allowance + $payroll->adjustments + $payroll->other_benefits;

                echo number_format($totalBenefits,2);
              @endphp
              </u></b>
            </td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td><b>NET INCOME</b></td>
            <td>
              <b><u>
              @php
                $net = $totalEarnings + $totalBenefits;

                echo number_format($net,2);
              @endphp
              </u></b>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div> 
  <div class="col-2">
  </div>
</div> 
@endsection

