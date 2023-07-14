@extends('layouts.app')

@section('content')
<div class="row">
  
  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forHRS" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Positions</p>
              <p class="card-title">{{ count($positions) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('settings/positions') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
 
  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPAT" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Rooms</p>
              <p class="card-title">{{ count($rooms) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('settings/rooms') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">User Accounts</p>
              <p class="card-title">{{ count($users) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('user-accounts') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPatient forBLL" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">
                @if(Auth::User()->account_type == 3)
                  Total Bill
                @else
                  Receivables
                @endif
              </p>
              <p class="card-title">P {{ number_format($bills->sumSubTotal,2) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          @if(Auth::User()->account_type == 3)
          <a href="{{ url('patients/profile/'.Auth::User()->user_id) }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
          @else
          <a href="{{ url('billings') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forHRS" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Employees</p>
              <p class="card-title">{{ count($employees) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('employees') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div> --}}

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forHRS" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Professions</p>
              <p class="card-title">{{ count($professions) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('settings/professions') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPAT forMED forNRS forPHR forLAB forXRY forBLL" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">In Patients</p>
              <p class="card-title">{{ count($patients->WHERE('patient_stat','ADM')) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('patients') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPHR forPAT forMED forNRS forBLL" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Out Patients</p>
              <p class="card-title">{{ count($patients->WHERE('patient_stat','OPD')) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('patients') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPatient forPAT forMED forNRS" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Appointments</p>
              <p class="card-title">{{ count($appointments) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          @if(Auth::User()->account_type == 3)
          <a href="{{ url('patients/profile/'.Auth::User()->user_id) }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
          @else
          <a href="{{ url('patients') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPatient forLAB" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Lab Requests</p>
              <p class="card-title">{{ count($requests->WHERE('category_id',2)) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('lab-requests') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPatient forXRY" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">X-Ray Requests</p>
              <p class="card-title">{{ count($requests->WHERE('category_id',3)) }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of {{ Carbon\Carbon::now()->toFormattedDateString() }}
          <a href="{{ url('xray-requests') }}" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>    
@endsection