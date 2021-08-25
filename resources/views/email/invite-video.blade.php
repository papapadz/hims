@component('mail::message')

<i>Hi! Your doctor is waiting for you in the lobby for a videoconference. Click the button below to join</i>

@component('mail::panel')

@component('mail::promotion')

<div style="font-size: 2rem; text-align:center">
    <b style="color: green;">JOIN NOW</b>
</div>
@endcomponent
<ul class="list-group list-group-flush">
    <li>Patient Name: <b>{{ $data['name'] }}</b></li>
    <li>Date of Appointment: <b>{{ $data['appointment_date'] }}</b></li>
    <li>Doctor: <b>{{ $data['doctor'] }}</b></li>
</ul>

@component('mail::button', ['url' => $data['link'], 'color' => 'success'])
    Join Video Call
@endcomponent

@endcomponent

@endcomponent
