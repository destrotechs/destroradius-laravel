@extends('layouts.master')
@section('content_header')
Clean stale connections
@endsection
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>{{ session('error') }}</strong> 
</div>
@endif
<div class="card card-body" style="width: 40em;">
	<p>Enter Access Code here and click clean</p>
	<div class="dropdown-divider"></div>
	<form method="post" action="{{ route('clean.stale') }}">
		<label>Access Code</label>
		<input type="text" required class="form-control" name="username" placeholder="enter access code">
		<span class="usernames"></span>
		<hr>
		<button class="btn btn-success" type="submit">clean</button>
		@csrf
	</form>
</div>
@endsection