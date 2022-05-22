@extends('layouts.master')

@section('content_header')
New Manager

@endsection
@section('content')
<div class="card">
<div class="card-header">Add new manager</div>
<div class="card-body">
<form action="{{ route('manager.new') }}" method="post"> 
<div class="row">
	
	<div class="col-md-6">

	@if($errors->count()>0)
	<div class="alert alert-danger">
	@foreach ($errors->all() as $message)
    <p><i class="fas fa-circle"></i>&nbsp;{{ $message }}</p>
    @endforeach
    </div>
    @endif
	@csrf
	<label for="exampleDataList" class="form-label">Full Name</label>
	<input type="text" class="form-control" name="fullname" placeholder="Manager name...">
	<label for="exampleDataList" class="form-label">Email</label>
	<input type="email" class="form-control" name="email" placeholder="Manager name...">
	<label for="exampleDataList" class="form-label">Password</label>
	<input type="password" class="form-control" name="password" placeholder="********">
	<div class="form-inline">
		<label>Super Admin?</label>&nbsp;&nbsp;
		<input type="checkbox" name="is_admin" value="1" class="form-check">
	</div>
	<hr>
	<button type="submit" class="btn btn-success btn-md"><i class="fas fa-save"></i> &nbsp;Save</button>

</div>

<div class="col-md-6">
	<label for="exampleDataList" class="form-label">Contact Phone</label>
	<input type="text" class="form-control" name="phone" placeholder="Manager's phone...">
	<label for="exampleDataList" class="form-label">City</label>
	<input type="text" class="form-control" name="city" placeholder="Manager's city...">
	<label for="exampleDataList" class="form-label">Address</label>
	<input type="text" class="form-control" name="address" placeholder="Manager's address...">
</div>
</form>
</div>
</div>
@endsection