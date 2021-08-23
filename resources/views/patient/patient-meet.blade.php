@extends('layouts.app')

@section('styles')
<style>
  #app {
    width: 95%; 
    height: 80%;
    position: absolute
  }
</style>
@endsection

@section('content')

<div id="app">
  <jitsi
    room = '{{ $room }}'
    name = '{{ Auth::user()->employeeInfo->first_name}} {{ Auth::user()->employeeInfo->last_name }}'  
  />
</div>
@endsection

