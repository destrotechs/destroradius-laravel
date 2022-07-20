@extends('layouts.master')
@section('content_header')
Edit supplier
@endsection
@section('content')
<div class="row">
	<div class="col-md-7">
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
		<div class="card">
			<div class="card-header">
		    Edit
		  </div>
		  <div class="card-body">
			<form method="post" action="{{ route('supplier.post.edit') }}">
				@csrf
				<div class="row">
					<div class="col">
						<label>Name</label>
						<input type="text" name="name" class="form-control sm" placeholder="supplier name ..." value="{{ $supplier->supplier_name }}">
					</div>
					<div class="col">
						<label>Address</label>
						<input type="text" name="address" class="form-control sm" placeholder="supplier address ..." value="{{ $supplier->address }}">
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label>Contact</label>
						<input type="text" name="contact" class="form-control sm" placeholder="supplier contact ..." value="{{ $supplier->contact }}">
					</div>
					<div class="col">
						<label>Phone</label>
						<input type="text" name="phone" class="form-control sm" placeholder="supplier phone ..." value="{{ $supplier->phone }}">
					</div>
				</div>
				<input type="hidden" name="id" value="{{ $supplier->id }}">
				<div class="row">
					<div class="col">
						<label>Email</label>
						<input type="email" name="email" class="form-control" placeholder="supplier email..." value="{{ $supplier->email }}">
					</div>
					<div class="col">
						<label>Zip Code</label>
						<input type="text" name="zipcode" class="form-control" value="{{ $supplier->zipcode }}" placeholder="zip code...">
					</div>
				</div>
				<div class="row col">
					<label>Description</label>
					<textarea class="form-control" name="description">{{ $supplier->description }}</textarea>
				</div>
				<hr>
				<button class="btn btn-success btn-md"><i class="fas fa-save"></i> Save changes</button>
			</form>
		</div>
		</div>
	</div>
</div>
@endsection