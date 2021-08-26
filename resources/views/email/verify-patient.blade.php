@component('mail::message')

<i>Congratulations! We have verified your registration, you can now create an account to access our system. Click the button below to create your account.</i>

@component('mail::panel')

@component('mail::promotion')

<div style="font-size: 2rem; text-align:center">
    <b style="color: green;">VERIFIED</b>
</div>
@endcomponent
<ul class="list-group list-group-flush">
    <li>Patient Name: <b>{{ $data['name'] }}</b></li>
    <li>Date registered: <b>{{ $data['registration_date'] }}</b></li>
</ul>

@component('mail::button', ['url' => $data['link'], 'color' => 'success'])
    Create Acoount Now
@endcomponent

@endcomponent

@endcomponent
