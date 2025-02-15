@extends('layouts.master')

@section('content_header')
Edit Manager

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
<div class="card-header">Edit manager</div>
<div class="card-body">
	@foreach($manager as $m)
<form action="{{ route('manager.edit.post') }}" method="post"> 
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
	<input type="text" class="form-control" name="fullname" placeholder="Manager name..." value="{{ $m->name }}">
	<label for="exampleDataList" class="form-label">Email</label>
	<input type="email" class="form-control" name="email" placeholder="Manager name..." value="{{ $m->email }}">
	<label for="exampleDataList" class="form-label">Password</label>
	<input type="password" class="form-control" name="password" placeholder="********" value="{{ $m->name }}">
	@if( $m->role_id==1)
	<div class="form-inline">
		<label>Super Admin?</label>&nbsp;&nbsp;
		<input type="checkbox" name="is_admin" value="1" class="form-check" checked>
	</div>
	@else
	<div class="form-inline">
		<label>Super Admin?</label>&nbsp;&nbsp;
		<input type="checkbox" name="is_admin" value="1" class="form-check">
	</div>
	@endif

</div>

<div class="col-md-6">
	<label for="exampleDataList" class="form-label">Contact Phone</label>
	<input type="hidden" name="id" value="{{ $m->id }}">
	<input type="text" class="form-control" name="phone" placeholder="Manager's phone..."  value="{{ $m->phone }}">
	<label for="exampleDataList" class="form-label">City</label>
	<input type="text" class="form-control" name="city" placeholder="Manager's city..."  value="{{ $m->city }}">
	<label for="exampleDataList" class="form-label">Address</label>
	<input type="text" class="form-control" name="address" placeholder="Manager's address..."  value="{{ $m->address }}">
	

</div>
</div>
<hr>
	<button type="submit" class="btn btn-success btn-md"><i class="fas fa-save"></i> &nbsp;Save changes</button>
</form>
@endforeach
</div>
</div>
@endsection