@extends('layouts.master')

@section('content_header')
New Manager

@endsection
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="card">
<div class="card-header">Add new manager</div>
<div class="card-body">
<form action="{{ route('manager.new') }}" method="post"> 

	@if($errors->count()>0)
	<div class="alert alert-danger">
	@foreach ($errors->all() as $message)
    <p><i class="fas fa-circle"></i>&nbsp;{{ $message }}</p>
    @endforeach
    </div>
    @endif
	@csrf
<div class="form-row">	
	<div class="col-md-6 col-sm-12">
	<label for="exampleDataList" class="form-label">Full Name</label>
	<input type="text" class="form-control" name="fullname" placeholder="Manager name...">
	</div>
	<div class="col-md-6 col-sm-12">

	<label for="exampleDataList" class="form-label">Email</label>
	<input type="email" class="form-control" name="email" placeholder="Manager name...">
</div>
</div>
<div class="form-row">
	<div class="col-md-12 col-sm-12">

	<label for="exampleDataList" class="form-label">Address</label>
	<input type="text" class="form-control" name="address" placeholder="Manager's address...">
	</div>
	
	
</div>

<div class="form-row">
<div class="col-md-6 col-sm-12">

	<label for="exampleDataList" class="form-label">Contact Phone</label>
	<input type="text" class="form-control" name="phone" placeholder="Manager's phone...">
</div>
<div class="col-md-6 col-sm-12">

	<label for="exampleDataList" class="form-label">City</label>
	<input type="text" class="form-control" name="city" placeholder="Manager's city...">
	</div>
</div>
<div class="form-row">

	<div class="col-md-12 col-sm-12">

	<label for="exampleDataList" class="form-label">Password</label>
	<input type="password" class="form-control" name="password" placeholder="********">
	</div>
</div>
<div class="form-row">

	<div class="col-md-12 col-sm-12 mt-2">

	<div class="form-check">
	  <input class="form-check-input" name="is_admin" type="checkbox" value="1" id="flexCheckChecked">
	  <label class="form-check-label" for="flexCheckChecked">
	    Is Superadmin
	  </label>
	</div>
	</div>
</div>
<hr>
<div class="form-row">
	<div class="col-md-6 col-sm-12">

	<button type="submit" class="btn btn-success btn-md"><i class="fas fa-save"></i> &nbsp;Save</button>
</div>

</div>
</div>
</form>
</div>
</div>
@endsection