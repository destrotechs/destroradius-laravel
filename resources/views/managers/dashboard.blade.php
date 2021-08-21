@extends('layouts.master')
@section('content_header')
Manager dashboard
@endsection

@section('content')
@if (session('message'))
<div class="alert alert-warning">
{{ session('message') }}
</div>
@endif
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Welcome {{ Auth::user()->name }}</h1>
    <p class="lead">Manage your zone customers easily with destroradius.</p>
  </div>
</div>
@endsection