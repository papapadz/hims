@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
    name = '{{ $name }}'  
  />
</div>
@endsection

@section('script')
<script src="{{ asset('js/app.js') }}" ></script>
@endsection
