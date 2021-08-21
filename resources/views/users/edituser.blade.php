@extends('layouts.master')

@section('content_header')
Edit user
@stop
@section('content')
<div class="card">
	@if (session('message'))
			    <div class="alert alert-success">
			        {{ session('message') }}
			    </div>
			@endif
			@if (session('error'))
			    <div class="alert alert-danger">
			        {{ session('error') }}
			    </div>
			@endif
	<div class="card-header"></div>
	<div class="card-body">
		<form method="POST" action="{{ route('getspecificuser') }}">
			<div class="form-row">
			<div class="col">
				<input type="text" name="username" class="form-control"placeholder="Enter username">
				<div class="usernamecontainer"></div>
			</div>
			<div class="col">
				<button class="btn btn-primary btn-md" type="submit"><i class="fas fa-search"></i> Search</button>
			</div>
			</div>
			@csrf
		</form>
	</div>
</div>
@stop