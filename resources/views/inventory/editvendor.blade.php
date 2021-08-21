@extends('layouts.master')

@section('content_header')
Edit Vendor
@endsection
@section('content')
<div class="row">
	<div class="col-md-7">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<div class="card">
			<div class="card-header">
				Edit
			</div>
			<div class="card-body">
				<form method="post" action="{{ route('vendor.post.edit') }}">
					@csrf
					<input type="hidden" name="id" value="{{ $vendor->id }}">
					<label>Vendor</label>
					<input type="text" name="vendor" class="form-control" placeholder="vendor name ..." value="{{ $vendor->vendor }}">
					<label>Description</label>
					<textarea class="form-control" name="description">	{{ $vendor->description }}					
					</textarea>
					<hr>
					<button class="btn btn-success"><i class="fas fa-save"></i>&nbsp;save changes</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-5"></div>
</div>
@endsection