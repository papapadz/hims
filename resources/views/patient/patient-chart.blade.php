@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-2">
  </div>
  <div class="col-8">
    <div class="card">
      <div class="card-header">
        <h4>
          Patient Chart for Consultation No. {{ $patient->consult_id }} 
          <button class="btn btn-sm btn-warning btn-fab btn-icon btn-round float-right" onclick="printThis('patientChartPrint','{{ $patient->consult_id }}','','1')"><i class="fa fa-print"></i></button>
        </h4>
      </div>
      <div class="card-body" id="patientChartPrint">
        <table class="table">
          <tr>
            <td rowspan="2" style="width: 50%"> 
              <img class="card-img-top" style="width: 100px;" src="{{ asset('assets/img/faces/'.$patient->profile_img) }}" alt="Card image cap">
            </td>
            <td>
              <b>Hospital No: </b> {{ $patient->hosp_no }}
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <b>Name of Patient: </b> {{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }}
            </td>
          </tr>
          <tr>
            <td>
              <b>Date of Birth: </b> {{ $patient->birthdate }}
            </td>
            <td>
              <b>Age: </b> {{ Carbon\Carbon::now()->diffInYears($patient->birthdate) }} yrs old
            </td>
          </tr>
          <tr>
            <td>
              <b>Gender: </b> {{ $patient->gender }}
            </td>
            <td>
              <b>Civil Status: </b> {{ $patient->civil_stat }}
            </td>
          </tr>
          <tr>
            <td>
              <b>Date of Consultation: </b> {{ Carbon\Carbon::parse($patient->create_at)->toFormattedDateString() }}
            </td>
            <td>
              <b>Ward\Room\Clinic: </b> {{ $patient->room }}
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <b>Complaint: </b> {{ $patient->complaint }}
            </td>
          </tr>
          <tr>
            <td>
              <b>Diagnosis:</b>
            </td>
            <td>
              @foreach($diagnosis as $diag)
                {{ Carbon\Carbon::parse($diag->created_at)->toDateString() }}
                {{ $diag->diagnosis }}<br>
                - {{ $diag->last_name }}, {{ $diag->first_name }}
              @endforeach
            </td>
          </tr>
          <tr>
            <td>
              <b>Lab/Radiology Results</b>
            </td>
            <td>
              @foreach($results as $result)
                {{ Carbon\Carbon::parse($result->created_at)->toDateString() }}
                {{ $result->supply }}<br>
                {{ $result->result }}
              @endforeach
            </td>
          </tr>
          <tr>
            <td>
              <b>Prescriptions</b>
            </td>
            <td>
              @foreach($prescriptions as $presc)
                {{ Carbon\Carbon::parse($presc->created_at)->toDateString() }}
                {{ $presc->prescription }}<br>
                - {{ $presc->last_name }}, {{ $presc->first_name }}
              @endforeach
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

