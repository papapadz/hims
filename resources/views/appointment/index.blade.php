@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <button type="button" class="btn btn-primary btn-round float-center forAdmin forPAT" data-toggle="modal" data-target="#modalAddAppointment">
      Add Appointment
    </button>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-body ">
            <div id='calendar' style="width: 100%"></div>
        </div>
    </div>
  </div>
</div>
<form action="{{ url('consult/add-appointment') }}" method="POST">
  @csrf
  <input type="text" name="hosp_no" value="{{ $hosp_no }}" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAddAppointment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Schedule Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-12">
              <label>Doctor</label>
              <select class="form-control" name="emp_no">
                @foreach($employees as $employee)
                  <option value="{{ $employee->emp_no }}">{{ $employee->last_name }}, {{ $employee->first_name }} {{ $employee->middle_name[0] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
              <div class="col-12">
                <label>Date</label>
                <input type="date" name="consult_date" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label>Time</label>
                <input type="time" name="consult_time" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label>Remarks</label>
                <textarea class="form-control" name="appointment_remarks"></textarea>
              </div>
            </div>
        </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            dayMaxEventRows: true, // for all non-TimeGrid views
            views: {
                timeGrid: {
                dayMaxEventRows: 6 // adjust to 6 only for timeGridWeek/timeGridDay
                }
            },
            headerToolbar: {
                center: 'dayGridMonth,dayGridWeek,listWeek' // buttons for switching between views
            },
            events: "{{ url('appointment-calendar') }}",
            eventClick:function(data) {
                console.log(data)
                window.location.replace('{{ url("patients/profile")}}/'+data.event.id)
            }
          });
          calendar.render();
        });

</script>
@endsection
