@extends('layouts.master')
@section('buttons')

@endsection
@section('content_header')
Company Details
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<form method="post" action="{{ route('company.details.post') }}">
			<div class="form-row">
				<div class="col-md-6 col-sm-12">
					<label>Company Name</label>
					<input type="text" name="name" class="form-control" value="{{ $details->name??'' }}" placeholder="Company Name" required>
				</div>
				
				<div class="col-md-6 col-sm-12">
					<label>Address</label>
					<input type="text" name="address" value="{{ $details->address??'' }}" class="form-control" placeholder="123 Main Street" required>
				</div>	
			</div>
			<div class="form-row">
				<div class="col-md-6 col-sm-12">
					<label>Location/Building</label>
					<input type="text" name="building" value="{{ $details->building??'' }}" class="form-control" placeholder="Location or Building" required>
				</div>			
				<div class="col-md-6 col-sm-12">
					<label>Main Phone</label>
					<input type="text" name="phone" value="{{ $value->phone??'' }}" class="form-control" placeholder="Contact phone">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 col-sm-12">
					<label>Address 2</label>
					<input type="text" name="address2" value="{{ $details->address2??'' }}" class="form-control" placeholder="Address Two">
				</div>
				<div class="col-md-6 col-sm-12">
					<label>City</label>
					<input type="text" name="city" value="{{ $details->city??'' }}" class="form-control" placeholder="City">
				</div>
				
			</div>
		
		
	</div>
	<div class="card-footer">
		<button class="btn btn-md btn-success" type="submit">Save Details</button>
	</div>
	@csrf
	</form>
</div>
@endsection