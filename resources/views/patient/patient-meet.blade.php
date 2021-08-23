@extends('layouts.app')

@section('styles')
<style>
html,body {
  height: 100%;
}
</style>
@endsection
@section('content')

<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
      <div class="card h-100" id="app">
        <jitsi/>
    </div>
  </div>
</div>
@endsection

