@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-body ">
            <div id='calendar' style="width: 100%"></div>
        </div>
    </div>
  </div>
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
