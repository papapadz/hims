@extends('layouts.app')

@section('styles')
<style type="text/css">
  .bordered {
    border; solid;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>
          <button class="btn btn-sm btn-warning btn-fab btn-icon btn-round float-right" onclick="printThis('dtrPrint','Batch Print','','5')"><i class="fa fa-print"></i></button>
        </h4>
      </div>
      <div class="card-body" id="dtrPrint">
        <div class="row">
          @foreach($employees as $employee)
          <div class="col-4 mr-3">
            <table style="width: 100%;">
              <tr>
                <td colspan="9"><b>DAILY TIME RECORD</b></td>
              </tr>
              <tr>
                <td><b>EMPLOYEE NO.</b></td>
                <td colspan="3">{{ $employee->emp_no }}</td>
                <td></td>
                <td><b>FOR THE PERIOD</b></td>
                <td colspan="3">
                  @php
                    $date = Carbon\Carbon::parse($dtr_date);
                  @endphp
                  {{ $date->monthName }} {{ $date->startOfMonth()->day }} - {{ $date->endOfMonth()->day }} {{ $date->year }}
                </td>
              </tr>
              <tr>
                <td><b>NAME</b></td>
                <td colspan="3">{{ $employee->last_name }}, {{ $employee->first_name }} {{ $employee->middle_name[0] }}</td>
                <td></td>
                <td><b>POSITION</b></td>
                <td colspan="3">{{ $employee->position }}</td>
              </tr>
              <tr>
                <td><b>DEPARTMENT</b></td>
                <td colspan="3">{{ $employee->department }}</td>
                <td></td>
                <td><b>ACCOUNT NO.</b></td>
                <td colspan="3">{{ $employee->acct_no }}</td>
              </tr>
            </table>
            <table style="width: 100%" class="table-bordered">
              <tr class="bordered">
                <td rowspan="2" class="bordered"><center>DAYS</center></td>
                <td colspan="2" class="bordered"><center>MORNING</center></td>
                <td colspan="2" class="bordered"><center>AFTERNOON</center></td>
                <td colspan="2" class="bordered"><center>OVERTIME</center></td>
                <td class="bordered"><center>DAILY</center></td>
                <td class="bordered"><center>DAILY</center></td>
              </tr>
              <tr class="bordered">
                <td class="bordered" style="width: 10%"><center>IN</center></td>
                <td class="bordered" style="width: 10%"><center>OUT</center></td>
                <td class="bordered" style="width: 10%"><center>IN</center></td>
                <td class="bordered" style="width: 10%"><center>OUT</center></td>
                <td class="bordered" style="width: 10%"><center>IN</center></td>
                <td class="bordered" style="width: 10%"><center>OUT</center></td>
                <td class="bordered" style="width: 15%"><center>TOTAL (HRS)</center></td>
                <td class="bordered" style="width: 15%"><center>OT (HRS)</center></td>
              </tr>
              @php
              $i = 1;
              $overallHrs = 0;
              $overallOt = 0;
              @endphp
              @foreach($attendances->where('emp_no',$employee->emp_no) as $k => $attendance)
                
                @while(Carbon\Carbon::parse($attendance->dtr_date)->day != $i && $i<=31)
                  <tr class="bordered">
                    <td class="bordered"><center>{{ $i++ }}</center></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td>
                  </tr>
                @endwhile

                @if(Carbon\Carbon::parse($attendance->dtr_date)->day == $i)
                  <tr class="bordered">
                  <td class="bordered"><center>{{ $i++ }}</center></td>
                  <td class="bordered">
                    <center>
                    @if($attendance->timein_am!=null)
                      {{ Carbon\Carbon::parse($attendance->timein_am)->format('h:i A') }}
                    @endif
                    </center>
                  </td>
                  <td class="bordered">
                    <center>
                    @if($attendance->timeout_am!=null)
                      {{ Carbon\Carbon::parse($attendance->timeout_am)->format('h:i A') }}
                    @endif
                    </center>
                  </td>
                  <td class="bordered">
                    <center>
                    @if($attendance->timein_pm!=null)
                      {{ Carbon\Carbon::parse($attendance->timein_pm)->format('h:i A') }}
                    @endif
                    </center>
                  </td class="bordered">
                  <td class="bordered">
                    <center>
                    @if($attendance->timeout_pm!=null)
                      {{ Carbon\Carbon::parse($attendance->timeout_pm)->format('h:i A') }}
                    @endif
                    </center>
                  </td>
                  <td class="bordered">
                    <center>
                    @if($attendance->timein_ot!=null)
                      {{ Carbon\Carbon::parse($attendance->timein_ot)->format('h:i A') }}
                    @endif
                    </center>
                  </td>
                  <td class="bordered">
                    <center>
                    @if($attendance->timeout_ot!=null)
                      {{ Carbon\Carbon::parse($attendance->timeout_ot)->format('h:i A') }}
                    @endif
                    </center>
                  </td>
                  <td class="bordered"><center>{{ $attendance->total_hrs }}</center></td>
                  <td class="bordered"><center>{{ $attendance->total_ot }}</center></td>
                </tr>
                @php
                  $overallHrs = $overallHrs + $attendance->total_hrs;
                  $overallOt = $overallOt + $attendance->total_ot;
                @endphp
                @endif

                @if($k==count($attendances->where('emp_no',$employee->emp_no))-1 && $i<31)
                  
                  @while($i<=31)
                    <tr class="bordered">
                      <td class="bordered"><center>{{ $i++ }}</center></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td><td class="bordered"></td>
                    </tr>
                  @endwhile
                @endif
              @endforeach
              <tr class="bordered">
                <td class="bordered"></td>
                <td class="bordered" colspan="2"><b>Total Hrs:</b></td>
                <td class="bordered" colspan="2"> {{ $overallHrs }}</td>
                <td class="bordered" colspan="2"><b>Total OT:</b></td> 
                <td class="bordered" colspan="2"> {{ $overallOt }}</td>
              </tr>
              </tr>
            </table>
            <br>
            <h6>REMARKS</h6>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div> 
@endsection

